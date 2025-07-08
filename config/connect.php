<?php
// Create the database connection using constants previously created.
   
   // Inserting constants content
   require_once "config/constants.php";

   // Create the database connection
   $conn = new mysqli(HOSTNAME, HOSTUSER, HOSTPASS, DBNAME);

   // Verify the connection
   if($conn->connect_error) {
      die("Connection Failed: " . $conn->connect_error);
   }
   //echo "Connected successfully";
   
?>