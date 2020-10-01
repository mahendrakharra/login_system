<?php
/******** CLEAN DATA FUNCTION *******/  
    function clean($string){

        return htmlentities($string);
    }
/******** CLEAN DATA FUNCTION *******/




/******** REDIRECT USER FUNCTION *******/  
    function redirect($location){

        return header("Location:{$location}");
        exit();
    }
/******** REDIRECT USER FUNCTION *******/    




/******** SESSION MESSAGE FUNCTION *******/  
    function set_message($message){

        if(!empty($message)){

        $_SESSION["message"] = $message;
        
        }else{
            
        $message = ""; 
        }
    }
/******** SESSION MESSAGE FUNCTION *******/   




/******** DISPLAY MESSAGE FUNCTION *******/  
    function display_message(){

        if(isset($_SESSION['message'])){
            
            echo $_SESSION['message'];

            unset($_SESSION['message']);
        }
    }
/******** DISPLAY MESSAGE FUNCTION *******/ 




/******** TOKEN GENERATOR FUNCTION *******/
function token_generator(){

    $token = $_SESSION["token"] = md5(uniqid(mt_rand(), true));

    return $token;
}
/******** TOKEN GENERATOR FUNCTION *******/




/******** SHOW ERROR FUNCTION *******/
    function error_show($error){

        echo "<p class='error'> <strong> WARNING : </strong> {$error} <span class='remove'>X</span> </p>"; 
    }
/******** SHOW ERROR FUNCTION *******/




/********** CHECK USERNAME EXISTS FUNCTION *********/
    function username_exists($username){

        $sql_query = "SELECT id FROM users WHERE username = '$username'";
        $result = query($sql_query);
        
        if(row_count($result) == 1){
        return true;    
        }else{
            return false;
        }
    }
/********** CHECK USERNAME EXISTS FUNCTION *********/





/*********** CHECK EMAIL EXISTS FUNCTION *********/
    function email_exists($email){
        $sql_query = "SELECT id FROM users WHERE email = '$email'";
        $result = query($sql_query);

        if(row_count($result) == 1){
            return true;
        }else{
            return false;
        }
    }
/*********** CHECK EMAIL EXISTS FUNCTION *********/




/********** EMAIL SENDING FUNCTION **********/
    function email_send($email, $subject, $msg, $headers){

        return mail($email, $subject, $msg, $headers);
    }
/********** EMAIL SENDING FUNCTION **********/



/************ VALIDATION FUNCTIONS ***********/
    function register_user_validate(){

        $errors = [];  
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){

              $fullname = clean($_POST['fullname']);
              $username = clean($_POST['username']);
              $email    = clean($_POST['email']);
              $password = clean($_POST['password']);
              $repass   = clean($_POST['confirm_password']);
               

              if(strlen($fullname) < 5 || strlen($fullname) > 25){
                  $errors[] = "Fullname must be longer then 5 and smaller then 25 charactar!";
              }
              if(strlen($username) < 3 || strlen($username) > 15){
                  $errors[] = "Username must be longer then 3 and smaller then 15 charactar!";
              }
              if(username_exists($username)){
                   $errors[] = "Username already taken!";
              }
              if(strlen($email) > 50){
                   $errors[] = "Email must be smaller then 50 charactar!";
              }
              if(email_exists($email)){
                   $errors[] = "Email address already registerd!";
              }
              if(strlen($password) < 4 || strlen($password) > 15){
                $errors[] = "Password must be longer then 4 and amaller then 15 charactar!";
              }
              if($password !== $repass){
                  $errors[] = "Password doesn't match!";
              }
              if(!empty($errors)){
                    foreach($errors as $error){
                       error_show($error);
                    }
              }else{

                 if(register_new_user($fullname, $username, $email, $password)){
                     
                     set_message("<p class='bg-success text-center'>Please check your email or spam folder for activation link!</p>");
                     redirect("index.php");
                 }else{

                     set_message("<p class='bg-success text-center'>Sorry! User is not activated!</p>");
                     redirect("index.php");
                 }
              }
          }
    }     // function close
/************ VALIDATION FUNCTIONS ***********/





/************* REGISTER USER FUNCTION ************/
    function register_new_user($fullname, $username, $email, $password){
    
        $fullname = escape($fullname);
        $username = escape($username);
        $email    = escape($email);
        $password = escape($password);
        
        if(username_exists($username)){
            return false;
        } 
        else if(email_exists($email)){
            return false;
        }
        else{
            
            $password        = md5($password);
            $validation_code = md5($username . microtime());

            $sql_query  = "INSERT INTO users (fullname, username, email, password, validation_code, active) ";
            $sql_query .= " VALUES('$fullname', '$username', '$email', '$password', '$validation_code', 0)";


            $result = query($sql_query);
            error_check($result);

            $subject = "Activation Link!";

            $msg = "Please click the link below to activate your account
                    http://localhost/login/activate.php?email=$email&code=$validation_code ";

            $headers = "From: noreply@mahiwebs.com";

            email_send($email, $subject, $msg, $headers);

            return true;
        }
    }    
/************* REGISTER USER FUNCTION ************/





/************ ACTIVATE THE USER FUNCTION ***********/
    function activate_user(){

        if($_SERVER['REQUEST_METHOD'] == "GET"){

            if(isset($_GET['email'])){

            $email = clean($_GET['email']);
            $validation_code = clean($_GET['code']);

            $sql = "SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code = '".escape($_GET['code'])."' ";

            $result = query($sql);
            error_check($result);

            if(row_count($result) == 1){

                echo "User found!";

                $update_query = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."' AND validation_code = '".escape($validation_code)."' ";

                $updated_result = query($update_query);
                error_check($updated_result);

                set_message("<p class='bg-success'> Your account has been activated please login! </p>");
                redirect("login.php");

            }else{

                set_message("<p class='bg-danger'> Sorry, Your account could not be activated! </p>");
                redirect('login.php');
            }

            }
        }
    }   // Function end
