<?php
function encrypt($text)
{
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    $options = 0;
    // Non-NULL Initialization Vector for encryption
    $encryption_iv = HashingConfig::hashing_iv;
    // Store the encryption key
    $encryption_key = HashingConfig::hashing_key;
    // Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt($text, $ciphering, $encryption_key, $options, $encryption_iv);
    return $encryption;
}

function decrypt($text)
{
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    $options = 0;
    $decryption_iv = HashingConfig::hashing_iv;
    // Store the decryption key
    $decryption_key = HashingConfig::hashing_key;
    // Use openssl_decrypt() function to decrypt the data
    $decryption = openssl_decrypt($text, $ciphering, $decryption_key, $options, $decryption_iv);
    return $decryption;
}
