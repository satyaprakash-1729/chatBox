<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.3"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    body {
        background-color: #88BBEE;
    }
    #titleLabel {
        margin-left: 10px;
    }
    #info {
        color: #009933;
        font-weight: bold;
        font-size: 20px;
    }
    #footerContainer{
            background-color: #446677;
            width: 1300px;
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
      <li class="active"><a href="index.php"><i class="fa fa-sign-in" aria-hidden="true"></i>  Login</a></li>
      <li class="[ hidden-xs ]"><a href="#toggle-search" class="[ animate ]"><span class="[ glyphicon glyphicon-search ]"></span></a></li>
    </ul>
  </div>
</nav>

<div class = "container">
    <center><h2><b><div id="titleLabel">Welcome to MyChat</div></b></h2>
    <div class="container-fluid" id="info">
        Please login or register yourself if you want to enjoy MyChat.
    </div>
    </center>
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