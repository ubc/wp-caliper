<?php
/**
 * Collection Caliper Entities
 *
 * @package wp-caliper
 */

namespace WPCaliperPlugin\caliper;

use WPCaliperPlugin\caliper\ResourceIRI;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\Message;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\entities\reading\WebPage;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\feedback\Rating;
use IMSGlobal\Caliper\entities\question\RatingScaleQuestion;
use IMSGlobal\Caliper\entities\scale\LikertScale;


/**
 * Handles Caliper Entities
 */
class CaliperEntity {
	/**
	 * Generates a SoftwareApplication entity
	 */
	public static function word_press() {
		global $wp_version;

		$edu_app = ( new SoftwareApplication( ResourceIRI::word_press() ) )
			->setName( 'WordPress' )
			->setVersion( $wp_version );

		return $edu_app;
	}

	/**
	 * Generates a Session entity
	 *
	 * @param \WP_User $user WordPress User.
	 */
	public static function session( \WP_User &$user ) {
		$session_id = $user->ID ? wp_get_session_token() : wp_generate_uuid4();

		$session = ( new Session( ResourceIRI::user_session( $session_id ) ) )
			->setUser( CaliperActor::generate_actor( $user ) )
			->setClient( CaliperEntity::client( $session_id ) );

		$extensions = array();
		if ( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
			$extensions['referer'] = $_SERVER['HTTP_REFERER'];
		}
		if ( array() !== $extensions ) {
			$session->setExtensions( $extensions );
		}

		return $session;
	}

	/**
	 * Generates a SoftwareApplication entity
	 *
	 * @param string|integer $session_id session id.
	 */
	public static function client( $session_id ) {
		$user_client = ( new SoftwareApplication( ResourceIRI::user_client( $session_id ) ) );

		if ( array_key_exists( 'HTTP_HOST', $_SERVER ) ) {
			$user_client->setHost( $_SERVER['HTTP_HOST'] );
		}

		if ( array_key_exists( 'HTTP_USER_AGENT', $_SERVER ) ) {
			$user_client->setUserAgent( $_SERVER['HTTP_USER_AGENT'] );
		}

		// get ip address if available.
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$user_client->setIpAddress( $_SERVER['HTTP_CLIENT_IP'] );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$user_client->setIpAddress( $_SERVER['HTTP_X_FORWARDED_FOR'] );
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$user_client->setIpAddress( $_SERVER['REMOTE_ADDR'] );
		}

