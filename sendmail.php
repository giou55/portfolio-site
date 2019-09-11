<?php 
    require('phpmailer/PHPMailerAutoload.php');
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    if($name != null && $email != null && $message != null){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $signal = 'bad';
            $msg = 'Invalid email. Please check';
        }
        else{
            $mail = new PHPMailer;
            $mail->isSMTP();                           
            $mail->Host =  'mail.giourmetakis.gr';  
            $mail->SMTPAuth = true; 
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );                             
            $mail->Username = 'george@giourmetakis.gr';            
            $mail->Password = 'jdhF5d!87fef';                        
            $mail->SMTPSecure = 'tls';                     
            $mail->Port = 587;

            $mail->setFrom('george@giourmetakis.gr', 'George');
            $mail->addAddress('giourmetakis00@gmail.com');     // Add a recipient
            
            $mail->addReplyTo($email, $name);
  
            $mail->isHTML(true);                            
            
            $mail->Subject = 'From giourmetakis.gr';
            $mail->Body    = 'Name: '.$name.' <br />Message: '.$message;
            
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                $signal = 'ok';
                $msg = 'OK message sent.';
            }
        }
    }
    else{
        $signal = 'bad';
        $msg = 'Please fill in all the fields.';
    }
    $data = array(
        'signal' => $signal,
        'msg' => $msg
    );
    echo json_encode($data);
?>