<?php
/*
    @package KhagendraPlugin
*/

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;

class Admin extends BaseController {
    public $settings;
    public $pages;
    public $subpages;
    public $callbacks;
    public $callbacks_mngr;
    
    public function register() {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();
        $this->callbacks_mngr = new ManagerCallbacks();

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
                'option_group'      =>  'khagendra_plugin_settings',
                'option_name'       =>  'khagendra_plugin',
                'callback'          =>  array( $this->callbacks_mngr, 'checkboxSanitize' )
            )
        );

        $this->settings->setSettings( $args );
    }

    public function setSections() {
        $args = array(
            array(
                'id'            =>  'khagendra_admin_index',
                'title'         =>  'Settings',
                'callback'      =>  array( $this->callbacks_mngr, 'adminSectionManager' ),
                'page'          =>  'khagendra_plugin'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields() {
        $args = array();

        foreach($this->managers as $key => $manager) {
            $args[] = array(
                'id'            =>  $key,
                'title'         =>  $manager,
                'callback'      =>  array( $this->callbacks_mngr, 'checkboxField' ),
                'page'          =>  'khagendra_plugin',
                'section'       =>  'khagendra_admin_index',
                'args'          =>  array(
                    'option_name'   =>  'khagendra_plugin',
                    'label_for'     =>  $key,
                    'class'         =>  'ui-toggle'
                )
                );
        }

        $this->settings->setFields( $args );
    }

}