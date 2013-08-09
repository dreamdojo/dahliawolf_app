<?php
error_reporting(0);
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (isset($_POST) || isset($_SESSION) || isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['user_id'];
    // Save the file locally
    if (!empty($_FILES)) {
        $tempFile = $_FILES['iurl']['tmp_name'];
        $save_path = IMAGE_UPLOAD_DIR;
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $save_path;
        if($_FILES['iurl']['error'] != 4){
            $_FILES['iurl']['name'] = time().$_FILES['iurl']['name'];
            //$filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['postimage']['name']);

            $fileTypes = array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'); // File extensions
            $fileParts = pathinfo($_FILES['iurl']['name']);

            $filename = $userId.'_'.time().'.'.$fileParts['extension'];
            $targetFile =  str_replace('//','/',$targetPath) . $filename;

            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                chmod($targetFile,0777);

                $curDate = date('Y-m-d');
                $imgParams = array();
                $imgParams['created'] = $curDate;
                $imgParams['imagename'] = $filename;
                $imgParams['source'] = 'http://' . $_SERVER['SERVER_NAME'] . $save_path;
                $imgParams['user_id'] = $userId;
                $imgParams['domain'] = 'Dahliawolf Member';
                if( !empty($_REQUEST['description']) ){$imgParams['description'] = $_REQUEST['description'];}

                // Store image dimensions
                $dimensions = getimagesize($_SERVER['DOCUMENT_ROOT'] . $save_path . $filename);
                if( $dimensions[0] > 300 && $dimensions[1] > 300 ) {
                    $imgParams['dimensionsX'] = $dimensions[0];
                    $imgParams['dimensionsY'] = $dimensions[1];

                    //
                    $data = api_call('posting', 'add_post_image', $imgParams);
                }
                else {
                    $data = '{"success": false, "errors" : "IMAGE SIZE IS TOO SMALL"}';
                }
            } else {
                $data = '{"success": false, "errors" : "INVALID FILE TYPE"}';
            }
        }
    } else {
        $data = '{"success": false, "errors" : "NO FILE SELECTED"}';
    }
} else {
    $data = '{"success": false, "errors" : "USER NOT LOGGED IN"}';
}

echo $data;

if( empty($_GET['ajax']) ) {
	redirect($_SERVER['HTTP_REFERER']);
}
die();

?>