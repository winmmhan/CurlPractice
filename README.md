# CurlPractice

Implemented using php.
Installation
To install PHP, simply:
http://php.net/manual/en/install.php

Requirements:
PHP Curl Class works with PHP 5.3, 5.4, 5.5, 5.6, 7.0, 7.1, 7.2, 
To Enable cURL Support in phpInfo :
•	Open php.ini file with your text editor.
•	Search for php_curl
•	Remove the semicolon to uncomment the curl

Database:
Mysql Database was used to implement the project.

Run the following scripts to set up database.

CREATE DATABASE IF NOT EXISTS curlpractice_db;

CREATE TABLE transcations (
    id int(10),
    url varchar(255),
    content_length varchar(255),
    date varchar(255),
    error varchar(255) 
);

For other Database tools, change the PDO driver mysql to desire Database driver in database.php

$connection = new PDO('mysql:host=localhost;dbName=curlpractice_db;','root','root');



