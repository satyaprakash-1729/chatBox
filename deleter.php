<!-- 
Author: Satya Prakash, CSE, IIT Guwahati
Project: Simple Chat Page
 -->
<?php
    //debug_to_console("Herer");
    if(isset($_GET["filename"]) && isset($_GET["userId"])){
        $filename = $_GET["filename"];
        $userId = $_GET["userId"];
        //echo "uploads/".$filename;
        $file = 'uploads/'.$userId.'/'.$filename;
        //echo '<script>console.log("---->@@>>> '.$file.'");</script>';
        $result = unlink($file);
        $response = array();
        if(!$result){
            $response["deletion"] = "success";
        }else{
            $response["deletion"] = "failed";
        }
        echo json_encode($response);
    }
?>