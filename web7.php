<!-- 
Author: Satya Prakash, CSE, IIT Guwahati
Project: Simple Chat Page
 -->
<?php 
    $cookie_name = "userChatDB";
        //echo var_dump($_COOKIE);
        if(isset($_COOKIE[$cookie_name])) {
            //echo '<script type="text/javascript">console.log(" Email ");</script>';
             $email1 = $_COOKIE[$cookie_name];
             //echo var_dump($_COOKIE);
             if($email1 == $_GET["username"]){
             }else{
                header('Location: web9.php');
                // die("Connection Failed : Login to view your page!");
             }
        }else{
            header('Location: web9.php');
            // die("Connection Failed : Login to view your page!");
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST["picAddr"])){
                $picAddr = $_POST["picAddr"];
                if(!empty($picAddr)){
                    $email = $_GET['username'];
                    $servername = "localhost";
                    $username = "root";
                    $passwordDB = "hamunaptra";
                    $dbName = "chatUserDB";
                    // Create connection
                    $conn = new mysqli($servername, $username, $passwordDB, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                    $tableName = "Users";
                    $query = "UPDATE ".$tableName." SET profilePic = '".$picAddr."' WHERE email='".$email."';";
                    $ret = $conn->query($query);
                    //echo "ret: ".$ret." query: ".$query;
                    // $query = "SELECT * from ".$tableName." WHERE email='".$email."';";
                    // $results = $conn->query($query);
                    // while($row = $results->fetch_assoc()){
                    //     echo "-->".$row['profilePic'];
                    // }
                    $query = "";
                    $results = "";
                }
            }
            if (isset($_POST["optradio"])){
                $gender = $_POST["optradio"];
                if(!empty($gender)){
                    $servername = "localhost";
                    $username = "root";
                    $passwordDB = "hamunaptra";
                    $dbName = "chatUserDB";
                    $city = $_POST["city"];
                    $quote = $_POST["quote"];
                    $dob = $_POST["dob"];
                    //echo "gender : ".$gender." quote: ".$quote. " city : ".$city;
                    $month = substr($dob, 0, 2);
                    $day = substr($dob, 3, 2);
                    $year = substr($dob, 6, 4);
                    // Create connection
                    $conn = new mysqli($servername, $username, $passwordDB, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                    $tableName = "UserDesc";
                    $email = $_GET['username'];
                    $query = "UPDATE ".$tableName." SET gender='".$gender."', city='".$city."', `dob`='".$year."-".$month."-".$day."', quote='".$quote."' WHERE email='".$email."';";
                    if($conn->query($query) === TRUE){

                    }  else{
                        echo $query;
                    }
                }
            }
            if (isset($_POST["keyword"])){
                $keyword = $_POST["keyword"];
                if(!empty($keyword)){
                    header('Location: https://www.google.com/search?q=site%3A'.$_SERVER["PHP_SELF"].'+'.$keyword);
                }
            }
            if (isset($_POST["friendReq"])){
                $friendsID = $_POST['friendReq'];
                if(!empty($friendsID)){
                    $idmy = $_GET["myid"];
                    addFriend($idmy, $friendsID);
                }
            }
        }
        $userId = 0;
        $result = "";
        $profileImageSrc = "";
        $email = $_GET["username"];
        $servername = "localhost";
        $username = "root";
        $passwordDB = "hamunaptra";
        $dbName = "chatUserDB";
        // Create connection
        $conn = new mysqli($servername, $username, $passwordDB, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $tableName = "Users";
        $query = "SELECT * from ".$tableName." WHERE email='".$email."';";
        if(!empty($email)){ 
            //echo "herer";
            $results = $conn->query($query);
            if($results->num_rows > 0){
                while($row = $results->fetch_assoc()){
                    $result = $row['firstname']." ".$row['lastname'];
                    $profileImageSrc = $row['profilePic'];
                    $userId = $row['id'];
                    break;
                }
                if(empty($profileImageSrc)){
                        $profileImageSrc = "http://www.realestatetaxgroup.com/wp-content/uploads/2013/03/empty-profile.png";
                    }
            }else{
                header('Location: index.php');
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
            $tableName = "UserDesc";
            $query = "SELECT * from ".$tableName." WHERE email='".$email."';";
            $results = $conn->query($query);
            if($results->num_rows > 0){
                while($row = $results->fetch_assoc()){
                    $city = $row['city'];
                    $gender = $row['gender'];
                    $quote = $row['quote'];
                    $dob = $row['dob'];
                    break;
                }
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $msging = $_GET["msging"];
                if(!empty($msging) && $msging == "yes"){
                    $maxIndex = 100;
                    $towhom = $_GET["towhom"];
                    for($i=1; $i<=$maxIndex; $i++){
                        $nameOfInp = "msgToFriend".$i;
                        if(!empty($_POST[$nameOfInp])){
                            //echo $_POST[$nameOfInp]."     ".$msging;
                            $servername = "localhost";
                            $username = "root";
                            $passwordDB = "hamunaptra";
                            $dbName = "chatUserDB";
                            $tableName = "ChatHistory";
                            $messageToInsert = $conn->real_escape_string($_POST[$nameOfInp]);
                            $query = "INSERT INTO ".$tableName." (userId, friendId, message)
                             VALUES (".$userId.", ".$i.", '".$messageToInsert."');";
                             // echo $query;
                             $conn = new mysqli($servername, $username, $passwordDB, $dbName);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            } 
                            $conn->query($query);
                            
                            $tableName = "toUpdate";
                            $query = "INSERT INTO ".$tableName." (userId) 
                            VALUES (".$i.");";
                            $conn->query($query);
                            $conn->close();
                            break;
                        }
                    }      
                }
            }
        }
        function addFriend($idMine, $idFriend){
            $servername = "localhost";
            $username = "root";
            $passwordDB = "hamunaptra";
            $dbName = "chatUserDB";
            $tableName = "Friends";
            $query = "INSERT INTO ".$tableName." (userId, friendId)
             VALUES (".$idMine.", ".$idFriend.");";
             $conn = new mysqli($servername, $username, $passwordDB, $dbName);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            $conn->query($query);
            $query = "INSERT INTO ".$tableName." (userId, friendId)
             VALUES (".$idFriend.", ".$idMine.");";
             $conn->query($query);
             $tableName = "FriendReq";
             $query = "DELETE FROM ".$tableName." WHERE userID=".$idMine.";";
             $conn->query($query);
             $conn->close();
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.3"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style type="text/css">
        body {
            background-image: url("http://www.planwallpaper.com/static/images/Seamless-Polygon-Backgrounds-Vol2-full_Kfb2t3Q.jpg");
        }
        #msg1 {
            font-weight: bold;
            font-family: 'Times New Roman','Verdana', 'Monotype Corsiva';
            font-size: 16px;
            width: 1000px;
            color: #884422;
        }
        #msg2 {
            font-weight: bold;
            width: 1000px;
            font-family: 'Times New Roman','Verdana', 'Monotype Corsiva';
            font-size: 16px;
            color: #224488;
        }
        .dropdown-menu {
            width: 380px;
        }
        #footerContainer{
            background-color: #446677;
            width: 1300px;
        }
        #butColl {
            float: right;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand"><i class="fa fa-comments-o" aria-hidden="true"></i>  <b>MyChat</b></a>
        </div>
        <ul class="nav navbar-nav">
          <li class="active" data-toggle="tooltip" title="Friends List"><a href="web5.php?username=<?php echo $email;?>"><i class="fa fa-user-plus" aria-hidden="true"></i>  Friends</a></li>
          <li id="chatBox" data-toggle="tooltip" title="Chat with friends"><a href="web7.php?username=<?php echo $email; ?>&myid=<?php echo $userId; ?>"><i class="fa fa-comments" aria-hidden="true"></i>  Chat</a></li>
          <li><a href="index.php?msg=logout" data-toggle="tooltip" title="Log out of account"><i class="fa fa-sign-out" aria-hidden="true"></i>  Log Out</a></li>
          <li class="dropdown" data-toggle="tooltip" title="List of all users">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users" aria-hidden="true"></i>  All Users<span class="caret"></span></a>
                <ul id="user-dp" class="dropdown-menu">
                     <?php
                            $servername = "localhost";
                            $username = "root";
                            $passwordDB = "hamunaptra";
                            $dbName = "chatUserDB";
                            // Create connection
                            $conn = new mysqli($servername, $username, $passwordDB, $dbName);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            } 
                            $tableName = "Users";
                            $query = "SELECT * from ".$tableName.";";
                            $results = $conn->query($query);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    $result1 = $row['firstname']." ".$row['lastname'];
                                    $friendId = $row['id'];
                                    $profileImageSrc1 = $row['profilePic'];
                                    if($row['email'] !== $email and array_search($friendId, $friendList)===FALSE){
                                        echo "<li>";
                                             echo "<div class='row'>";
                                                    echo "<div class='col-md-12'>";
                                                         echo "<a href='web6.php?friend=no&username=".$email."&myid=".$userId."&id=".$friendId."'><img src='".$profileImageSrc1."' class='img-circle' alt='userPic' width=50 height=50>  ".$result1;
                                                    echo "</div>";
                                             echo "</div>";
                                        echo "</li>";
                                    }else if($row['email'] !== $email and array_search($friendId, $friendList)!==FALSE){
                                        echo "<li>";
                                             echo "<div class='row'>";
                                                    echo "<div class='col-md-12'>";
                                                         echo "<a href='web6.php?friend=yes&username=".$email."&myid=".$userId."&id=".$friendId."'><img src='".$profileImageSrc1."' class='img-circle' alt='userPic' width=50 height=50>  ".$result1;
                                                    echo "</div>";
                                             echo "</div>";
                                        echo "</li>";
                                    }
                                }
                            }
                    ?>
                </ul>
          </li>

          <li class="dropdown" data-toggle="tooltip" title="Personalize You Account" id="test1">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Change Your Profile Info <span class="caret"></span></a>
                <ul id="login-dp" class="dropdown-menu">
                    <li>
                         <div class="row">
                                <div class="col-md-12">
                                     <form class="form" role="form" method="post" action="web5.php?username=<?php echo $email;?>" accept-charset="UTF-8" id="pic-nav">
                                            <div class="form-group">
                                                <label class="control-label" for="optradio">Gender</label>
                                                 <label class="radio-inline"><input type="radio" name="optradio" id="optradio" value="Male">Male</label>
    <label class="radio-inline"><input type="radio" name="optradio" id="optradio" value="Female">Female</label>
    <label class="radio-inline"><input type="radio" name="optradio" id="optradio" value="Other">Other</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="city">City</label>
                                                 <input type="text" class="form-control" id="city" placeholder="City" name="city">
                                            </div>
                                            <!--  //////////////////////////////////////////////////////////////////////////////////////////// -->

                                                 <div class="form-group ">
                                                <label class="control-label" for="datepicker">Date</label>
                                                   <div class="input-group">
                                                    <input type="text" id="datepicker" name="dob">
                                                   </div>
                                                 </div>

                                            <!-- /////////////////////////////////////////////////////////////////////////////////////////////// -->
                                            <div class="form-group">
                                                <label class="control-label" for="quote">Quote</label>
                                                 <input type="text" class="form-control" id="quote" placeholder="Quote" name="quote">
                                            </div>
                                            <div class="form-group">
                                                 <button type="submit" class="btn btn-primary btn-block">Update</button>
                                            </div>
                                     </form>
                                </div>
                         </div>
                    </li>
                </ul>
            </li>

            <li class="dropdown" data-toggle="tooltip" title="See Friend Requests Pending">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Friend Requests <span class="caret"></span></a>
                <ul id="login-dp" class="dropdown-menu">
                    <li>
                         <div class="row">
                                <div class="col-md-12">
                                     <form class="form" role="form" method="post" action="web5.php?username=<?php echo $email;?>&myid=<?php echo $userId; ?>" accept-charset="UTF-8" id="pic-nav">
                                            <?php 
                                                $servername = "localhost";
                                                $username = "root";
                                                $passwordDB = "hamunaptra";
                                                $dbName = "chatUserDB";
                                                $conn = new mysqli($servername, $username, $passwordDB, $dbName);
                                                if ($conn->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                } 
                                                $tableName = "FriendReq";
                                                $query = "SELECT * from ".$tableName." WHERE userID=".$userId.";";
                                                $results = $conn->query($query);
                                                if($results->num_rows > 0){
                                                    while($row = $results->fetch_assoc()){
                                                        $tableName2 = "Users";
                                                        $query2 = "SELECT * from ".$tableName2." WHERE id='".$row["reqUserId"]."';";
                                                        $results2 = $conn->query($query2);
                                                        if($results2->num_rows > 0){
                                                            while($row2 = $results2->fetch_assoc()){
                                                                $result2 = $row2['firstname']." ".$row2['lastname'];
                                                                $profileImageSrc2 = $row2['profilePic'];
                                                                break;
                                                            }
                                                            if(empty($profileImageSrc2)){
                                                                    $profileImageSrc2 = "http://www.realestatetaxgroup.com/wp-content/uploads/2013/03/empty-profile.png";
                                                                }
                                                        }
                                                        echo '<div class="form-group">';
                                                            echo '<label class="radio-inline"><input type="radio" name="friendReq" id="friendReq" value="'.$row["reqUserId"].'"><img src="'.$profileImageSrc2.'" class="img-circle" alt="userPic" width=50 height=50>'.$result2.'</label>';
                                                        echo '</div>';
                                                    }
                                                }
                                            ?>
                                            <div class="form-group">
                                                 <button type="submit" class="btn btn-primary btn-block">Add Friend</button>
                                            </div>
                                     </form>
                                </div>
                         </div>
                    </li>
                </ul>
            </li>
            <li id="picsNav" data-toggle="tooltip" title="Your Pictures"><a href="web8.php?username=<?php echo $email;?>"><i class="fa fa-picture-o" aria-hidden="true"></i>  Pictures</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown" data-toggle="tooltip" title="Set Profile Picture">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Change Your Profile Picture <span class="caret"></span></a>
                <ul id="login-dp" class="dropdown-menu">
                    <li>
                         <div class="row">
                                <div class="col-md-12">
                                     <form class="form" role="form" method="post" action="web5.php?username=<?php echo $email;?>" accept-charset="UTF-8" id="pic-nav">
                                            <div class="form-group">
                                                 <label class="sr-only" for="profilePicAddr">Profile Pic Address</label>
                                                 <input type="url" class="form-control" id="profilePicAddr" placeholder="Address" name="picAddr">
                                            </div>
                                            <div class="form-group">
                                                 <button type="submit" class="btn btn-primary btn-block">Change</button>
                                            </div>
                                     </form>
                                </div>
                         </div>
                    </li>
                </ul>
            </li>
          </ul>
      </div>
