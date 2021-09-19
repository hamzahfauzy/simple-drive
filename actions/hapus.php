<?php
$filename = $_POST['filename'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL.'drive/hapus',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('file_name' => $filename),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$_SESSION['auth']['token']
    ),
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
if($response->msg == 'sukses')
    unlink('../storage/'.$_SESSION['auth']['id'].'/'.$filename);

echo $response->msg;