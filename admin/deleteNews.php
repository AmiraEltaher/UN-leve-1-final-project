<?php
include_once("includes/logged.php");

if(isset($_GET["id"])){
    try{
    include_once("includes/dbConnection.php");
    $id=$_GET["id"];
    $sql = "DELETE FROM `news` WHERE id=?";
    $stmt = $conn-> prepare($sql);
    $stmt-> execute([$id]);
    echo "Deleted Successfully";
    }
    catch(PDOException $e){
        echo "Connection failed: " .$e->getMessage();
      }



}
else{
    echo "Invalid Request";
}

?>