</nav>

<div class="container">
  <h3>Chat Room</h3><h5><b>(Click one to chat)</b></h5>
  <button type="button" class="btn btn-danger" onclick="collapseAll()" id="butColl">Toggle All Chats</button>
  <p><h4>Have fun talking with your pals &amp; don't forget to make <br>more friends as friends are always there for you.</h4></p>
    <div id="msgHistory">
    </div>
</div>
<footer>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <div class="container" id="footerContainer">
    <hr>
    <!-- <i class="fa fa-github" aria-hidden="true"></i> -->
        <div class="text-center center-block">
                <a href="https://www.facebook.com/profile.php?id=100003715225472"><i id="social-fb" class="fa fa-facebook-square fa-3x social" data-toggle="tooltip" title="Facebook"></i></a>
                <a href="https://twitter.com/SatyaPr09006118"><i id="social-tw" class="fa fa-twitter-square fa-3x social" data-toggle="tooltip" title="Twitter"></i></a>
                <a href="https://github.com/satyaprakash-1729"><i id="social-gh" class="fa fa-github fa-3x social" data-toggle="tooltip" title="Github"></i></a>
                <a href="mailto:mathayus1729@gmail.com"><i id="social-em" class="fa fa-envelope-square fa-3x social" data-toggle="tooltip" title="Contact by email"></i></a>
