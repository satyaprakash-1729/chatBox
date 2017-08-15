<!-- 
Author: Satya Prakash, CSE, IIT Guwahati
Project: Simple Chat Page
 -->
<?php

$name=$roll=$discipline=$email=$operation="";
$connectionStatus = $operationStatus = $message =$result= "";
if($_SERVER["REQUEST_METHOD"] == "POST"){

$servername = "localhost";
$username = "root";
$password = "hamunaptra";
$dbName = "phpDB";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

$name = test_input($_POST["name"]);
$roll = test_input($_POST["roll"]);
$discipline = test_input($_POST["discipline"]);
$email = test_input($_POST["email"]);
$operation = test_input($_POST["operation"]);
//echo $name."  ".$discipline." ".$operation."<br>";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$connectionStatus = "Connected successfully !!!";

$tableName = "Students";

if(empty($operation)){
    $message = "Please Choose Operation !";
    //header('Location: '.$_SERVER["PHP_SELF"]);
    //die();
}

switch ($operation) {
    case 'delete':
        $query = "DELETE FROM ".$tableName." WHERE roll='".$roll."';";
        if($conn->query($query) === TRUE){
            $operationStatus = "DELETED!!";
        }else{
            $operationStatus = "ERROR !!";
        }
        break;
    case 'show':
        $query = "SELECT * from ".$tableName;
        $results = $conn->query($query);
        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
                $result .= "ID -- ".$row['id']."    Name -- ".$row['name']."    Roll -- ".$row['roll']."    Email -- ".$row['email']."    Dept -- ".$row['discipline']."<br>";
            }
        }else{
            $result = "None!<br>";
        }
        $operationStatus = "Completed!";
        break;
    case 'find':
        $query = "SELECT * from ".$tableName." WHERE roll='".$roll."';";
        $results = $conn->query($query);
        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
                $result .= "ID -- ".$row['id']."    Name -- ".$row['name']."    Roll -- ".$row['roll']."    Email -- ".$row['email']."    Dept -- ".$row['discipline']."<br>";
            }
        }else{
            $result = "None!<br>";
        }
        $operationStatus = "Completed!";
        break;
    case 'data':
        $query = "INSERT INTO ".$tableName." (name, roll, email, discipline)
        VALUES ('".$name."', '".$roll."', '".$email."', '".$discipline."')";
        echo $query;
        if($conn->query($query) === TRUE){
            $operationStatus = "Completed!";
        }else{
            $operationStatus = "Error!";
        }
        $query = "SELECT * from ".$tableName;
        $results = $conn->query($query);
        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
                $result .= "ID -- ".$row['id']."  |  Name -- ".$row['name']."   | Roll -- ".$row['roll']."   | Email -- ".$row['email']."  |  Dept -- ".$row['discipline']."<br>";
            }
        }else{
            $result = "None!<br>";
        }
        break;
    default:
        $message = "Unkown Operation !";
        break;
}
$conn->close();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DATABASE HANDLER</title>
    <h2>
        MySQL Tutorial
    </h2>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h4>SELECT ONE OPERATION</h4>
    <hr width="100%">
    <input type="radio" name="operation" value="data">Enter Data<br>
    <input type="radio" name="operation" value="show">Show Data<br>
    <input type="radio" name="operation" value="find">Find Data by Roll<br>
    <input type="radio" name="operation" value="delete">Delete Data by Roll<br>
    <br>
    <hr width="100%">
    Name : <input type="text" name="name"><br>
    Roll :     <input type="text" name="roll"><br>
    E-mail : <input type="text" name="email"><br>
    Dept. :  <input type="text" name="discipline"><br><br>
    <input type="submit">

    <br><br>
    Connection Status : <?php echo $connectionStatus;?><br>
    Operation Status : <?php echo $operationStatus;?><br>
    Messages : <?php echo $message;?><br>
    Results :<br>
    <?php echo $result;?><br>
</form>

</body>
</html>