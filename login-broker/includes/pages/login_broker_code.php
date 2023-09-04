<?php

function login_broker_shortcode_function($atts, $content = null){
$session_id = session_id();
$platforms = [];
if(isset($atts['platforms']) ){
      $platforms = explode(",", $atts['platforms']);
    }
?>
  


<?php ob_start();
?>
<style>
.login-broker-button {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 19px;
    padding-right: 19px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: left;
    min-width: 125px;
    margin-bottom: 10px;
}

.login-broker-button i {
    margin-right: 10px;
}

/* Specific styles for Google login */
.login-broker-google-button {
    background-color: #DB4437;
    color: white;
}

/* Specific styles for Facebook login */
.login-broker-facebook-button {
    background-color: #4267B2;
    color: white;
}

/* Specific styles for GitHub login */
.login-broker-github-button {
    background-color: #333;
    color: white;
}

/* Specific styles for Microsoft login */
.login-broker-microsoft-button {
    background-color: #00A4EF;
    color: white;
}

/* Specific styles for Apple login */
.login-broker-apple-button {
    background-color: #000;
    color: white;
}

/* Specific styles for Twitter login */
.login-broker-twitter-button {
    background-color: #1DA1F2;
    color: white;
}

/* Specific styles for Linkedin login */
.login-broker-linkedin-button {
    background-color: #0077B5;
    color: white;
}

    </style>
<?php
if (!is_user_logged_in()) {
    foreach ($platforms as $platform) {
        ?>
        <button class="login-broker-button login-broker-<?php echo $platform; ?>-button"
                data-broker-login="<?php echo $platform; ?>"
                data-session="<?php echo $session_id; ?>"><?php echo ucfirst($platform); ?></button>
        <?php
    }
} else {
    // User is logged in
    // Get the current user's information
    $current_user = wp_get_current_user();
    ?>
    <p>Logged in as: <?php echo esc_html($current_user->user_login); ?></p>
    <a href="<?php echo wp_logout_url(); ?>">Logout</a>
    <?php
}

$content = ob_get_contents();
ob_end_clean();
return $content;
}

add_shortcode('login-broker', 'login_broker_shortcode_function');
?>