<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php

class Booking {
    // Properties
    private $db;
    private $firstname;
    private $lastname;
    private $email;
    private $phonenum;
    private $request;
    private $date;
    private $time;
    private $guests;


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
    public function setBooking(string $firstname, string $lastname, string $email, string $phonenum, string $request, string $date, string $time, int $guests): bool {
        // Remove bad characters
        $firstname = $this->db->real_escape_string($firstname);
        $lastname = $this->db->real_escape_string($lastname);
        $email = $this->db->real_escape_string($email);
        $phonenum = $this->db->real_escape_string($phonenum);
        $request = $this->db->real_escape_string($request);
        $date = $this->db->real_escape_string($date);
        $time = $this->db->real_escape_string($time);
        $guests = $this->db->real_escape_string($guests);

        // Remove tags
        $firstname = strip_tags($firstname);
        $lastname = strip_tags($lastname);
        $email = strip_tags($email);
        $phonenum = strip_tags($phonenum);
        $request = strip_tags($request);
        $date = strip_tags($date);
        $time = strip_tags($time);
        $guests = strip_tags($guests);

        // Check that variables is not empty
        if ($firstname != "" && $lastname != "" && $email != "" && $phonenum != "" && $date != "" && $time != "" && $guests != "") {
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->phonenum = $phonenum;
            $this->request = $request;
            $this->date = $date;
            $this->time = $time;
            $this->guests = $guests;
            return true;
        } else {
            return false;
        }
    }

    // Get methods
    public function getBookings(): array {
        // Query to get all rows from table
        $sql = "SELECT * FROM bookings ORDER BY date, time;";

        // Send query to database
        $result = $this->db->query($sql);

        // Return rows as an associative array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getBookingById(int $id): array {
        // Check that variable is not empty
        if ($id != null) {
            // Query to get a certain row
            $sql = "SELECT * FROM bookings WHERE id=$id;";

            // Send query to database
            $result = $this->db->query($sql);

            // Return row as an associative array
            return $result->fetch_assoc();
        }
    }

    public function saveBooking(): bool {
        // Query to insert a row of data into database 
        $sql = "INSERT INTO bookings(firstname, lastname, email, phonenum, request, date, time, guests)VALUES('" . $this->firstname . "', '" . $this->lastname . "', '" . $this->email . "', '" . $this->phonenum . "', '" . $this->request . "', '" . $this->date . "', '" . $this->time . "', '" . $this->guests . "');";

        // Send query to database, return true if successful
        return $this->db->query($sql);
    }

    public function updateBooking(int $id): bool {
        // Query to update a certain row in database
        $sql = "UPDATE bookings SET firstname='" . $this->firstname . "', lastname='" . $this->lastname . "', email='" . $this->email . "', phonenum='" . $this->phonenum . "', request='" . $this->request . "', date='" . $this->date . "', time='" . $this->time . "', guests='" . $this->guests . "' WHERE id=$id;";

        // Send query to database, return true if successful
        return $this->db->query($sql);
    }

    public function deleteBooking(int $id): bool {
        // Check that variable is not empty
        if ($id != null) {
            // Query to delete a certain row in database
            $sql = "DELETE FROM bookings WHERE id=$id;";

            // Send query to database, return true if successful
            return $this->db->query($sql);
        }
    }

    public function __destruct()
    {
        // Close database connection
        $this->db->close();
    }
}

?>