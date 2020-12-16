<?php

  // define('DB_SERVER', 'Localhost:3036');

  define('DB_SERVER',   '[server name]');

  define('DB_USERNAME', '[database username]');

  define('DB_PASSWORD', '[database password]');

  define('DB_DATABASE', '[database name]');



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