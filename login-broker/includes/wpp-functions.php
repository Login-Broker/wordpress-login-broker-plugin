<?php


define('LOGIN_BROKER_PLUGIN_FILE_URL', 'login-broker/login-broker.php');
$login_broker_plugin_url = plugin_dir_url(__FILE__);



// Add action to the Admin Menu
add_action('admin_menu','login_broker_menu');
function login_broker_menu() {
get_role( 'administrator' )->add_cap( 'login_broker_manage_options' );
	get_role( 'author' )->add_cap( 'login_broker_manage_options' );
	get_role( 'editor' )->add_cap( 'login_broker_manage_options' );
    // This is the main item for the menu
    add_menu_page('Login Broker',          // page title
        'Login Broker Settings',                      // menu title
        'login_broker_manage_options',                // capabilities
        'login_broker_short_code',                // menu slug
        'init'                   // function
    );

}

function wp_login_broker_initialization() {
register_setting('login_broker_setting_group', 'login_broker_tenant_name');
register_setting('login_broker_setting_group', 'login_broker_api_key');
	
  define('ROOTDIR', plugin_dir_path(__FILE__));
  require_once(ROOTDIR . 'pages/initialize.php');
  require_once(ROOTDIR . 'pages/login_broker_code.php');
 
}
add_action( 'init', 'wp_login_broker_initialization' );
// end

// Trigger action scripts
add_action('wp_enqueue_scripts', 'login_broker_scripts'); // add custom scripts


// end

// Trigger activate/deactivate scripts
register_activation_hook( LOGIN_BROKER_PLUGIN_FILE_URL, 'activate_login_broker_web_view');
register_deactivation_hook( LOGIN_BROKER_PLUGIN_FILE_URL, 'deactivate_login_broker_web_view');
// end


/**
 * This is used to add custom scripts
 */
function login_broker_scripts()
{
    global $login_broker_plugin_url;
    wp_register_script('jquery', '//code.jquery.com/jquery-3.7.1.min.js', false, null);
     wp_enqueue_script('jquery');
    wp_enqueue_script( 'Globals', '//cdn.jsdelivr.net/gh/Login-Broker/javascript@main/loginbroker.v1.js');
     wp_localize_script( 'Globals', 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
     wp_localize_script('Globals', 'my_script', array(
        'plugins_url' =>plugin_dir_url( __FILE__ ),
        'tenant_name' =>get_option('login_broker_tenant_name')
    ));
    wp_enqueue_script( 'u-plugin', $login_broker_plugin_url. 'assets/js/u-plugin.js');

}

add_action( 'wp_ajax_nopriv_login_broker_ajax_request', 'login_broker_ajax_request' );
add_action( 'wp_ajax_login_broker_ajax_request', 'login_broker_ajax_request' );
function login_broker_ajax_request($args){
  $sessionId = $_REQUEST["sessionId"];
  $tenantName = get_option('login_broker_tenant_name');
  $api_key = get_option('login_broker_api_key');
try {
     // Replace these variables with your API endpoint and API key
$api_endpoint = 'https://api.login.broker/'.$tenantName.'/auth/result/'.$sessionId;

// Set up the request arguments
$args = array(
    'headers' => array(
        'Authorization' => $api_key, // Use API Key
        'Content-Type' => 'application/json', // Adjust the content type as needed
    ),
);
// Make the cURL request using wp_remote_request
$response = wp_remote_request($api_endpoint, $args);

// Check for errors
if (is_wp_error($response)) {
    echo "Error: " . $response->get_error_message();
} else {
    // Get the response body
    
    $body = wp_remote_retrieve_body($response);

    // Process the response data (in this example, we assume it's JSON)
    $data = json_decode($body);

    // Use $data as needed
if($data->status =="completed"){
    // Replace 'user@example.com' with the email you want to check
$email_to_check = $data->email;

// Check if the email exists as a user
$user = get_user_by('email', $email_to_check);

if ($user) {
    // Email exists as a user, log them in
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID);
    do_action('wp-login', $user->user_login);
    wp_send_json_success(array('redirect_url' => home_url('/')));
} else {
    // Email doesn't exist as a user, create a new user and log them in
    $random_password = wp_generate_password();
    $new_user_id = wp_create_user($email_to_check, $random_password, $email_to_check);

    if (!is_wp_error($new_user_id)) {
        // User created successfully, log them in
        $user = get_user_by('id', $new_user_id);
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        do_action('wp-login', $user->user_login);
        wp_send_json_success(array('redirect_url' => home_url('/')));
    } else {
        // Error creating user
        wp_send_json_success(array('error' => 'Error creating user: ' . $new_user_id->get_error_message()));
    }
}

}else{
    wp_send_json_success(array('error' => $data->status.": " . $data->error));
}

}
    wp_die();
} catch(Exception $e){
            wp_send_json_success(array('error' => $e->getMessage()));
            wp_die();
}


}

/**
 * This is used to add custome page through plugin
 */
function activate_login_broker_web_view()
{
    global $wpdb;

  
}
/**
 * This is used to deactivate circular web view
 */
function deactivate_login_broker_web_view()
{
    global $wpdb;

  
}




?>