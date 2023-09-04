<?php
function init() {
?>
<form method="post" action="options.php">
    <?php settings_fields('login_broker_setting_group'); ?>
    <?php do_settings_sections('login_broker_setting_group'); ?>
    <table class="form-table">
        <tr>
            <td colspan="2">
                With Login Broker you can offer people to login as 'subscriber' to your Wordpress site. 
                All you need is a tenant name and an api key. It is completely free for up to 100,000 monthly active users
                and does not require any credit card registration. Just go to <a href="https://login.broker/access" target="_blank">https://login.broker/access</a>.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">ShortCode</th>
            <td>
                <input type="text" style="width:100%; max-width:420px;" disabled id="copyTarget"
                       value='[login-broker platforms="google,facebook,linkedin,microsoft,apple,github"]'>
                <button type="button" id="copyButton" data-toggle="tooltip" title="Copy ShortCode">
                    <div class="dashicons-before dashicons-admin-page"></div>
                </button>
            </td>
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
            <th scope="row">Tenant name</th>
            <td>
                <input style="width:100%; max-width:450px;" type="input" name="login_broker_tenant_name"
                       value="<?php echo get_option('login_broker_tenant_name'); ?>" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">API Key</th>
            <td>
                <input style="width:100%; max-width:450px;" type="input" name="login_broker_api_key"
                       value="<?php echo get_option('login_broker_api_key'); ?>" />
            </td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
<?php
}
?>
