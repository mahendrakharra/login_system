/********** DATABASE CONNECTION *********/

  $db['db_host'] = "localhost";
  $db['db_user'] = "mahiwebs";
  $db['db_pass'] = "mahi@@";
  $db['db_name'] = "login_system";

  foreach($db as $key => $value){
     define(strtouper($key), $value);
  }

  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if(!$connection){
      die("ERROR : " . mysqli_error($connection));
  }