<?php
require_once 'Db.class.php';
//
// User
//
// DB support class for the user table.
//
class User {
// Properties
public $UID;
public $hashedPassword;
public $email;
public $dateRegistered;
public $firstName;
public $lastName;
public $address_street;
public $address_city;
public $phone;
public $db;
//Constructor is called whenever a new object is created.
//Takes an associative array with the DB row as an argument.
function __construct($data) {
$this->UID = (isset($data['user_id'])) ? $data['user_id'] : "";
//$this->username = stripslashes((isset($data['username'])) ? $data['username'] : "");
$this->hashedPassword = (isset($data['password'])) ? $data['password'] : "";
$this->email = stripslashes((isset($data['email'])) ? $data['email'] : "");
$this->dateRegistered = (isset($data['date_registered'])) ? $data['date_registered'] : "";
$this->firstName = stripslashes((isset($data['firstName'])) ? $data['firstName'] : "");
$this->lastName = stripslashes((isset($data['lastName'])) ? $data['lastName'] : "");
$this->userPriv = (isset($data['userPriv'])) ? $data['userPriv'] : "";
$this->address_street = stripslashes((isset($data['address_street'])) ? $data['address_street'] : "");
$this->address_city = stripslashes((isset($data['address_city'])) ? $data['address_city'] : "");
$this->address_state = stripslashes((isset($data['address_state'])) ? $data['address_state'] : "");
$this->address_zip = stripslashes((isset($data['address_zip'])) ? $data['address_zip'] : "");
$this->phone = stripslashes((isset($data['phone'])) ? $data['phone'] : "");
}
public function save($isNewUser = false) {
//create a new database object.
$db = new DB;
//$connection = $db->connection;
//$username = mysqli_real_escape_string($connection, $this->username);
$email = $db->connection->real_escape_string($this->email);
$firstName = $db->connection->real_escape_string($this->firstName);
$lastName = $db->connection->real_escape_string($this->lastName);
$address_street = $db->connection->real_escape_string($this->address_street);
$address_city = $db->connection->real_escape_string($this->address_city);
$address_state = $db->connection->real_escape_string($this->address_state);
$address_zip = $db->connection->real_escape_string($this->address_zip);
$phone = $db->connection->real_escape_string($this->phone);
//if the user is already registered and we're
//just updating their info.
if(!$isNewUser) {
//set the data array
$data = array(
//"username" => "'$username'",
"password" => "'$this->hashedPassword'",
"email" => "'$email'",
"firstName" => "'$firstName'",
"lastName" => "'$lastName'",
"address_street" => "'$address_street'",
"address_city" => "'$address_city'",
"address_state" => "'$address_state'",
"address_zip" => "'$address_zip'",
"phone" => "'$phone'"
);
//update the row in the database
//$db->update($data, 'users', 'user_id = '. $this->UID);
}else {
//if the user is being registered for the first time.
$data = array(
//"username" => "'$username'",
"password" => "'$this->hashedPassword'",
"email" => "'$email'",
"address_street" => "'$address_street'",
"address_city" => "'$address_city'",
"address_state" => "'$address_state'",
"address_zip" => "'$address_city'",
"firstName" => "'$firstName'",
"lastName" => "'$lastName'",
"phone" => "'$phone'",
"date_registered" => "'".date("Y-m-d H:i:s",time())."'"
);

$a_param_type = array("s", "s", "s", "s", "s", "s", "s", "s", "s");
$data_for_bind=array_values($data);
$userID = $db->prep($data_for_bind, $a_param_type);
//$this->UID = $db->insert($data, 'users');
//$this->dateRegistered = time();
}
return true;
}
}
?>
