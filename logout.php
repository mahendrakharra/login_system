<?php include("functions_files/init.php");

     session_destroy();

     if(isset($_COOKIE['Mahiwebs'])){

          unset($_COOKIE['Mahiwebs']);

          $name = "Mahiwebs";
          $content = "";
          $time = time()-86400;

          setcookie($name, $content, $time);
    }

     redirect("login.php");
?>