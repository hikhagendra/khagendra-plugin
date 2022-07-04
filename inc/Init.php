<?php
/*
    @package KhagendraPlugin
*/

namespace Inc;

final class init {
    // Store all the classes inside the array
    // return array Full list of classes
    public static function get_services() {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class
        ];
    }

    // Loop through the classes, initialize them
    // and call the register() method if it exist
    public static function register_services() {
        foreach ( self::get_services() as $class ) {
            $service = self::instantiate( $class );
            if ( method_exists( $service, 'register' ) ) {
                $service->register();
            }
        }
    }

    // Initialize the class 
    // @param class $class   class from the services array
    // @return class instance new instance of the class
    private static function instantiate( $class ) {
        $service = new $class;

        return $service;
    }  
}

// use Inc\Activate;
// use Inc\Deactivate;
// use Inc\Admin\AdminPages;

// class KhagendraPlugin
// {
//     public $plugin;

//     function __construct() {
//         add_action( 'init', array( $this, 'custom_post_type' ) );

//         $this->plugin = plugin_basename( __FILE__ );
//     }

//     function register() {
//         add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

//         add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );

//         add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
//     }

//     public function settings_link( $links ) {
//         $settings_link = '<a href="admin.php?page=khagendra_plugin">Settings</a>';
//         array_push($links, $settings_link);

//         return $links;
//     }

//     public function add_admin_pages() {
//         add_menu_page( 'Khagendra Plugin', 'Khagendra', 'manage_options', 'khagendra_plugin', array( $this, 'admin_index' ), 'dashicons-store', 110 );
//     }

//     public function admin_index() {
//         require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
//     }

//     function custom_post_type() {
//         register_post_type( 'book', array(
//             'public'        =>  true,
//             'label'         =>  'Books'
//         ) );
//     }

//     function enqueue() {
//         wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ) );
//         wp_enqueue_script( 'mypluginstyle', plugins_url( '/assets/myscript.js', __FILE__ ) );
//     }

//     function activate() {
//         Activate::activate();
//     }
// }

// if ( class_exists( 'KhagendraPlugin' ) ) {
//     $khagendraPlugin = new KhagendraPlugin();
//     $khagendraPlugin->register();
// }

// // Activation
// register_activation_hook( __FILE__, array( $khagendraPlugin, 'activate' ) );

// // Deactivation
// register_deactivation_hook( __FILE__, array( 'Deactivate', 'deactivate' ) );
