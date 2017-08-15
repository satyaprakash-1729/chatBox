<?php
                if(isset($_GET["userId"]) && isset($_GET["email"])){
                    $userId = $_GET["userId"];
                    $email = $_GET["email"];
                    $servername = "localhost";
                    $username = "root";
                    $passwordDB = "hamunaptra";
                    $dbName = "chatUserDB";
                    // Create connection
                    $conn = new mysqli($servername, $username, $passwordDB, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                    $tableName = "Friends";
                    $query = "SELECT * from ".$tableName." WHERE userId='".$userId."';";
                    $results = $conn->query($query);
                    $friendList = array();
                    if($results->num_rows > 0){
                        while($row = $results->fetch_assoc()){
                            //$result .= $row['firstname']." ".$row['lastname'];
                            array_push($friendList, $row['friendId']);      
                        }
                    }
                    $index = 0;
                foreach($friendList as $friend){                    
                    $tableName = "Users";
                    $query = "SELECT * from ".$tableName." WHERE id=".$friend.";";
                    $results = $conn->query($query);
                    if($results->num_rows > 0){
                        while($friendInfo = $results->fetch_assoc()){
                            $index = $index + 1;
                            echo '<div class="panel-group">';
                            echo '<div class="panel panel-default">';
                              echo '<div class="panel-heading">';
                                echo '<h4 class="panel-title">';
                                  echo '<a data-toggle="collapse" href="#collapse'.$index.'"><img src="'.$friendInfo["profilePic"].'" class="img-circle" alt="friendPic" width=100 height=100 data-toggle="tooltip" title="Click to toggle dropdown list"><b>&ensp;&ensp;&ensp;'.$friendInfo["firstname"].' '.$friendInfo["lastname"].'</b></a>';
                                echo '</h4>';
                              echo '</div>';
                              echo '<div id="collapse'.$index.'" class="panel-collapse collapse">';
                                echo '<div class="panel-body">';
                                $tableName2 = "ChatHistory";
                                $query2 = "SELECT message, timeOfMsg from ".$tableName2." WHERE friendId=".$friend." AND userId=".$userId.";";
                                $results2 = $conn->query($query2);
                                echo '<div class="container" id="msgHistory">';
                                $chatList = array();
                                $whichUser = array();
                                if($results2->num_rows > 0){
                                    while($message = $results2->fetch_assoc()){
                                            array_push($chatList, $message);
                                            array_push($whichUser, 1);
                                    }
                                }

                                $query3 = "SELECT message, timeOfMsg from ".$tableName2." WHERE friendId=".$userId." AND userId=".$friend.";";
                                $results3 = $conn->query($query3);
                                $ins = 0;
                                if($results3->num_rows > 0){
                                    while($message2 = $results3->fetch_assoc()){
                                            $datetime2 = DateTime::createFromFormat("Y-m-d H:i:s", $message2["timeOfMsg"]);
                                            while(DateTime::createFromFormat("Y-m-d H:i:s", $chatList[$ins]["timeOfMsg"]) < $datetime2){
                                                $ins++;
                                                if($ins >= sizeof($chatList)){
                                                    break;
                                                }
                                            }
                                            array_splice($chatList, $ins, 0, array($message2));
                                            array_splice($whichUser, $ins, 0, array(2));
                                    }
                                }
                                for($i =0; $i < sizeof($chatList); $i++){
                                    if($whichUser[$i] == 2){
                                        echo '<p class="bg-danger" id="msg1">'.$chatList[$i]["message"].'</p>';
                                    }else{
                                        echo '<p class="bg-info" id="msg2">'.$chatList[$i]["message"].'</p>';
                                    }
                                }
                                // $toPass1 = http_build_query(array('chatList' => $chatList));
                                // $toPass2 = http_build_query(array('whichUser' => $whichUser));
                                //echo $toPass1."  ".$toPass2;
                                // include 'chatHis.php?chatUser='.$toPass1.'&whichUser='.$toPass2;
                                echo "</div>";
                                //action="web7.php?username='.$email.'&msging=yes"
                                echo '<form class="form" role="form" method="post" action="web7.php?username='.$email.'&msging=yes&towhom='.$index.'" accept-charset="UTF-8" id="pic-nav">';
                                        echo '<div class="form-group">';
                                             echo '<input type="text" class="form-control" placeholder="Enter Message" name="msgToFriend'.$friendInfo["id"].'">';
                                        echo '</div>';
                                        echo '<div class="form-group">';
                                             echo '<button type="submit" class="btn btn-primary btn-block" data-toggle="tooltip" title="Press To Send Message">Send</button>';
                                        echo '</div>';
                                 echo '</form>';
                                 echo '</div>';
                              echo '</div>';
                            echo '</div>';
                          echo '</div>';
                            break;
                        }
                    }
                }
                $conn->close();
            }
            ?>