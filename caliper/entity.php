<?php
namespace WPCaliperPlugin\caliper;

use WPCaliperPlugin\caliper\CaliperSensor;
use WPCaliperPlugin\caliper\ResourceIRI;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\EntityType;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\Message;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\entities\reading\WebPage;
use IMSGlobal\Caliper\entities\reading\Document;

class CaliperEntity {
	public static function wordPress() {
		global $wp_version;

		$edu_app = ( new SoftwareApplication( ResourceIRI::wordPress() ) )
			->setName( 'WordPress' )
			->setVersion( $wp_version );

		return $edu_app;
	}

	public static function session( \WP_User &$user ) {
		$session_id = $user->ID ? wp_get_session_token() : wp_generate_uuid4();

		$session = ( new Session( ResourceIRI::user_session( $session_id ) ) )
			->setUser( CaliperActor::generateActor( $user ) );

		return $session;
	}

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
		$post_entity->setDateModified( \DateTime::createFromFormat( "Y-m-d H:i:s", $post->post_modified ) );
		$post_entity->setDateCreated( \DateTime::createFromFormat( "Y-m-d H:i:s", $post->post_date ) );

		// Set author if exists.
		$author = get_userdata( $post->post_author );
		if ( $author ) {
			$post_entity->setCreators( [ CaliperActor::generateActor( $author ) ] );
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
			$extensions['badgeClass']  = ResourceIRI::badgeClass( $post->ID );
			$extensions['badgeIssuer'] = ResourceIRI::badgeIssuer();
			$extensions['badgeImage']  = ResourceIRI::badgeImage( $post->ID );
		} elseif ( 'attachment' === $post_type ) {
			$mime_type = get_post_mime_type( $post->ID );
			if ( $mime_type ) {
				$post_entity->setMediaType( $mime_type );
			}
		}

		$post_entity->setExtensions( $extensions );

		return $post_entity;
	}


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
			$comment_entity->setCreators( [ CaliperActor::generateActor( $author ) ] );
		}

		// Set comment parent if exists.
		$comment_parent = get_comment( $comment->comment_post_ID );
		if ( $comment_parent ) {
			$comment_entity->setReplyTo( CaliperEntity::commentStub( $comment_parent ) );
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

	public static function commentStub( $comment ) {
		// Setup the post entity.
		$comment_entity = ( new Message( ResourceIRI::comment( intval( $comment->comment_post_ID ), intval( $comment->comment_ID ) ) ) );
		return $comment_entity;
	}

	public static function webpage( $absolute_url ) {
		if ( ! is_string( $absolute_url ) ) {
			throw new \InvalidArgumentException( __METHOD__ . ': string expected' );
		}
		$web_page = ( new WebPage( ResourceIRI::webpage( $absolute_url ) ) );

		return $web_page;
	}
}