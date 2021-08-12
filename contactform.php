<?php
    // declare PHP variables out of the form input
    $name = $_POST['name'];
    $visitor_email = $_POST['email'];
    $phonenumber = $_POST['tel'];
    $visitor_message = $_POST['message'];
    $ip = $_SERVER['REMOTE_ADDR']; // for IP address
    $browser = $_SERVER['HTTP_USER_AGENT']; // get browser info
    $email_body = "<html><body><div>";

    if(isset($_POST['name'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
        <label><b>Voornaam:</b></label>&nbsp;<span>".$name."</span>
     </div>";
    }

    if(isset($_POST['email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
        $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
        <label><b>Email:</b></label>&nbsp;<span>".$visitor_email."</span>
     </div>";
    }
      
    if(isset($_POST['tel'])) {
        $phonenumber = filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT);
        $email_body .= "<div>
        <label><b>Telefoonnummer:</b></label>&nbsp;<span>".$phonenumber."</span>
     </div>";
    }
      
    if(isset($_POST['message'])) {
        $visitor_message = htmlspecialchars($_POST['message']);
        $email_body .= "<div>
        <label><b>Bericht:</b></label>
        <div>".$visitor_message."</div>
     </div>";
    }

    if (isset($_POST['g-recaptcha-response'])) {
        $secret_key = '6Legdu0bAAAAAF8Ftv9ZilEXm4hvItu3z4DnWqUB';
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        $responseCaptchaData = json_decode($data);
     
        if($responseCaptchaData->success) {
            echo 'Captcha verified';
            $email_body .= "<div>
                        <label><b>IP:</b></label>
                        <div>".$ip."</div>
                    </div>";
            $email_body .= "<div>
                                <label><b>Browser:</b></label>
                                <div>".$browser."</div>
                            </div>";
            $email_body .= "</div></body></html>";
            $from = "no-reply@markslag-opleidingen-advies.nl";
            $to = "info@markslag-opleidingen-advies.nl";
            $subject = "U heeft een nieuw bericht!";
            $message = $email_body;
        
            $additional_headers = "From:" . $from . "\r\n";
            $additional_headers .= 'MIME-Version: 1.0' . "\r\n";
            $additional_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
            mail($to, $subject, $message, $additional_headers);
        } else {
            echo 'Verification failed';
        }
    }

    

?>