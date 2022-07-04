<?php
/*
    @package KhagendraPlugin
*/

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class Admin extends BaseController {
    public $settings;
    public $pages;

    public function __construct() {
        $this->settings = new SettingsApi();
        $this->pages = array(
            array(
                'page_title'    =>  'Khagendra Plugin',
                'menu_title'    =>  'Khagendra',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'khagendra_plugin',
                'callback'      =>  function() {
                    echo '<h1>Khagendra Plugin</h1>';
                },
                'icon_url'      =>  'dashicons-store',
                'position'      =>  110
            )
        );
    }
    
    public function register() {
        $this->settings->addPages( $this->pages )->register();
    }

}