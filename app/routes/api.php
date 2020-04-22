<?php

use Core\Facades\DB;
use Core\Facades\Mail;
use Core\Facades\Logger;
use App\Utilities\Parser as P;

$app->map(['get', 'post', 'put'], '/test', function($request, $response) {
    
    $jwt = $this['jwtEncode'](['sess_id' => bin2hex(random_bytes(32))]);
    // Mail::clearResolvedInstance();
    // $mail = Mail::getFacadeRoot();
    // $mail->addAddress('dennisarfan@gmail.com');
    // $mail->isHTML(true);
    // $mail->Subject = '[Test] Verification Email';
    // $mail->Body = '<b> This is Test email dua </b>';

    // $sent = $mail->send();

    // return $response->withJson($sent ? 'Sent' : $mail->ErrorInfo);
    return $response->withJson(['status' => 'ok', 'jwt' => $jwt]);
});