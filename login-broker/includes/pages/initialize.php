            
        <?php


  

function init(){


   ?>
  <form method="post" action="options.php">
        <?php settings_fields( 'login_broker_setting_group' ); ?>
       
        <?php do_settings_sections( 'login_broker_setting_group' ); ?>
        <table class="form-table">

		
    
        <tr valign="top">
            <th scope="row">ShortCode For Plugin</th>
            <td><input type="text" style="min-width: 600px;" disabled id="copyTarget"
             value='[login-broker platforms="google,facebook,linkedin,microsoft" ] '>
             <button type="button" id="copyButton" data-toggle="tooltip" title="Copy ShortCode">
               <div class="dashicons-before dashicons-admin-page"></div></button></td>
            </tr>

            
<script>
document.getElementById("copyButton").addEventListener("click", function() {
copyToClipboard("copyTarget");
});

function copyToClipboard(elementId) {
var aux = document.createElement("input");
aux.setAttribute("value", document.getElementById(elementId).value);
document.body.appendChild(aux);
aux.select();
document.execCommand("copy");
document.body.removeChild(aux);
}
</script>
            <tr valign="top">
            <th scope="row">Tenant Name</th>
            <td><input style="width:100%; max-width:450px;" type="input" name="login_broker_tenant_name" 
            value="<?php echo get_option('login_broker_tenant_name'); ?>" /></td>
            </tr>
            <tr valign="top">
            <th scope="row">API Key</th>
            <td><input style="width:100%; max-width:450px;" type="input" name="login_broker_api_key" 
            value="<?php echo get_option('login_broker_api_key'); ?>" /></td>
            </tr>
          
        </table>
        
        <?php submit_button(); ?>

    </form>
    <?php
}

    
   