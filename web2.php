<!-- 
Author: Satya Prakash, CSE, IIT Guwahati
Project: Simple Chat Page
 -->
<!DOCTYPE html>
<?php
$cookie_name = "user";
$cookie_value = "satya prakash";
setcookie($cookie_name, $cookie_value, time() + (3600 * 2), "/"); // 86400 = 1 day
//setcookie($cookie_name, "", time() - 3600 );
?>
<html>
<body>

<?php
echo var_dump($_COOKIE);
if(!isset($_COOKIE[$cookie_name])) {
     echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
     echo "Cookie '" . $cookie_name . "' is set!<br>";
     echo "Value is: " . $_COOKIE[$cookie_name];
}
?>

<p><strong>Note:</strong> You might have to reload the page to see the value of the cookie.</p>

</body>
</html>