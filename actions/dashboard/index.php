<?php
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL.'drive/index',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$_SESSION['auth']['token']
    ),
    CURLOPT_SSL_VERIFYHOST => 0, // or false
    CURLOPT_SSL_VERIFYPEER => 0, // or false
));

$response = curl_exec($curl);

curl_close($curl);
$all_files = json_decode($response);

// $all_files = [];
// $folder = '../storage/'.$_SESSION['auth']['username'];
// if(!file_exists($folder))
//     mkdir($folder);
// if ($handle = opendir($folder)) {

//     while (false !== ($entry = readdir($handle))) {

//         if ($entry != "." && $entry != "..") {

//             $all_files[] = $entry;
//         }
//     }

//     closedir($handle);
// }

