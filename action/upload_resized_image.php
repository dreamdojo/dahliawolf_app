<?php

error_reporting(0);

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!empty($_POST)) {
    $userId = $_SESSION['user']['user_id'];

    $save_path = IMAGE_UPLOAD_DIR;
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $save_path;
    $filename = $userId.'_'.time().'.'.'jpg';
    $targetFile =  str_replace('//','/',$targetPath) . $filename;

    $img = $_POST['image'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = UPLOAD_DIR . uniqid() . '.jpg';
    file_put_contents($targetFile, $data);


    //move_uploaded_file($file, $targetFile);
    chmod($targetFile,0777);

    $curDate = date('Y-m-d');
    $imgParams = array();
    $imgParams['created'] = $curDate;
    $imgParams['imagename'] = $filename;
    $imgParams['source'] = 'http://' . $_SERVER['SERVER_NAME'] . $save_path;
    $imgParams['user_id'] = $userId;
    $imgParams['domain'] = 'Uplaode by Dahliawolf member';
    if( !empty($_REQUEST['description']) ){$imgParams['description'] = $_REQUEST['description'];}

    // Store image dimensions
    $dimensions = getimagesize($_SERVER['DOCUMENT_ROOT'] . $save_path . $filename);
    $imgParams['dimensionsX'] = $dimensions[0];
    $imgParams['dimensionsY'] = $dimensions[1];

    $data = api_call('posting', 'add_post_image', $imgParams);
    echo $data;
} else {
    echo '_post empty';
}
?>