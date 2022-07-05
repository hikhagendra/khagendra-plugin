<?php
/*
    @package KhagendraPlugin
*/

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController {
    public $settings;
    public $pages;
    public $subpages;
    public $callbacks;
    
    public function register() {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        $this->setSubpages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
    }

    public function setPages() {
        $this->pages = array(
            array(
                'page_title'    =>  'Khagendra Plugin',
                'menu_title'    =>  'Khagendra',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'khagendra_plugin',
                'callback'      =>  array( $this->callbacks, 'adminDashboard' ),
                'icon_url'      =>  'dashicons-store',
                'position'      =>  110
            )
        );
    }

    public function setSubpages() {
        $this->subpages = array(
            array(
                'parent_slug'   =>  'khagendra_plugin',
                'page_title'    =>  'Custom Post Types',
                'menu_title'    =>  'CPT',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'khagendra_cpt',
                'callback'      =>  array( $this->callbacks, 'cpt' )
            ),
            array(
                'parent_slug'   =>  'khagendra_plugin',
                'page_title'    =>  'Custom Taxonomies',
                'menu_title'    =>  'Taxonomies',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'khagendra_taxonomies',
                'callback'      =>  array( $this->callbacks, 'taxonomy' )
            ),
            array(
                'parent_slug'   =>  'khagendra_plugin',
                'page_title'    =>  'Custom Widgets',
                'menu_title'    =>  'Widgets',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'khagendra_widgets',
                'callback'      =>  array( $this->callbacks, 'widget' )
            )
        );
    }

    public function setSettings() {
        $args = array(
            array(
                'option_group'      =>  'khagendra_options_group',
                'option_name'       =>  'text_example',
                'callback'          =>  array( $this->callbacks, 'khagendraOptionsGroup' )
            ),
            array(
                'option_group'      =>  'khagendra_options_group',
                'option_name'       =>  'first_name'
            )
        );

        $this->settings->setSettings( $args );
    }

    public function setSections() {
        $args = array(
            array(
                'id'            =>  'khagendra_admin_index',
                'title'         =>  'Settings',
                'callback'      =>  array( $this->callbacks, 'khagendraAdminSection' ),
                'page'          =>  'khagendra_plugin'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields() {
        $args = array(
            array(
                'id'            =>  'text_example',
                'title'         =>  'Text Example',
                'callback'      =>  array( $this->callbacks, 'khagendraTextExample' ),
                'page'          =>  'khagendra_plugin',
                'section'       =>  'khagendra_admin_index',
                'args'          =>  array(
                    'label_for' =>  'text_example',
                    'class'     =>  'example_class'
                )
            ),
            array(
                'id'            =>  'first_name',
                'title'         =>  'First Name',
                'callback'      =>  array( $this->callbacks, 'khagendraFirstName' ),
                'page'          =>  'khagendra_plugin',
                'section'       =>  'khagendra_admin_index',
                'args'          =>  array(
                    'label_for' =>  'first_name',
                    'class'     =>  'example_class'
                )
            )
        );

        $this->settings->setFields( $args );
    }

}