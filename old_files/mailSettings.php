<?php
    require '/mailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->SMTPAuth = true;                               // Enable SMTP authentication

    include_once 'connect.php';
    include_once 'cript_decript.php';

    $query="select smtp_config from mailsetting";
    $result=$mysqli->query($query) or die("<div class='alert alert-danger'>
            <strong>Error:</strong>Database error
            </div>");

    if($result->num_rows>=1){
        $row = $result->fetch_object();
        $json = $row->smtp_config;
        $cfg = json_decode($json);
    }
    else{
        die("<div class='alert alert-danger'>
            <strong>Error:</strong>Mail Setting not found
            </div>
            <a href='mailform.php' type='button' class='btn btn-primary btn-md'>SET UP MailSettings</a>");

    }

    //var_dump($cfg);

    $mail->Host = $cfg->host;  // Specify main and backup SMTP servers
    $mail->Port = $cfg->port;                                    // TCP port to connect to
    $mail->SMTPSecure = $cfg->stype;                            // Enable TLS encryption, `ssl` also accepted
    $mail->Username = $cfg->email;                // SMTP username
    $mail->Password = decript($cfg->password,"CIO");                           // SMTP password


    $mail->From = $mail->Username;
    $mail->FromName = 'Account Product_crud';
//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                   // Name is optional
    $mail->addReplyTo($mail->From, $mail->FromName);
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name


    /*
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return 0;
    } else {
        echo 'Message has been sent';
        return 1;
    }
    */

