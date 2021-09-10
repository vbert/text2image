<?php

if (!defined('BASEPATH')) {
    exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Helper Mail
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2016
 */

/**
 *
 * @param string $uri_for_active_photo
 * @return array
 */
function mail_send($uri_for_active_photo) {
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;
    $mail->SetLanguage('pl');
    $mail->CharSet = "UTF-8";
    $mail->IsSMTP();
    $mail->Host = 'podaj host';
    $mail->SMTPAuth = true;
    $mail->Username = 'podaj użytkownika';
    $mail->Password = 'podaj hasło';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->SetFrom('adres email', 'Nazwa adresu email');
    $mail->AddAddress('wsobczak@gmail.com');

    $mail->IsHTML(true);
    $mail->Subject = "Tytuł emaila";

    $body = 'Aktywuj zdjęcie: <br><a href="%s">%s</a>';
    $mail->Body = sprintf($body, $uri_for_active_photo, $uri_for_active_photo);
    $mail->AltBody = "Aktywuj zdjęcie: \n\r" . $uri_for_active_photo;

    if (!$mail->send()) {
        $message = 'Message could not be sent.';
        $message .= 'Mailer Error: ' . $mail->ErrorInfo;
        $success = false;
    } else {
        $message = 'Message has been sent';
        $success = true;
    }

    $result = [
        'message' => $message,
        'success' => $success
    ];

    return $result;
}
