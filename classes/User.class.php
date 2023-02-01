<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php

class User {  
    // Properties
    private $db;
    private $username;
    private $password;

    // Methods

    public function __construct() {
        // Establish database connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

        // Check if there is any errors
        if ($this->db->connect_errno > 0) {
            die("Något har blivit fel vid anslutning till databasen: " . $this->db->connect_error);
        }
    }

    // Set method
    public function setUser(string $username, string $password): bool {
        // Remove bad characters and tags
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
        $username = strip_tags($username);
        $password = strip_tags($password);

        // Check that variable is not empty
        if ($username != "" && $password != "") {
            $this->username = $username;
            $this->password = $password;
            return true;
        } else {
            return false;
        }
    }

    // Login method
    public function logIn(): bool {
        // Query to check if there is a username that match the username from input field
        $sql = "SELECT * FROM users where username = '" . $this->username . "';";

        // Send query to database, save the result
        $result = $this->db->query($sql);

        // Check there any row that equals values from input field
        if ($result->num_rows > 0) {
            // Save the row in variable
            $row = $result->fetch_assoc();
            // Save the password from the row in a variable
            $stored_password = $row['password'];

            // Check if password from input field is equal to the row's hashed password 
            if (password_verify($this->password, $stored_password)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function __destruct()
    {
        // Close database connection
        $this->db->close();
    }
}

?>