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
header('Access-Control-Allow-Methods: POST');

// Setting that tells which headers that are allowed from client side
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Create new instance of User
$user = new User();

// Read the JSON data that is sent and make it into an object
$data = json_decode(file_get_contents("php://input"), true);

// If statement to call set method with arguments and check if method returns true
if ($user->setUser($data['username'], $data["password"])) {
    // If statement to call login metod and check if method returns true
    if ($user->logIn()) {
        // Send status code
        http_response_code(200); // OK request
        // Save a key with bool value to the response variable
        $response = array("correctUser" => true);
    } else {
        // Send status code
        http_response_code(400); // Bad request
        // Save a message to the response variable
        $response = array("message" => "Fel användaruppgifter.");
    }
} else {
    // Send status code
    http_response_code(400); // Bad request
    // Save a message to the response variable
    $response = array("message" => "Fyll i alla fält.");
}

//Send response back to the user of the webservice
echo json_encode($response);
