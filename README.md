# Periodia
Project and time report webapp tool for smaller construction companies

# Installation using XAAMP
Start phpmyadmin and run the 'db_structure.sql' file in the installation folder.

Add a new user and password to the database.

Open the file 'dbconnect.php' and edit:

  define('DB_SERVER',   '[server name]');

  define('DB_USERNAME', '[database username]');

  define('DB_PASSWORD', '[database password]');

  define('DB_DATABASE', 'periodiadb');

There are 3 users at start which you can use to log in and test the functions:

  user: test1
  pass: test1

  user: test2
  pass: test2

  user: test3
  pass: test3

test1 and test2 works at the same company and test3 works at another company.