/************ ACTIVATE THE USER FUNCTION ***********/





/************* VALIDATE USER LOGIN FUNCTION *************/
    function validate_user_login(){

        $errors = [];

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $email    = clean($_POST['email']);
            $password = clean($_POST['password']);
            $remember = isset($_POST['remember']);

            if(empty($email) && empty($password)){

                $errors[] = "Email and password require!";
            }

            if(!empty($errors)){

                foreach($errors as $error){
                    error_show($error);
                }
            }else{

                if(login_user($email, $password, $remember)){

                    redirect("admin.php");

                }else{

                    error_show("Incorrect email and password!");
                }
            }
        }
    }
/************* VALIDATE USER LOGIN FUNCTION *************/




/********** LOGIN USER FUNCTION **********/
    function login_user($email, $password, $remember){

        $sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active = 1 ";
        
        $result = query($sql);

        if(row_count($result) == 1){

        $row = fetch_array($result);

        $user_password = $row['password'];

        if(md5($password) === $user_password){

            // remember me check on / off
            if($remember == "on"){

                $name = "cookie";
                $content = "new cookies set";
                $time = time()+86400;
    
                setcookie($name, $content, $time);
            }

            $_SESSION['email'] = $email;

            return true;
        }else{

            return false;
        }

        return true;
        
        }else{
        
        return false;
        }
    } //end function
/********** LOGIN USER FUNCTION **********/





/************* LOGGED IN FUNCTION ************/ 
    function logged_in(){

        if(isset($_SESSION['email']) || isset($_COOKIE['login details'])){

            return true;
        
        }else{
            
            return false;
        }
    }  // Function end
/************* LOGGED IN FUNCTION ************/ 






/************** RECOVER PASSWORD FUNCTION ************/
    function recover_password(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            
            if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']){

                $email = clean($_POST['email']);

                if(email_exists($email)){

                    $validation_code = md5($email . microtime());

                    $name = "temp_access";
                    $expire = time() + 900;           
                    setcookie($name, $validation_code, $expire);


                    $sql_query = "UPDATE users SET validation_code = '".escape($validation_code)."' WHERE email = '".escape($email)."' ";
                    $result = query($sql_query);
                    error_check($result);

                    $subject = "Please reset your password!";
                    $message = "Here is your password reset code {$validation_code}  
                    Click here to reset password: http://localhost/login/code.php?email=$email&code=$validation_code
                    ";
                    $headers = "From: noreply@mahiwebs.com";

                    // modification if any error found

                    email_send($email, $subject, $message, $headers);


                    set_message("<p class='bg-success text-center'>Please check your email or spam folder to reset password!</p>");
                    redirect("index.php");

                    }else{

                    echo error_show("This email doesn't exists!");
                    }

            }else{

            redirect("index.php");
            }  // token    

            if(isset($_POST['cancel_submit'])){

                redirect("login.php");
            }   //cancel buton
        } // request method
    }  //function end
/************** RECOVER PASSWORD FUNCTION ************/






/********** CODE VALIDATION **********/
    function validate_code(){

        if(isset($_COOKIE["temp_access"])){

                if(!isset($_GET['email']) && !isset($_GET['code'])){

                    redirect("index.php");

                }elseif(empty($_GET['email']) || empty($_GET['code'])){

                    redirect("index.php");

                }else{

                    if(isset($_POST['code'])){

                        $email = clean($_GET['email']);
                        $validation_code = clean($_POST['code']);
                        
                        $sql = "SELECT id FROM users WHERE validation_code = '".escape($validation_code)."' AND email = '".escape($email)."' ";
                        $result = query($sql);
                        error_check($result);

                        if(row_count($result) == 1){

                            $name = "temp_access";
                            $expire = time() + 900;           
                            setcookie($name, $validation_code, $expire);

                            redirect("reset.php?email=$email&code=$validation_code");
                        
                        }else{

                            echo error_show("Sorry validation code is not correct!");

                        }
                    }
                }
            
        }else{

            set_message("<p class='bg-success'> Sorry your validation cookie was expire! </p>");
            redirect("recover.php");
        }
    } // function close
/********** CODE VALIDATION **********/




/*********** PASSWORD  RESET FUNCTION ***********/
    function password_reset(){

        if(isset($_COOKIE["temp_access"])){

        if(isset($_GET['email']) && isset($_GET['code'])){    

        if(isset($_SESSION['token']) && isset($_POST['token']) || $_POST['token'] === $_SESSION['token']){

            if($_POST['password'] === $_POST['confirm_password']){

            $updated_password = md5($_POST['password']);

            $sql = "UPDATE users SET password = '".escape($updated_password)."', validation_code = 0 WHERE email = '".escape($_GET['email'])."' ";
            $result = query($sql);
        
            set_message("<p class='bg-success'> Your password has been reset please login with new one! </p>");
            redirect("login.php");

            }else{
                echo error_show("Your password doesn't match!");
        }
        }
        }else{

        set_message("<p class='bg-danger text-center'>Sorry, Your time has expired!</p>");
        redirect('recover.php');
        } 
    }
    } // function end
/*********** PASSWORD  RESET FUNCTION ***********/

?>