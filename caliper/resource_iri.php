<?php
namespace WPCaliperPlugin\caliper;

class ResourceIRI {
    public static function getHomeUrl() {
        return home_url();
    }

    public static function getSiteUrl() {
        return site_url();
    }

    public static function getSiteApiUrl() {
        return self::getSiteUrl() . '/' . get_option( 'json_api_base', 'api' );
    }

    public static function currentPageUrl() {
        $page_url = 'http';
        if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
            $page_url .= 's';
        }
        $page_url .= '://';
        if ( isset( $_SERVER['SERVER_PORT'] ) && '443' !== $_SERVER['SERVER_PORT'] &&
             '' !== $_SERVER['SERVER_PORT'] && '80' !== $_SERVER['SERVER_PORT'] ) {
            $page_url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        } else {
            $page_url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }
        return $page_url;
    }

    public static function wordPress() {
        return function_exists( 'network_home_url' ) ? network_home_url() : home_url();
    }

    public static function user_session($session_id) {
        return self::getHomeUrl() . '/session/' . $session_id;
    }

    public static function site($blog_id=NULL) {
        return get_site_url( $blog_id );
    }

    public static function post($post_id) {
        //return get_permalink( $post_id );
        return self::getSiteUrl() . '?p=' . $post_id;
    }

    public static function comment($post_id, $comment_id) {
        return self::post($post_id) . '#comment=' . $comment_id;
    }

    public static function badgeAssertion($assertion_uid) {
        return self::getSiteApiUrl() . '/badge/assertion/?uid=' . $assertion_uid;
    }

    public static function badgeIssuer() {
        return self::getSiteApiUrl() . '/badge/issuer/';
    }

    public static function badgeClass($post_id) {
        return self::getSiteApiUrl() . '/badge/badge_class/?uid=' . $post_id;
    }

    public static function badgeImage($post_id) {
        return wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    }

    public static function webpage($absoluteUrl) {
        return $absoluteUrl;
    }

}