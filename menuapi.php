<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
//Inclusion of configuration file
include("includes/config.php");

// Headers with settings for the webservice
// Setting to allow access to webservice from all domains
header('Access-Control-Allow-Origin: *');

// Setting to make webservice send data in JSON format
header('Content-Type: application/json');

// Setting that tells which methods that are allowed
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

// Setting that tells which headers that are allowed from client side
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Variable that store which method that is used
$method = $_SERVER['REQUEST_METHOD'];

// If statement to check if a parameter named id is set
if (isset($_GET['id'])) {
    // Variable that store the value from the id parameter
    $id = $_GET['id'];
}

// Create new instance of Menu
$menu = new Menu();

// Switch that run diffrent code dependning on value of the method variable.
switch ($method) {
    case 'GET':
        // If statement to check if the variable id is set or not
        if (isset($id)) {
            // Call of method to get data about a certain menuitem
            $response = $menu->getMenuItemById($id);
        } else {
            // Call of method to get data about all menuitems
            $response = $menu->getMenuItems();
        }

        // If statement to check if the response variable is empty or not
        if (count($response) === 0) {
            // Save a message to the response variable
            $response = array("message" => "Inga rätter eller drycker är lagrade i databasen.");
            // Send status code
            http_response_code(404); // Not found
        } else {
            // Send status code
            http_response_code(200); // Request OK
        }
        break;

    case 'POST':
        // Read the JSON data that is sent and make it into an object
        $data = json_decode(file_get_contents("php://input"), true);

        // If statement to call set method with arguments and check if method returns true
        if ($menu->setMenuItem($data['name'], $data['price'], $data['description'], $data['category'], $data['subcategory'])) {
            // If statement to call save method and check if method returns true
            if ($menu->saveMenuItem()) {
                // Send status code
                http_response_code(201); // Created
                // Save a message to the response variable
                $response = array("message" => "Rätten/drycken är tillagd i databasen.");
            } else {
                // Send status code
                http_response_code(500); // Internal Server Error
                // Save a message to the response variable
                $response = array("message" => "Fel vid lagring av rätten/drycken.");
            }
        } else {
            // Send status code
            http_response_code(400); // Bad request
            // Save a message to the response variable
            $response = array("message" => "Fyll i alla fält innan formuläret skickas.");
        }
        break;

    case 'PUT':
        // Read the JSON data that is sent and make it into an object
        $data = json_decode(file_get_contents("php://input"), true);

        // If statement to call set method with arguments and check if method returns true
        if ($menu->setMenuItem($data['name'], $data['price'], $data['description'], $data['category'], $data['subcategory'])) {
            // If statement to call update method and check if method returns true
            if ($menu->updateMenuItem($id)) {
                // Send status code
                http_response_code(200); // Request OK
                // Save a message to the response variable
                $response = array("message" => "Rätten/drycken är uppdaterad.");
            } else {
                // Send status code
                http_response_code(500); // Internal Server Error
                // Save a message to the response variable
                $response = array("message" => "Fel vid uppdatering av rätten/drycken.");
            }
        } else {
            // Send status code
            http_response_code(400); // Bad request
            // Save a message to the response variable
            $response = array("message" => "Kolla att alla fält fortfarande är ifyllda innan rätten/drycken uppdateras.");
        }
        break;

    case 'DELETE':
        // If statement to check if the variable id is set or not
        if (!isset($id)) {
            // Send status code
            http_response_code(400); // Bad request
            // Save a message to the response variable
            $response = array("message" => "Inget id är skickat");
        } else {
            // If statement to call delete method and check if method returns true.
            if ($menu->deleteMenuItem($id)) {
                // Send status code
                http_response_code(200); // Request OK
                // Save a message to the response variable
                $response = array("message" => "Rätten/drycken är raderad");
            }
        }
        break;
}

//Send response back to the user of the webservice
echo json_encode($response);
