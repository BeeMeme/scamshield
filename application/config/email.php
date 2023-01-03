<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'mailpath' =>  '/usr/bin/sendmail',
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.viefaucet.com', 
    'smtp_port' => 465,
    'smtp_user' => 'admin@viefaucet.com',
    'smtp_pass' => 'tung2000',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);