<?php
/**
 * Think of this class as a "queue row object" class
 *
 * @package wp-caliper
 */

namespace WPCaliperPlugin;

/**
 * WP_Caliper_Queue_Job retry queue
 */
class WP_Caliper_Queue_Job {
	/**
	 * Stores table name
	 *
	 * @var $table_name
	 */
	public $table_name;
	/**
	 * Stores id
	 *
	 * @var $id
	 */
	public $id = null;
	/**
	 * Stores tries
	 *
	 * @var $tries
	 */
	public $tries = 1;
	/**
	 * Stores last try time
	 *
	 * @var $last_try_time
	 */
	public $last_try_time = null;
	/**
	 * Stores event string
	 *
	 * @var $event
	 */
	public $event = null;
	/**
	 * Stores blog id
	 *
	 * @var $blog_id
	 */
	public $blog_id = null;
	/**
	 * Stores created time
	 *
	 * @var $created
	 */
	public $created = null;

	/**
	 * Creates a WP_Caliper_Queue_Job instance minimally requires table_name
	 */
	public function __construct() {
		$this->table_name    = self::get_table_name();
		$this->last_try_time = gmdate( 'Y-m-d H:i:s' );
	}

	/**
	 * Get the table name for the Caliper Queue
	 */
	public static function get_table_name() {
		global $wpdb;
		return $wpdb->base_prefix . esc_sql( WP_CALIPER_QUEUE_TABLE_NAME );
	}

	/**
	 * Gets a single row from the top of the queue
	 *
	 * This function does a SELECT and then DELETE from that row.
	 *
	 * @return mixed if no rows, return false, else a queue object
	 */
	public static function get_row() {
		global $wpdb;
		$table_name = self::get_table_name();

		// Get a row ( if there are any ).
		$row = $wpdb->get_row( "SELECT * FROM {$table_name} ORDER BY id ASC limit 1" );

		// Ensure something is returned.
		if ( empty( $row ) ) {
			return false;
		}

		// setup a queue object using the row data.
		$instance                = new self();
		$instance->id            = $row->id;
		$instance->tries         = $row->tries;
		$instance->last_try_time = $row->last_try_time;
		$instance->event         = $row->event;
		$instance->blog_id       = $row->blog_id;
		$instance->created       = $data->created;

		// now delete the row we pulled.
		if ( false !== $instance ) {
			$wpdb->delete( $table_name, array( 'id' => $row->id ), array( '%d' ) );
		}

		return $instance;
	}

	/**
	 * Saves the queue object into queue!
	 *
	 * @return Boolean true if works, false otherwise
	 */
	public function save_new_row() {
		global $wpdb;
		$table_name = self::get_table_name();

		// save to queue.
		return (bool) $wpdb->query(
			$wpdb->prepare(
				"INSERT INTO {$table_name} ( tries, last_try_time, `event`, blog_id )
				 VALUES ( %d, %s, %s, %d )",
				$this->tries,
				$this->last_try_time,
				$this->event,
				$this->blog_id
			)
		);
	}

	/**
	 * Changes the appropriate fields so that another attempt to send is checked.
	 *
	 * @return void returns nothing
	 */
	public function tried_sending_again() {
		$this->tries        += 1;
		$this->last_try_time = gmdate( 'Y-m-d H:i:s' );
	}
}
