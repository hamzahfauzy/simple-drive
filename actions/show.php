<?php
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL.'drive/show?id='.$_GET['id'],
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


// the file you want to send
$path = "storage/".$response->user_id."/".$response->file_name;

if(isset($_GET['preview']) && $_GET['preview'] == 'video')
{
    echo '<style>body{margin:0;padding:0;}</style><video width="100%" controls>
            <source src="'.$path.'" type="video/mp4">
            Your browser does not support HTML video.
        </video>';
    die();
}

// the file name of the download, change this if needed
$public_name = basename($path);

// get the file's mime type to send the correct content type header
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $path);

// send the headers
header("Content-Disposition: attachment; filename=$public_name;");
header("Content-Type: $mime_type");
header('Content-Length: ' . filesize($path));

// stream the file
$fp = fopen($path, 'rb');
fpassthru($fp);
exit;