<?php
$ciphering = "AES-128-CTR";
$iv = '2345678910111211';
$key = "DE";
$options = 0;
$password = "password";
$encryption = openssl_encrypt($password, $ciphering, $key, $options, $iv);
echo $encryption . PHP_EOL;
?>