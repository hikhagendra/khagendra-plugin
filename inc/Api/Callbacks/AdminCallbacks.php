<?php
/*
    @package KhagendraPlugin
*/

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class AdminCallbacks extends BaseController {
    public function adminDashboard()
    {
        return require_once( "$this->plugin_path/templates/admin.php" );
    }

    public function cpt()
    {
        return require_once( "$this->plugin_path/templates/cpt.php" );
    }

    public function taxonomy()
    {
        return require_once( "$this->plugin_path/templates/taxonomy.php" );
    }

    public function widget()
    {
        return require_once( "$this->plugin_path/templates/widget.php" );
    }

    public function khagendraOptionsGroup( $input ) {
        return $input;
    }

    public function khagendraAdminSection() {
        echo 'Check this beautiful section';
    }

    public function khagendraTextExample() {
        $value = esc_attr( get_option( 'text_example' ) );
        echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeholder="Write something">';
    }

    public function khagendraFirstName() {
        $value = esc_attr( get_option( 'first_name' ) );
        echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="First Name">';
    }
}