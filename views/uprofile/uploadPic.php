<?php

//Checking picture size (if user's uploaded the picture)
$sqlUploadPicture = '';



// Upload full path (Detect path automatically)
        if (!defined('UPLOADDIR')){
            define('UPLOADDIR', ("../../public/images/"));
            define('UPLOADDIR2', ("public/images/"));
//            define('UPLOADDIR', ("http://datacenter/p4p/images/PhotoPersonal/"));
//            define('UPLOADDIR2', ("../p4p/images/PhotoPersonal/"));
        }
        $temp = explode(".", $_FILES["imgupload"]["name"]);
        $extension = end($temp);

        //change file name
        //use upload name
//        $file_names = $_FILES["imgupload"]["name"] . '.' . end($temp);
        //use person_id as filename
        $pid = $_REQUEST['id_edit'];
        $file_names = $pid . '.' . end($temp);

            if ($_FILES["imgupload"]["error"] > 0) {
                echo "Error: " . $_FILES["imgupload"]["error"] . "<br>";
            } else {
                // echo "Upload: " . $_FILES["imgupload"]["name"] . "<br>";
                // echo "Type: " . $_FILES["imgupload"]["type"] . "<br>";
                // echo "Size: " . ($_FILES["imgupload"]["size"] / 1024) . " kB<br>";
                // echo "Stored in: " . $_FILES["imgupload"]["tmp_name"];
            }

            //Deleting all user's old avatar even if file extension is different
//            (1 user = 1 pic in directory)
//            $possibleFiles = glob(UPLOADDIR . $_POST["id_edit"] . '.*');
//            foreach ($possibleFiles as $foundfile) {
//                unlink($foundfile);
//            }

            /* if (file_exists(UPLOADDIR . $_FILES["imgupload"]["name"])){echo $_FILES["imgupload"]["name"] . " already exists. ";} */

            //If directory is not created yet, create it!
            if (!file_exists(UPLOADDIR)) {
                mkdir(UPLOADDIR);
            }

            //Saving the Uploaded File
            if (move_uploaded_file($_FILES["imgupload"]["tmp_name"], UPLOADDIR . $file_names)) {
                //echo "<br />moving to Stored in: " . "images/PhotoPersonal/" . $file_names;
//                $sqlUploadPicture = "imgupload='" . $file_names . "',";
//                $upStat = "<span class='Text-Comment5'>การอัพโหลดรูปภาพสำเร็จ</span>";
                $output = array(
                    //'imgupload' => $file_names ,
                    //'upload_result' => 'การอัพโหลดรูปภาพสำเร็จ',
                    //'uploaded' => 'OK',
                    "initialPreview" => "<img src='" . UPLOADDIR . $file_names . "' class='file-preview-image' alt='preview-".$pid."' title='preview-".$pid."' />"
                );
            } else {
//                $upStat = "<span class='Text-Comment7'>การอัพโหลดรูปภาพผิดพลาด</span>";
                $output = array();
            }
            echo json_encode($output);
            

exit();