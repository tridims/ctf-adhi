<?php
if (isset($_GET['source'])) {
  highlight_file(__FILE__);
  die();
}
define('APP_RAN', true);
require('flag3.php');
?>
<!DOCTYPE html>
<head>
    <title>Login Page</title>
</head>
<body>
  <!--?source-->
  <h2>Login</h2>
<?php
error_reporting(0);
if (isset($_GET['username']) and isset($_GET['password'])) {
    $uname = (string)$_GET['username'];
    $password = (string)$_GET['password'];

    if ($uname === $password) {
        print '';
    } else if (sha1($uname) === sha1($password)) {
      die(your_flag());
    } else {
        print '<p>Forgot your Password? <a href="https://www.youtube.com/watch?v=BBJa32lCaaY">Here</a></p>';
    }
}
?>
<form method="get">
    <input type="text" name="username" Placeholder="Enter your Username"/>
    <input type="password" name="password" Placeholder="Enter your Password"/>
    <input type="submit">
</form>
</body>