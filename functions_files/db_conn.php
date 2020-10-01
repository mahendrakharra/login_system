<?php
/********** DATABASE CONNECTION *********/

    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_pass'] = "";
    $db['db_name'] = "login";

    foreach($db as $key => $value){
        define(strtoupper($key), $value);
    }
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/********** DATABASE CONNECTION *********/

  



/********** COUNT TABLE ROW *********/
    function row_count($result){

        return mysqli_num_rows($result);
    }
/********** COUNT TABLE ROW *********/





/********** REAL TIME ESCAPEING FUNCTION *********/
    function escape($string){
    
        global $connection;

        return mysqli_real_escape_string($connection, $string);    
    }
/********** REAL TIME ESCAPEING FUNCTION *********/




/********** CHECK QUERY FUNCTION *********/
    function query($sql_query){

        global $connection;

        return mysqli_query($connection, $sql_query);
    }
/********** CHECK QUERY FUNCTION *********/




/********** CHECK CONECTION ERROR FUNCTION *********/
    function error_check($result){

        global $connection;

        if(!$result){

            die("ERROR : " .mysqli_error($connection));
        }
    }
/********** CHECK CONECTION ERROR FUNCTION *********/





/********** DATA FETCH FUNCTION *********/
    function fetch_array($result){

        global $connection;

        return mysqli_fetch_array($result);

    }  
/********** DATA FETCH FUNCTION *********/
?>