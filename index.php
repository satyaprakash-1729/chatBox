<?php
$emailMsg = $passMsg = $message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $firstname = $lastname = $email = $password = $password2 = "";
    $message = "";
    if(empty($_POST["firstname"])){
        $email = $_POST["email"];
        $password = $_POST["pwd3"];

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
        $query = "SELECT password from ".$tableName." WHERE email='".$email."';";
        if(!empty($email)){ 
            $results = $conn->query($query);
            if($results->num_rows > 0){
                while($row = $results->fetch_assoc()){
                    $result = $row['password'];
                    break;
                }
            }else{
                header('Location: index.php?msg=wrongemail');
            }
        }
        $conn->close();
        if($password===$result){
            $cookie_name = "userChatDB";
            $cookie_value = $email;
            setcookie($cookie_name, $cookie_value, time() + (3600 * 24), "/"); // 86400 = 1 day
            header('Location: web5.php?username='.htmlspecialchars($email));
        }else{
            header('Location: index.php?msg=wrongpass');
        }
    }else{
        //register
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["pwd"];
        $password2 = $_POST["pwd2"];
        if(($password2 !== $password)){
            $message = "Passwords dont match!";
        }else{
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
            $query = "INSERT INTO ".$tableName." (firstname, lastname, email, password)
            VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$password."')";
            $result1 = $conn->query($query);
            $tableName = "UserDesc";
            $query = "INSERT INTO ".$tableName." (email)
            VALUES ('".$email."')";
            if($conn->query($query) === TRUE and $result1===TRUE){
                $cookie_name = "userChatDB";
                $cookie_value = $email;
                setcookie($cookie_name, $cookie_value, time() + (3600 * 24), "/");
                header('Location: web5.php?username='.htmlspecialchars($email));
            }
            $tableName = "Users";
            $query = "SELECT id FROM ".$tableName." where email='".$email."';";
            $resultss = $conn->query($query);
            if($resultss->num_rows>0){
                while($row = $resultss->fetch_assoc()){
                    $userId = $row["id"];
                    $rootDir = "uploads/";
                    $dir = $rootDir."".$userId;
                    if(!file_exists($dir)){
                        mkdir($dir);
                    }
                }
            }
            $conn->close();
        }
    }
}
if (isset($_GET["msg"]))
    $msg = $_GET["msg"];
if(isset($msg)){
    if($msg === "wrongpass"){
        $passMsg = "Wrong Password !";
    }else if($msg==="wrongemail"){
        $emailMsg = "Wrong Email !";
    }else if($msg === "logout"){
        $cookie_name = "userChatDB";
        //echo var_dump($_COOKIE);
        if(isset($_COOKIE[$cookie_name])) {
             setcookie($cookie_name, "", time() - 3600); 
             //echo '<script type="text/javascript">console.log(" Email ");</script>';
             header('Location: index.php');
             //header('Location: web5.php?username='.htmlspecialchars($email));
        }
    }
}
$cookie_name = "userChatDB";
//echo var_dump($_COOKIE);
if(isset($_COOKIE[$cookie_name])) {
    //echo '<script type="text/javascript">console.log(" Email ");</script>';
    debug_to_console( "Here" );
     $email = $_COOKIE[$cookie_name];
     header('Location: web5.php?username='.htmlspecialchars($email));
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.3"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    #descHome {
        color: #004477;
        font-size: 24px;
    }
    body {
        background-color: #88BBEE;
    }
    #formId {
        margin-top: 140px;
        float: right;
        height: 200px;
        width: 500px;
    }
    #titleLabel {
        margin-left: 10px;
    }
    #info {
        color: #009933;
        font-weight: bold;
        font-size: 20px;
    }
    .error {
        color: red;
        font-weight: bold;
    }
    .img-thumbnail {
        width: 600px;
        height: 350px;
    }
</style>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand"><i class="fa fa-comments-o" aria-hidden="true"></i>  <b>MyChat</b>></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active" data-toggle="tooltip" title="Go to Homepage"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>  Home</a></li>
      <li class="dropdown" data-toggle="tooltip" title="Search The Website">
          <a href="#search-dp" class="dropdown-toggle" data-toggle="dropdown"><span class="[ glyphicon glyphicon-search ]"></span></a>
                <ul id="search-dp" class="dropdown-menu">
                    <li>
                         <div class="row">
                                <div class="col-md-12">
                                     <form class="form" role="form" method="post" action="index.php" accept-charset="UTF-8" id="pic-nav">
                                            <div class="form-group">
                                                <label class="control-label" for="city">Keyword</label>
                                                 <input type="text" class="form-control" id="keyword" placeholder="Keyword" name="keyword">
                                            </div>
                                            <div class="form-group">
                                                 <button type="submit" class="btn btn-primary btn-block">Search</button>
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

<div class = "container">
    <h2><b><div id="titleLabel">Welcome to MyChat</div></b></h2>
    <div class="container-fluid" id="info">
        Please either login or register to proceed to the chat page.
    </div>
    <div class="container-fluid" id="formId">
        <div class="panel panel-success">
            <div class="panel-heading">Register or Sign Up</div>
            <div class="panel-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                  </div>
                  <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                  </div>
                  <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" id="pwd" name="pwd" required>
                  </div>
                  <div class="form-group">
                        <label for="pwd2">Confirm Password:</label><span class="error"><?php echo $message;?></span>
                        <input type="password" class="form-control" id="pwd2" name="pwd2" required>
                  </div>
                  <button type="submit" class="btn btn-default" data-toggle="tooltip" title="Press to register yourself">Register</button>
                </form>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">Log In</div>
            <div class="panel-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="form-group">
                    <label for="email">Email address:</label><span class="error"><?php echo $emailMsg;?></span>
                    <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group">
                    <label for="pwd">Password:</label><span class="error"><?php echo $passMsg;?></span>
                    <input type="password" class="form-control" id="pwd3" name="pwd3" required>
              </div>
              <button type="submit" class="btn btn-default" data-toggle="tooltip" title="Press to login for 24 hrs">Log In</button>
            </form>
            </div>
        </div>
</div>
    <div class="container" id="descHome">This is the place for friends to meet and have fun, to look for people who may turn out to be your best friends ever and for you to keep in touch with the lives of all the people you care about. So, good luck and happy "FRIENDING" !!
        <br><br>
        <img src="http://www.rd.com/wp-content/uploads/sites/2/2016/02/02-friends-make-you-more-attractive.jpg" class="img-thumbnail" alt="Friends Pic">
        <br>
        <img src="http://www.ox.ac.uk/sites/files/oxford/styles/ow_medium_feature/public/field/field_image_main/friends_main.jpg" class="img-thumbnail" alt="Friends Pic 2nd">
    </div>
</div>
</body>
</html>