<?php
        if(isset($_GET["userId"])){
            $userId = $_GET["userId"];
            $update = false;
            $servername = "localhost";
            $username = "root";
            $passwordDB = "hamunaptra";
            $dbName = "chatUserDB";
            // Create connection
            $conn = new mysqli($servername, $username, $passwordDB, $dbName);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            $tableName = "toUpdate";
            $query = "SELECT * FROM ".$tableName." WHERE userId=".$userId.";";
            $resultss = $conn->query($query);
            if($resultss->num_rows >0){
                $update = true;
            }
            // echo "<script type='text/javascript'>console.log('here11111');</script>";
            $tableName = "toUpdate";
            $query = "DELETE FROM ".$tableName." WHERE userId=".$userId.";";
            $conn->query($query);
            $conn->close();
            $response = array();
            $response["status"] = 'success';
            if($update==true){
                $response["message"] = "yes";
            }else{
                $response["message"] = "no";
            }
            echo json_encode($response);
        }
?>