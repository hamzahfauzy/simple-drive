<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL.'site/validate-token?token='.$_GET['token'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_SSL_VERIFYHOST => 0, // or false
    CURLOPT_SSL_VERIFYPEER => 0, // or false
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
if($response->message == 'Login gagal')
    echo "Login gagal";
else
{
    $_SESSION['auth'] = [
        'token'    => $response->token,
        'username' => $response->username,
        'id' => $response->id,
    ];
    header('location:index.php');
    die();
}