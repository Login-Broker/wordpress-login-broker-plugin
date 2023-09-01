jQuery(document).ready(function () {
    if (jQuery("[data-broker-login]").length) {
        jQuery("[data-broker-login]").click(function () {
            let platform = jQuery(this).data("broker-login");
            // Create a new instance of the useLoginBroker function
            const loginBroker = useLoginBroker(my_script.tenant_name, platform, handleSessionReceived, handleErrorReceived);
            // Start the login process
            loginBroker.startLoginProcess();
        });
    }


})

// Create a callback function to handle errors
function handleErrorReceived(error) {
    console.log('Error happened:', error);
}

// Create a callback function to handle when a session is received
function handleSessionReceived(sessionId) {
    console.log('Received sessionId:', sessionId);
    // Verify the sessionId on your server-side or API and get the logged-in user email
    jQuery.ajax({
        type: 'GET',
        url: my_ajax_object.ajax_url,
        data: { action: "blogin_ajax_request", sessionId: sessionId },
        success: function (response) {
            if (response.success && response.data.redirect_url) {
                // Redirect the user to the specified URL
                window.location.href = response.data.redirect_url;
            } else {
                // Handle errors or other responses
                console.error('Error or invalid response.');
                console.error(response.data.error);
            }
        },
        error: function (xhr, status, error) {
            // Handle AJAX errors
            console.error('AJAX error:', error);
        },
        timeout: 50 * 1000
    });
}