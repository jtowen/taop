<?php
require_once 'DB.class.php';
//
// User
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
  public $address_state;
  public $address_zip;

  function __construct($data) {
    $this->UID = (isset($data['user_ID'])) ? $data['user_ID'] : "";
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
  }

  public function save($isNewUser = false) {
    //create a new database object.
    $db = new DB();

    $email = mysqli_real_escape_string($connection, $this->email);
    $firstName = mysqli_real_escape_string($connection, $this->firstName);
    $lastName = mysqli_real_escape_string($connection, $this->lastName);
    $address_street = mysqli_real_escape_string($connection, $this->address_street);
    $address_city = mysqli_real_escape_string($connection, $this->address_city);
    $address_state = mysqli_real_escape_string($connection, $this->address_state);
    $address_zip = mysqli_real_escape_string($connection, $this->address_zip);
    //if the user is already registered and we're
    //just updating their info.
    if(!$isNewUser) {
      //set the data array
      $data = array(
        "password" => "'$this->hashedPassword'",
        "email" => "'$email'",
        "firstName" => "'$firstName'",
        "lastName" => "'$lastName'",
        "address_street" => "'$address_street'",
        "address_city" => "'$address_city'",
        "address_state" => "'$address_state'",
        "address_zip" => "'$address_zip'"
      );
      //update the row in the database
      $db->update($data, 'users', 'user_ID = '. $this->UID);
    } else {
      //if the user is being registered for the first time.
      $data = array(
        "password" => "'$this->hashedPassword'",
        "email" => "'$email'",
        "firstName" => "'$firstName'",
        "lastName" => "'$lastName'",
        "address_street" => "'$address_street'",
        "address_city" => "'$address_city'",
        "address_state" => "'$address_state'",
        "address_zip" => "'$address_zip'",
        "date_registered" => "'".date("Y-m-d H:i:s",time())."'"
      );
      $this->UID = $db->insert($data, 'users');
      $this->dateRegistered = time();
    }
    return true;
  }


}
?>
