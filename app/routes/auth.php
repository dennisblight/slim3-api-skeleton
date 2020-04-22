<?php

use App\Controllers\AuthController;

// Return non-user associated JWT with cryptographic random bytes payload.
// Required to track user activity upon send pre-login request.
$app->get('/plain-token', AuthController::class.':plainToken');

// RS256 Public key
$app->get('/public-key', AuthController::class.':publicKey');

// Client send email, password and confirmation token, then return token upon success.
// Confirmation token is required if email address supplied by client is not verified
// yet
$app->post('/login', AuthController::class.':login');

// Client send currently active JWT in request header, then server return fresh token.
// This should verify that token expiration time is no more than 10 minutes left.
$app->post('/refresh-token', AuthController::class.':refreshToken');

// Client send currently active JWT in request header, then server user info associated
// with supplied JWT.
$app->get('/current-user', AuthController::class.':currentUser');

// Client send registration info, then server should send verification token email to
// email address supplied by client.
$app->post('/register', AuthController::class.':register');

// Client send email, then server should send verification token email to email address
// supplied by client if email address supplied by client is not verified yet
$app->post('/register/resend-verification', AuthController::class.':registerResendVerification');

// Client send email address, then server should send restoration token email to email
// address supplied by client. Server should able to limit this request for specified
// time after last successing request.
$app->post('/restore-password', AuthController::class.':restorePassword');

// Client send token, and password info, then server should verify if supplied token
// is valid then change password associated with token with new password supplied
// by client.
$app->post('/restore-password/confirm', AuthController::class.':restorePasswordConfirm');