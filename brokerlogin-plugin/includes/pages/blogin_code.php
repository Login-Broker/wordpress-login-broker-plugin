<?php

function blogin_shortcode_function($atts, $content = null){
global $blogin_plugin_url;
$session_id = session_id();
$platforms = [];
if(isset($atts['platforms']) ){
      $platforms = explode(",", $atts['platforms']);
    }
?>
  
<style>
    .bl_btns{
        background-color: #3498db;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    }
    .bl_btns:hover, .bl_btns:focus {
    background-color: #2980b9;
}
    </style>

<?php ob_start();
if (!is_user_logged_in()){
foreach ($platforms as $platform) {
   
           ?>
           <button class="bl_btns bl_<?php echo $platform; ?>_btn" data-broker-login="<?php echo $platform; ?>"
           data-session="<?php echo $session_id; ?>" ><?php echo ucfirst($platform); ?></button>
           <?php
           

?>



<?php
}
}
$content = ob_get_contents();
ob_end_clean();
return $content;
}
add_shortcode('login-broker','blogin_shortcode_function');
