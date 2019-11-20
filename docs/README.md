

## Caliper Events


### `wp_caliper_log_link_click`

Hooks: `admin_post_wp_caliper_log_link_click` and `admin_post_nopriv_wp_caliper_log_link_click`

Example: [log_link_click.json](examples/log_link_click.json)

Captures user clicks navigating away from the current WordPress site.


### `wp_caliper_badgeos_award_achievement`

Hooks: `badgeos_award_achievement` from [BadgeOS](https://wordpress.org/plugins/badgeos/) plugin

Example: [badgeos_award_achievement.json](examples/badgeos_award_achievement.json)

Captures when a badge is awarded to a user (not steps or logs) from sites using the BadgeOS plugin.


### `wp_caliper_shutdown`

Hooks: `shutdown`

Example: [shutdown.json](examples/shutdown.json)

Captures page views.


### `wp_caliper_comment_post`

Hooks: `comment_post`

Example: [comment_post.json](examples/comment_post.json)

Captures comment creation events.


### `wp_caliper_edit_comment`

Hooks: `edit_comment`

Example: [edit_comment.json](examples/edit_comment.json)

Captures comment edit events.


### `wp_caliper_transition_comment_status`

Hooks: `edit_comment`

Publish Example: [transition_comment_status_publish.json](examples/transition_comment_status_publish.json)

Unpublish Example: [transition_comment_status_unpublish.json](examples/transition_comment_status_unpublish.json)

Delete Example: [transition_comment_status_delete.json](examples/transition_comment_status_delete.json)

Captures state transitions for comments (published, unpublished, deleted).


### `wp_caliper_pulse_press_vote_up`

Hooks: `pulse_press_vote_up` from PulsePress (https://github.com/ubc/pulsepress/) theme

Example: [pulse_press_vote_up.json](examples/pulse_press_vote_up.json)

Captures up vote actions from sites using the PulsePress theme.


### `wp_caliper_pulse_press_vote_down`

Hooks: `pulse_press_vote_down` from PulsePress (https://github.com/ubc/pulsepress/) theme

Example: [pulse_press_vote_down.json](examples/pulse_press_vote_down.json)

Captures down vote actions from sites using the PulsePress theme.


### `wp_caliper_pulse_press_vote_delete`

Hooks: `pulse_press_vote_delete` from PulsePress (https://github.com/ubc/pulsepress/) theme

Example: [pulse_press_vote_delete.json](examples/pulse_press_vote_delete.json)

Captures vote cancellation actions from sites using the PulsePress theme.


### `wp_caliper_pulse_press_star_add`

Hooks: `pulse_press_star_add` from PulsePress (https://github.com/ubc/pulsepress/) theme

Example: [pulse_press_star_add.json](examples/pulse_press_star_add.json)

Captures staring/favoriting actions from sites using the PulsePress theme.


### `wp_caliper_pulse_press_star_delete`

Hooks: `pulse_press_star_delete` from PulsePress (https://github.com/ubc/pulsepress/) theme

Example: [pulse_press_star_delete.json](examples/pulse_press_star_delete.json)

Captures unstaring/unfavoriting actions from sites using the PulsePress theme.


### `wp_caliper_save_post`

Hooks: `save_post`

Post Creation Example: [save_post_create.json](examples/save_post_create.json)

Post Modification Example: [save_post_edit.json](examples/save_post_edit.json)

Post Revision Creation Example: [save_post_revision_create.json](examples/save_post_revision_create.json)

Captures post creation and modification along with post revision creation events.


### `wp_caliper_transition_post_status`

Hooks: `edit_comment`

Publish Example: [transition_post_status_publish.json](examples/transition_post_status_publish.json)

Unpublish Example: [transition_post_status_unpublish.json](examples/transition_post_status_unpublish.json)

Delete Example: [transition_post_status_delete.json](examples/transition_post_status_delete.json)

Restored Example: [transition_post_status_restored.json](examples/transition_post_status_restored.json)

Captures state transitions for posts (published, unpublished, deleted).


### `wp_caliper_add_attachment`

Hooks: `add_attachment`

Example: [add_attachment.json](examples/add_attachment.json)

Captures attachment creation events.


### `wp_caliper_wp_login`

Hooks: `wp_login`

Example: [wp_login.json](examples/wp_login.json)

Captures user login event.


### `wp_caliper_clear_auth_cookie`

Hooks: `clear_auth_cookie`

Example: [clear_auth_cookie.json](examples/clear_auth_cookie.json)

Captures user logout event.