		return $user_client;
	}

	/**
	 * Generates a DigitalResource entity
	 */
	public static function site() {
		global $wp_version;

		$site_entity = ( new DigitalResource( ResourceIRI::site() ) );

		$name = get_bloginfo( 'name' );
		if ( $name ) {
			$site_entity->setName( $name );
		}

		$description = get_bloginfo( 'description' );
		if ( $description ) {
			$site_entity->setDescription( $description );
		}

		return $site_entity;
	}

	/**
	 * Generates a Document/WebPage entity
	 *
	 * @param \WP_Post $post WordPress post object.
	 */
	public static function post( \WP_Post &$post ) {
		/**
		 * Post ( Post Type: 'post' )
		 * Page ( Post Type: 'page' )
		 * Attachment ( Post Type: 'attachment' )
		 * Revision ( Post Type: 'revision' )
		 * Navigation Menu ( Post Type: 'nav_menu_item' )
		 * Custom CSS ( Post Type: 'custom_css' )
		 * Changesets ( Post Type: 'customize_changeset' )
		 * User Data Request ( Post Type: 'user_request' )
		*/
		$post_type = get_post_type( $post );

		// Setup the post entity.
		$post_entity = ( new Document( ResourceIRI::post( $post->ID ) ) );
		if ( 'page' === $post_type || 'post' === $post_type ) {
			$post_entity = ( new WebPage( ResourceIRI::post( $post->ID ) ) );
		}

		// Set shared parameters.
		$post_entity->setIsPartOf( CaliperEntity::site() );
		$post_entity->setName( get_the_title( $post ) );
		$post_entity->setDescription( $post->post_content );
		$post_entity->setDateModified( \DateTime::createFromFormat( 'Y-m-d H:i:s', $post->post_modified ) );
		$post_entity->setDateCreated( \DateTime::createFromFormat( 'Y-m-d H:i:s', $post->post_date ) );

		// Set author if exists.
		$author = get_userdata( $post->post_author );
		if ( $author ) {

			$actor = CaliperActor::generate_actor( $author );

			if ( is_a( $actor, 'IMSGlobal\Caliper\entities\agent\Person' ) ) {
				$post_entity->setCreators( array( $actor ) );
			}
		}

		$extensions = array(
			'post'          => true,
			'permalink'     => get_permalink( $post ),
			'postType'      => $post_type,
			'postStatus'    => $post->post_status,
			'commentStatus' => $post->comment_status,
			'pingStatus'    => $post->ping_status,
			'commentCount'  => $post->comment_count,
			'menuOrder'     => $post->menu_order,
		);
		// Set post parent if exists.
		if ( $post->post_parent ) {
			$extensions['postParent'] = ResourceIRI::post( $post->post_parent );
		}

		// Add extra data based on post type.
		if ( 'badges' === $post_type ) {
			$extensions['badgeClass']  = ResourceIRI::badge_class( $post->ID );
			$extensions['badgeIssuer'] = ResourceIRI::badge_issuer();
			$extensions['badgeImage']  = ResourceIRI::badge_image( $post->ID );
		} elseif ( 'attachment' === $post_type ) {
			$mime_type = get_post_mime_type( $post->ID );
			if ( $mime_type ) {
				$post_entity->setMediaType( $mime_type );
			}
		}

		$post_entity->setExtensions( $extensions );

		return $post_entity;
	}


	/**
	 * Generates a Message entity
	 *
	 * @param \WP_Comment $comment WordPress comment.
	 */
	public static function comment( \WP_Comment &$comment ) {
		$post = get_post( $comment->comment_post_ID );
		// Setup the post entity.
		$comment_entity = ( new Message( ResourceIRI::comment( intval( $comment->comment_post_ID ), intval( $comment->comment_ID ) ) ) )
			->setBody( $comment->comment_content )
			->setDateCreated( \DateTime::createFromFormat( 'Y-m-d H:i:s', $comment->comment_date ) )
			->setIsPartOf( CaliperEntity::post( $post ) );

		// Set author if exists.
		$author = get_userdata( $post->user_id );
		if ( $author ) {
			$comment_entity->setCreators( array( CaliperActor::generate_actor( $author ) ) );
		}

		// Set comment parent if exists.
		$comment_parent = get_comment( $comment->comment_post_ID );
		if ( $comment_parent ) {
			$comment_entity->setReplyTo( CaliperEntity::comment_stub( $comment_parent ) );
		}

		$extensions = array(
			'karma'    => $comment->comment_karma,
			'approved' => $comment->comment_approved,
			'type'     => $comment->comment_type,
		);
		// Set additional author info if exists ( to help potentially identify anonymous users ).
		if ( $comment->comment_author_email ) {
			$extensions['authorEmail'] = $comment->comment_author_email;
		}
		if ( $comment->comment_author_url ) {
			$extensions['authorUrl'] = $comment->comment_author_url;
		}
		if ( $comment->comment_author_IP ) {
			$extensions['authorIP'] = $comment->comment_author_IP;
		}
		if ( $comment->comment_agent ) {
			$extensions['agent'] = $comment->comment_agent;
		}
		$comment_entity->setExtensions( $extensions );

		return $comment_entity;
	}

	/**
	 * Generates a stubbed Message entity
	 *
	 * @param \WP_Comment $comment WordPress comment.
	 */
	public static function comment_stub( $comment ) {
		// Setup the post entity.
		$comment_entity = ( new Message( ResourceIRI::comment( intval( $comment->comment_post_ID ), intval( $comment->comment_ID ) ) ) );
		return $comment_entity;
	}

	/**
	 * Generates a WebPage entity
	 *
	 * @param string $absolute_url absolute url.
	 * @throws \InvalidArgumentException Variable $absolute_url must be a string.
	 */
	public static function webpage( $absolute_url ) {
		if ( ! is_string( $absolute_url ) ) {
			throw new \InvalidArgumentException( __METHOD__ . ': string expected' );
		}
		$web_page = ( new WebPage( ResourceIRI::webpage( $absolute_url ) ) );

		return $web_page;
	}

	/**
	 * Generates a Rating entity
	 *
	 * @param \WP_User $user WordPress User.
	 * @param \WP_Post $post WordPress post.
	 * @param string   $vote vote.
	 */
	public static function pulse_press_vote_rating( \WP_User $user, \WP_Post &$post, $vote ) {
		$rating = ( new Rating( ResourceIRI::pulse_press_vote_rating( $post->ID, $user->ID ) ) )
			->setRater( CaliperActor::generate_actor( $user ) )
			->setRated( CaliperEntity::post( $post ) )
			->setQuestion(
				( new RatingScaleQuestion( ResourceIRI::pulse_press_vote_question() ) )
					->setScale(
						( new LikertScale( ResourceIRI::pulse_press_vote_scale() ) )
							->setScalePoints( 3 )
							->setItemLabels( array( 'Vote Up', 'Unvote', 'Vote Down' ) )
							->setItemValues( array( '1', '0', '-1' ) )
					)
			)
			->setSelections( array( $vote ) );

		return $rating;
	}

	/**
	 * Generates a Rating entity
	 *
	 * @param \WP_User $user WordPress User.
	 * @param \WP_Post $post WordPress post.
	 * @param string   $starred starred.
	 */
	public static function pulse_press_star_rating( \WP_User $user, \WP_Post &$post, $starred ) {
		$rating = ( new Rating( ResourceIRI::pulse_press_star_rating( $post->ID, $user->ID ) ) )
			->setRater( CaliperActor::generate_actor( $user ) )
			->setRated( CaliperEntity::post( $post ) )
			->setQuestion(
				( new RatingScaleQuestion( ResourceIRI::pulse_press_star_question() ) )
					->setScale(
						( new LikertScale( ResourceIRI::pulse_press_star_scale() ) )
							->setScalePoints( 2 )
							->setItemLabels( array( 'Star', 'Unstar' ) )
							->setItemValues( array( 'true', 'false' ) )
					)
			)
			->setSelections( array( $starred ) );

		return $rating;
	}
}
