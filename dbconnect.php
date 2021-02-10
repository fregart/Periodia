<?php

  // define('DB_SERVER', 'Localhost:3036');

  define('DB_SERVER', 'localhost');

  define('DB_USERNAME', 'zwwxklcp_wp645');

  define('DB_PASSWORD', '4p3@.7SmEn');

  define('DB_DATABASE', 'zwwxklcp_wp645');



  // create connection $db   

  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);



  // change character set to utf8

  if (!$db->set_charset("utf8")) {

    printf("Error loading character set utf8: %s\n", $db->error);

  }


  // connection error

  if (!$db) {      

    $error = "Ett fel uppstod vid anslutning till databasen";

  }

?>