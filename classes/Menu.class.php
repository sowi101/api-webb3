<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php

class Menu {
    // Properties
    private $db;
    private $name;
    private $price;
    private $description;
    private $category;
    private $subcategory;

    // Methods

    public function __construct() {
        //Establish database connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

        // Check if there is any errors
        if ($this->db->connect_errno > 0) {
            die("Något har blivit fel vid anslutning till databasen: " . $this->db->connect_error);
        }
    }

    // Set method
    public function setMenuItem(string $name, int $price, string $description, string $category, string $subcategory): bool {
        // Remove bad characters
        $name = $this->db->real_escape_string($name);
        $price = $this->db->real_escape_string($price);
        $description = $this->db->real_escape_string($description);
        $category = $this->db->real_escape_string($category);
        $subcategory = $this->db->real_escape_string($subcategory);

        // Remove tags
        $name = strip_tags($name);
        $price = strip_tags($price);
        $description = strip_tags($description);
        $category = strip_tags($category);
        $subcategory = strip_tags($subcategory);

        // Check that variables is not empty
        if ($name != "" && $price != "" && $description != "" && $category != "" && $subcategory != "") {
            $this->name = $name;
            $this->price = $price;
            $this->description = $description;
            $this->category = $category;
            $this->subcategory = $subcategory;
            return true;
        } else {
            return false;
        }
    }

    // Get methods
    public function getMenuItems(): array {
        // Query to get all rows from table
        $sql = "SELECT * FROM menu ORDER BY price;";

        // Send query to database
        $result = $this->db->query($sql);

        // Return rows as an associative array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getMenuItemById(int $id): array {
        // Check that variable is not empty
        if ($id != null) {
            // Query to get a certain row
            $sql = "SELECT * FROM menu WHERE id=$id;";

            // Send query to database
            $result = $this->db->query($sql);

            // Return row as an associative array
            return $result->fetch_assoc();
        }
    }

    public function saveMenuItem(): bool {
        // Query to insert a row of data into database 
        $sql = "INSERT INTO menu(name, price, description, category, subcategory)VALUES('" . $this->name . "', '" . $this->price . "', '" . $this->description . "', '" . $this->category . "', '" . $this->subcategory . "');";

        // Send query to database, return true if successful
        return $this->db->query($sql);
    }

    public function updateMenuItem(int $id): bool {
        // Query to update a certain row in database
        $sql = "UPDATE menu SET name='" . $this->name . "', price='" . $this->price . "', description='" . $this->description . "', category='" . $this->category . "', subcategory='" . $this->subcategory . "' WHERE id=$id;";

        // Send query to database, return true if successful
        return $this->db->query($sql);
    }

    public function deleteMenuItem(int $id): bool {
        // Check that variable is not empty
        if ($id != null) {
            // Query to delete a certain row in database
            $sql = "DELETE FROM menu WHERE id=$id;";

            // Send query to database, return true if successful
            return $this->db->query($sql);
        }
    }

    public function __destruct() {
        // Close database connection
        $this->db->close();
    }
}

?>