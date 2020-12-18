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

# Log in
There are 3 users at start which you can use to log in and test the functions:

  user: test1
  pass: test1

  user: test2
  pass: test2

  user: test3
  pass: test3

test1 and test2 works at the same company and test3 works at another company.

# User types and restrictions
There are 3 user types:

Superuser - Not in use for the moment but is meant to be able to log in for a special page accessing all information about all companies and add new ones.

Admin - Able to change company information, add and edit projects and new users. Print time reports about employees.

User - Read project information, add notes and pictures, store working hours.