</div>
    <hr>
</div>
</footer>
</body>
</html>

<script type="text/javascript">
    var collapseAll = function(){
        $('.collapse').collapse('toggle');
    }
    var update1 = false;
    <?php $update=false;?>
        $( function() {
            $( "#datepicker" ).datepicker({
            format: 'yy-mm-dd',
            todayHighlight: true,
            showOn: "both",
            autoclose: true,
        });
          } );
        $(document).ready(function() {
            setInterval("ajaxd()",1000);
            setInterval("updater()", 1000);
        });
        window.onload = function(){
            update1 = true;
        };
        var update1 = false;
        var Tdata={};
        var userId = <?php echo $userId;?>;
        var email = <?php echo "'".$email."'";?>;
        function updater(){
            $.ajax({
               method: "GET",
               url: "update.php",
               //dataType: "json",
               data: {userId: userId},
               success: function(data){
                    Tdata = JSON.parse(data);
                    //console.log("-->>>>>>>>>>"+data[0]+data[1]+data[2]+data[3]);
               }
           });
            // console.log("------------->>>>>>"+Tdata+"");
        }
        function ajaxd() {
            console.log(Tdata);
            var toUpdate = Tdata.message;
             if(toUpdate=="yes" || update1==true){
              $.ajax({
               type: "GET",
               url: "chatHis.php",
               data: {userId: userId, email: email},
               success: function(data){
                 // $(data).appendTo("#msgHistory");
                 $("#msgHistory").html($(data));
                 $('.collapse').collapse('show');
               }
             });
              update1 = false;
              toUpdate = "no";
          }
        }
</script>