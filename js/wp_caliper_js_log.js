jQuery(document).ready( function($) {
    $('a').click(function() {
        var targetPath = $(this).attr('href').replace(/\?.*|\#.*/, "");
        var localBasePath = wp_caliper_link_log_object.site_url.replace(/^https?:\/\//, "");

        // is onsite if contains base url or if there is no protocol (relative path)
        var onsite = targetPath.includes(localBasePath) || ! /^[a-zA-Z0-9]*:?\/\//.test(targetPath);
        // check if targetPath is onsite and if so if target is html/php page or not
        if (onsite && /^$|\.php|\.html$|\/$|\/[^.]+$/.test(targetPath)) {
            // don't track onsite html click events
            return;
        }

        var data = new FormData();
        data.append('action', "wp_caliper_log_link_click");
        data.append('click_url_requested', $(this).attr('href'));
        data.append('security', wp_caliper_link_log_object.security);
        navigator.sendBeacon(wp_caliper_link_log_object.url, data);
	});
});
