<?php
/*
    @package KhagendraPlugin
*/

namespace Inc\Base;

class Activate {
    public static function activate() {
        flush_rewrite_rules();

        if ( get_option( 'khagendra_plugin' ) ) {
            return;
        }

        $default = array();

        update_option( 'khagendra_plugin', $default );
    }
}