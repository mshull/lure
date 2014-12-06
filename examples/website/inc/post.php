<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['email'])) {

        $name = strip_tags(trim($_POST["name"]));

        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        
        $email_from = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        
        $message = trim($_POST["message"]);

        $result = array();

        $email_to = "YOUR EMAIL ADDRESS";

        $email_subject = "New message from $name";

        if ( empty($name) OR empty($message) OR !filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        $error_message = "";

        $result["status"] = "success";

        $email_message .= "Name: $name\n";

        $email_message .= "Email: $email_from\n";

        $email_message .= "Message: $message\n";

        $headers = "From: $email_from\r\n";

        if (mail($email_to, $email_subject, $email_message, $headers)) {
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        } 
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
