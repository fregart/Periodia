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
