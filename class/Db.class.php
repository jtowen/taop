<?php

require_once 'User.class.php';

class DB {
  public $connection = null;
public $numRows; // number of rows returned from last select
public $errorCode; // error code from last statement
public $errorMsg;
  protected $db_name = 'c2230a29proj';
  protected $db_user = 'c2230a29';
  protected $db_pass = 'c2230a29';
  protected $db_host = 'localhost';


  public function __construct() {
    $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

    $this->connection = $conn;
    $this->saveStatus();
  }

  public function __destruct() {
    $this->connection->close();
  }

  public function insert($data, $table) {
    $columns = "";
    $values = "";
    // Format the $columns and $values for the insert statement.
    foreach ($data as $column => $value) {
      $columns .= ($columns == "") ? "" : ", ";
      $columns .= $column;
      $values .= ($values == "") ? "" : ", ";
      $values .= "'$value'";
    }
    // Issue the insert statement
    $sql = "insert into $table ($columns) values ($values)";
    $this->result = $this->connection->query($sql);
    // Save the status from the insert.
    $this->numRows = 1;
    $this->saveStatus();
    //return the ID of the user in the database.


    $this->ins_id = $this->connection->insert_id;
    //echo $ins_id;
    return $this->ins_id;
  }

  public function insertUser($data, $table) {
    $columns = "";
    $values = "";
    $numItems = 0;
    // Format the $columns and $values for the insert statement.
    foreach ($data as $column => $value) {
      $numItems++;
      $columns .= ($columns == "") ? "" : ", ";
      $columns .= $column;
      $values .= ($values == "") ? "" : ", ";
      $values .= "'$value'";
    }
    // Issue the insert statement
    print_r($data);
    print_r($columns);
    print_r($values);
    $sql = "insert into $table ($columns) values (?, ?, ?, ?, ?, ?, ?, ?)";
    if($stmt = $this->connection->prepare($sql)) {
     $stmt->bind_param("ssssssss", $columns);
      $stmt->execute();
      //$stmt->bind_result($resultArray);
      //	$stmt->fetch();
      $stmt->close();
    }

    /*$this->result = $this->connection->query($sql);
    // Save the status from the insert.
    $this->numRows = 1;
    $this->saveStatus();
    //return the ID of the user in the database.


    $this->ins_id = $this->connection->insert_id;
    //echo $ins_id;
    return $this->ins_id;*/
  }

  public function delete($table, $where) {
    // Issue the statement.
    $sql = "delete from $table WHERE $where";
    $this->connection->query($sql);
    // Save the status.
    $this->numRows = $this->connection->affected_rows;
    $this->saveStatus();
  }
  protected function saveStatus() {
    $db = $this->connection;
    $this->errorCode = $db->errno;
    $this->errorMsg = $db->error;
  }

  public function prep($a_bind_params, $a_param_type) {
    /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
    $a_params = array();

    $param_type = '';
    $n = count($a_param_type);
    for($i = 0; $i < $n; $i++) {
      $param_type .= $a_param_type[$i];
    }

    /* with call_user_func_array, array params must be passed by reference */
    $a_params[] = & $param_type;

    for($i = 0; $i < $n; $i++) {
      /* with call_user_func_array, array params must be passed by reference */
      $a_params[] = & $a_bind_params[$i];
    }
    $sql = "INSERT INTO users (firstName, lastName, address_street, address_city, address_state, address_zip, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    /* Prepare statement */
    $stmt = $this->connection->prepare($sql);
    if($stmt === false) {
      trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error, E_USER_ERROR);
    }
    print_r($a_params);
    print_r($param_type);
    /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
    call_user_func_array(array($stmt, 'bind_param'), $a_params);

    /* Execute statement */
    $stmt->execute();
    $this->ins_id = $this->connection->insert_id;
    //echo $ins_id;
    return $this->ins_id;


    /* Fetch result to array */
    //$res = $stmt->get_result();
    //while($row = $res->fetch_array(MYSQLI_ASSOC)) {
      //array_push($a_data, $row);
    //}
  }
public function updateUser($a_bind_params, $a_param_type) {
  /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
  $a_params = array();

  $param_type = '';
  $n = count($a_param_type);
  for($i = 0; $i < $n; $i++) {
    $param_type .= $a_param_type[$i];
  }

  /* with call_user_func_array, array params must be passed by reference */
  $a_params[] = & $param_type;

  for($i = 0; $i < $n; $i++) {
    /* with call_user_func_array, array params must be passed by reference */
    $a_params[] = & $a_bind_params[$i];
  }
  $sql = "UPDATE users SET firstName = ?, lastName = ?, address_street = ?, address_city = ?, address_state = ?, address_zip = ?, email = ?, phone = ?, password = ? WHERE user_id = ?";
  /* Prepare statement */
  $stmt = $this->connection->prepare($sql);
  if($stmt === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error, E_USER_ERROR);
    return false;
  }
  print_r($a_params);
  print_r($param_type);
  /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
  call_user_func_array(array($stmt, 'bind_param'), $a_params);

  /* Execute statement */
  $stmt->execute();

  $stmt->close();
  return true;

  /* Fetch result to array */
  //$res = $stmt->get_result();
  //while($row = $res->fetch_array(MYSQLI_ASSOC)) {
    //array_push($a_data, $row);
  //}
}

