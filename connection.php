<?php


     include "credentials.php";
     
     
     //Database connection
     $connection = new mysqli('localhost', $user, $pw, $db);
     
     //Select all records from our table
     $AllRecords = $connection-> prepare ("select * from SCP");
     $AllRecords->execute();
     $result = $AllRecords->get_result();
     
?>
