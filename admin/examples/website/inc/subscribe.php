<?php
require_once('MailChimp.php');
$MailChimp = new \Drewm\MailChimp('YOUR API KEY');

if(isset($_POST['email'])) {

	$check_user = $MailChimp->call('lists/member-info', array(
    	'id'                => 'YOUR LIST ID',
    	'emails' => array(
    		array('email' => $_POST['email'])
    		)
    ));

    //var_dump($check_user["success_count"]);

    if( $check_user["success_count"] === 1 ) {
    	http_response_code(200);
    	echo "You have already subscribed to the List";
        exit;
    }

	$result = $MailChimp->call('lists/subscribe', array(
        'id'                => 'YOUR LIST ID',
        'email'             => array('email'=> $_POST['email']),
        'double_optin'      => false,
        'update_existing'   => true,
        'replace_interests' => false,
        'send_welcome'      => false,
    ));

	if (isset($result["email"]) && isset($result["euid"]) && isset($result["leid"])) {
		http_response_code(200);
        echo "Thank You! We've added you to our list.";
        exit;
	} else {
        http_response_code(500);
        echo "Oops! Something went wrong try again.";
        exit;
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}