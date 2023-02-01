<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php

//Auto-inclusion of class files
spl_autoload_register(function ($class_name) {
    include "classes/" . $class_name . ".class.php";
});

//Settings for database connection
$dev_mode = false;

if ($dev_mode) {
    // Settings localhost
    define("DBHOST", "localhost");
    define("DBUSER", "webb3projekt");
    define("DBPASSWORD", "password");
    define("DBDATABASE", "webb3projekt");
} else {
    // Settings for MIUN server
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "sowi2102");
    define("DBPASSWORD", "sr9PbgNPSM");
    define("DBDATABASE", "sowi2102");
}
?>