<?php

require($_SERVER['DOCUMENT_ROOT'] . '/libs/sendgrid-php/sendgrid-php.php');

function send_emails($subject, $body, $to) {
    //send emaiil using sendgrid web api
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("bcab19_2245@santhigiricollege.com", "College Notifier");
    $email->setSubject($subject);
    // $email->addTo("vishnuvinod2772001@gmail.com");
    foreach ($to as $email_id) {
        $email->addTo($email_id);
    }
    $email->addContent(
        "text/html", "
        <div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
            <div style='margin:50px auto;width:70%;padding:20px 0'>
                <div style='border-bottom:1px solid #eee'>
                    <a href='https://collegenotifier.000webhostapp.com/' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>College Notifier</a>
                </div>
                <p style='font-size:1.1em'>Hi,</p>
                <div>$body</div>
                <p style='font-size:0.9em;'>Regards,<br />College Notifier</p>
                <hr style='border:none;border-top:1px solid #eee' />
                <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
                    <p>College Notifier</p>
                    <p>Developed and maintained By Vishnu Vinod</p>
                </div>
            </div>
      </div>
        "
    );
    $sendgrid = new \SendGrid(ApiKeysConfig::send_grid_api_key);
    try {
        $response = $sendgrid->send($email);
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
        // if response code is 202, send array('success' => true, 'message' => 'Email has been sent successfully')
        // else send array('success' => false, 'message' => 'Email has not been sent successfully')
        if($response->statusCode() == 202) {
            return array('success' => true, 'message' => 'Email(s) has been sent successfully');
        } else {
            return array('success' => false, 'message' => 'Error Sending Email');
        }
    } catch (Exception $e) {
        // echo 'Caught exception: '. $e->getMessage() ."\n";        
        return array('success' => false, 'message' => 'Email has not been sent successfully', 'reason' => $e->getMessage());
    }

}