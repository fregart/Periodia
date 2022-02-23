<?php

  // define('DB_SERVER', 'Localhost:3036');

  define('DB_SERVER', 'mysql88.unoeuro.com');

  define('DB_USERNAME', 'fredrikedman_se');

  define('DB_PASSWORD', 'mcy6fBra49D2');

  define('DB_DATABASE', 'fredrikedman_se_db_periodia');



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