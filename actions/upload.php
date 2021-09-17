<?php
// ini_set("display_errors",false);
$file = $_FILES['file'];
$original_name = $file['name'];
$folder = '../storage/'.$_SESSION['auth']['id'];
if(!file_exists($folder))
    if (!@mkdir($folder)) {
	    $error = error_get_last();
	    echo $error['message'];
	}
$fname = strtotime('now') . '_' . $file['name'];
$filename = $folder.'/'.$fname;
if(move_uploaded_file($file['tmp_name'],$filename))
{
    $mime = mime_content_type($filename);
    $mime = mime_icon_name($mime);
    echo json_encode(["msg"=>"Upload ".$original_name." Berhasil","filename"=>$fname,"original_name"=>$original_name,"mime"=>$mime]);
}
else
    echo json_encode(["msg"=>"Upload ".$original_name." Gagal\n".$file['error']]);