<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
// Inclusion of config.php
include("includes/config.php");

// Create connection to database
$db = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
if ($db->connect_errno > 0) {
    die("Något har blivit fel vid anslutning till databasen: " . $db->connect_error);
}

// Create table for bookings
$sql = "DROP TABLE IF EXISTS bookings;";

$sql .=
    "CREATE TABLE bookings(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(70) NOT NULL,
    phonenum VARCHAR(20) NOT NULL,
    request TEXT,
    date VARCHAR(20) NOT NULL,
    time VARCHAR(10) NOT NULL,
    guests INT(1) NOT NULL,
    saved TIMESTAMP NOT NULL DEFAULT current_timestamp()
);
";

// Create table for bookings
$sql .= "DROP TABLE IF EXISTS menu;";

$sql .=
    "CREATE TABLE menu(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(70) NOT NULL,
    price int(4) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    subcategory VARCHAR (50) NOT NULL
);
";

// Create table for users
$sql .= "DROP TABLE IF EXISTS users;";

$sql .=
    "CREATE TABLE users(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(70) NOT NULL,
    password VARCHAR(256) NOT NULL
);
";

// Print query to screen
echo "<pre>$sql</pre>";

// Message of success or error
if ($db->multi_query($sql)) {
    echo "Tabeller installerade.";
} else {
    echo "Fel vid installation av tabeller.";
}

?>