public function select($fields, $table, $where = "", $order = "") {
$sql = "SELECT $fields FROM $table";
// Append WHERE clause if one was passed in.
if ($where != "")
$sql = $sql . " WHERE $where";
// Append ORDER BY clause if one was passed in.
if ($order != "")
$sql = $sql . " ORDER BY $order";
// Issue the query
$result = $this->connection->query($sql);
// Save and check status after query.
$this->saveStatus();
if ($this->errorCode)
return(null);
else
return $this->processRowSet($result);
}

protected function processRowSet($result) {
$this->numRows = $result->num_rows;
$resultArray = array();
while($row = $this->connection->fetch_assoc())
array_push($resultArray, $row);
// Format the return set.
if($this->numRows == 1)
return $resultArray[0];
else
return $resultArray;
}

public function checkEmailExists($email) {
//$db = $this->db;
$result = $this->select("*","users","email = '$email'");
return($this->numRows != 0);
}

  public function login($email, $password) {
    $hashedPassword=md5($password);


    $sql = "SELECT user_ID from users where email = ? AND password = ?";
      if($stmt = $this->connection->prepare($sql)) {
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $stmt->bind_result($UID);
        $stmt->store_result();
        $numRows = $stmt->num_rows;
        $stmt->fetch();
        $stmt->close();
      }
    if($numRows == 1) {
      return $UID;
    } else {
      return false;
    }
  }
  public function buildUser($UID, $asObject=false) {
    $sql = "SELECT * from users where user_ID = '$UID'";
    $result = $this->connection->query($sql);
    $userData = $result->fetch_assoc();
    	$loggedUser = new User($userData);
      $_SESSION["user"] = serialize($loggedUser);
      $_SESSION["userID"] = $loggedUser->UID;
      $_SESSION["login_time"] = time();
      $_SESSION["logged_in"] = 1;
    if($asObject) {
      return new User($userData);
    } else {
      if($result->num_rows){
        return true;
      } else {
        return false;
      }
    }
  }

public function getProductInfo($productID) {
  $sql = "SELECT products_id, products_title, products_price FROM products WHERE products_id = ?";
  $stmt = $this->connection->prepare($sql);
  $stmt->bind_param("i", $productID);
  $stmt->execute();
  //$stmt->bind_result($products_id, $products_title, $products_price);
  $resArray = $stmt->fetch_assoc;
  return $resArray;
}
  public function logout() {
    unset($_SESSION["user"]);
    unset($_SESSION["userID"]);
    unset($_SESSION["login_time"]);
    unset($_SESSION["logged_in"]);
    session_destroy();
  }
public function updateProduct($a_bind_params, $a_param_type) {
  /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
  $a_params = array();

  $param_type = '';
  $n = count($a_param_type);
  for($i = 0; $i < $n; $i++) {
    $param_type .= $a_param_type[$i];
  }

  /* with call_user_func_array, array params must be passed by reference */
  $a_params[] = & $param_type;

  for($i = 0; $i < $n; $i++) {
    /* with call_user_func_array, array params must be passed by reference */
    $a_params[] = & $a_bind_params[$i];
  }
  $sql = "UPDATE products SET products_quantity = ?, products_category = ?, products_image = ?, products_price = ?, products_last_modified = ?, products_date_available = ?, products_shipping_exception = ?, products_description = ?, products_title = ?, category_description = ? WHERE products_id = ?";
  /* Prepare statement */
  $stmt = $this->connection->prepare($sql);
  if($stmt === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error, E_USER_ERROR);
    return false;
  }
  //print_r($a_params);
  //print_r($param_type);
  /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
  call_user_func_array(array($stmt, 'bind_param'), $a_params);

  /* Execute statement */
  $stmt->execute();

  $stmt->close();
  return true;

  /* Fetch result to array */
  //$res = $stmt->get_result();
  //while($row = $res->fetch_array(MYSQLI_ASSOC)) {
    //array_push($a_data, $row);
  //}
}

public function updateProductAttr($a_bind_params, $a_param_type) {
  /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
  $a_params = array();

  $param_type = '';
  $n = count($a_param_type);
  for($i = 0; $i < $n; $i++) {
    $param_type .= $a_param_type[$i];
  }

  /* with call_user_func_array, array params must be passed by reference */
  $a_params[] = & $param_type;

  for($i = 0; $i < $n; $i++) {
    /* with call_user_func_array, array params must be passed by reference */
    $a_params[] = & $a_bind_params[$i];
  }
  $sql = "UPDATE product_attributes SET product_weight = ?, product_length = ?, product_width = ?, product_height = ?, product_material = ? WHERE product_id = ?";
  /* Prepare statement */
  $stmt = $this->connection->prepare($sql);
  if($stmt === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error, E_USER_ERROR);
    return false;
  }
  print_r($a_params);
  print_r($param_type);
  /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
  call_user_func_array(array($stmt, 'bind_param'), $a_params);

  /* Execute statement */
  $stmt->execute();

  $stmt->close();
  return true;

  /* Fetch result to array */
  //$res = $stmt->get_result();
  //while($row = $res->fetch_array(MYSQLI_ASSOC)) {
    //array_push($a_data, $row);
  //}
}

}
?>
