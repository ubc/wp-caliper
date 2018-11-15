# wp-caliper

Sends Caliper events to LRS (tested against IMS Global Learning Consortium Member Caliper Analytics™
Conformance Test Suite). Some features are ONLY enabled if the dependent plugins have also been installed.
The plugin can be used as a MU plugin as well.

### Setup Plugin

See [readme.txt](readme.txt) for setup instructions.


### Settings

`WP_CALIPER_DEFAULT_ACTOR_HOMEPAGE` set the base url for the Caliper actor's IRI (default `http://www.ubc.ca`).

`WP_CALIPER_DEFAULT_ACTOR_IDENTIFIER` set the field name to fetch for getting the actor's unique identifier for the IRI (default `puid`).

`WP_CALIPER_MAX_SENDING_TRIES` number of retries when trying to send failed Caliper events from the queue (default `15`). If retry limit is reached, the event is discarded.

`WP_CALIPER_QUEUE_TABLE_NAME` name of the Caliper queue table (default `wp_caliper_queue`). Will be pre-pended by the wordpress db `base_prefix`.

### Filters

`wp_caliper_actor_homepage` alternative way to set the base url for the Caliper actor's IRI.

`wp_caliper_actor_identifier` alternative way to set the actor's unique identifier (not limited to user meta data).

`wp_caliper_actor` alternative way to set the entire Caliper actor object.