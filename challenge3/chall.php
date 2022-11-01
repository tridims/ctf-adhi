<?php
if (isset($_GET['source'])) {
  highlight_file(__FILE__);
  die();
}
define('APP_RAN', true);
require('flag.php');
?>

<!DOCTYPE html>

<head>
    <style>
        body {
            display: flex;
            align-items: center;
            flex-direction: column;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <!-- ?source -->
    <h1 class="title-1">Hology's Secret Notes</h1>
    <h3>Tulis Kenangan Indahmu saat bersamanya</h3><br>
    <?php
    error_reporting(0);
    if (isset($_POST['Notes'])){
        $replacer = 'hology5.0';
        $type = $_POST['Notes'];
        $Reset_str = preg_replace("/$replacer/", '', $type);
        echo "<h4>Isi Notes:</h4><p>$Reset_str</p>";
        if ($Reset_str == $replacer) {
            echo "<h4>Sudahilah kegalauanmu, Mari lomba CTF bersamaku</h4><br>";
            your_flag();
        }
        else {
            echo "Bukan waktunya untuk menangisi-nya";
        }
    }
    ?>
    <form method="post">
        <br>
        <br>
        <input type="text" name="Notes" placeholder="Type here" />
        <br>
        <input type="submit"/>
    </form>
</body>
