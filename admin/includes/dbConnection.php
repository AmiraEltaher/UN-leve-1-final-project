<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    try{
        $options =array(PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES utf8');
        $conn = new PDO("mysql:host=$servername;port=3306; dbname=un_final_project", $username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
       //echo"<br>";
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }

?>