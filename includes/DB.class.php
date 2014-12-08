<?php
class DB {
  public $numRows;
  public $errorCode;
  public $errorMsg;
  public $connection = null;
  protected $db_name = 'c2230a29proj';
  protected $db_user = 'c2230a29';
  protected $db_pass = 'c2230a29';
  protected $db_host = 'localhost';

  public function __construct() {
    $this->connection = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    $this->saveStatus();
  }

/*  public function connect() {
    $connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    if(mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
    }
    return true;
  }
  */

  public function processRowSet($rowSet, $singleRow=false) {
    $resultArray = array();
    while($row = mysqli_fetch_assoc($rowSet)) {
      array_push($resultArray, $row);
    }
    if($singleRow === true)
      return $resultArray[0];
    return $resultArray;
  }

  public function select($table, $where = "") {
    if ($where == "")
      $sql = "SELECT * FROM $table";
    else
      $sql = "SELECT * FROM $table WHERE $where";
    $result = $mysqli->query($sql);

    if (!$mysqli->query("SET @a:='this will not work'")) {
        printf("Error: %s\n", $mysqli->error);
    }
    $this->numRows = $result->num_rows;
    if ($this->numRows == 1) {
      return $this->processRowSet ($result, true);
    }
    return $this->processRowSet ($result, false);
  }

  public function select2($fields, $table, $where = "", $order = "") {
    $sql = "SELECT $fields FROM $table";
    if ($where != "")
      $sql = $sql . " WHERE $where";
    if ($order != "")
      $sql = $sql . " ORDER BY $order";
      $result = mysqli_query($connection, $sql);

    if (!$mysqli->query("SET @a:='this will not work'")) {
        printf("Error: %s\n", $mysqli->error);
    }
    $this->numRows = $result->num_rows;
    if ($this->numRows == 1) {
      return $this->processRowSet ($result, true);
    }
    return $this->processRowSet ($result, false);
  }

  //Updates a current row in the database.
  //takes an array of data, where the keys in the array are the column names
  //and the values are the data that will be inserted into those columns.
  //$table is the name of the table and $where is the sql where clause.
  public function update($data, $table, $where) {
    foreach ($data as $column => $value) {
      $sql = "UPDATE $table SET $column = $value WHERE $where";
      $mysqli->query($sql);
      if (!$mysqli->query($sql)) {
        printf("Error: %s\n", $mysqli->error);
      }
    }
    return true;
  }

  //Inserts a new row into the database.
  //takes an array of data, where the keys in the array are the column names
  //and the values are the data that will be inserted into those columns.
  //$table is the name of the table.
  public function insert($data, $table) {
    $columns = "";
    $values = "";
    foreach ($data as $column => $value) {
      $columns .= ($columns == "") ? "" : ", ";
      $columns .= $column;
      $values .= ($values == "") ? "" : ", ";
      $values .= $value;
    }
    $mysqli->query($sql);
    if (!$mysqli->query($sql)) {
      printf("Error: %s\n", $mysqli->error);
    }
    //return the ID of the user in the database.
    return mysqli_insert_id($connection);
  }


  public function delete($table, $where) {
    $sql = "delete from $table WHERE $where";
    $mysqli->query($sql);
    if (!$mysqli->query($sql)) {
      printf("Error: %s\n", $mysqli->error);
    }
  }

  protected function saveStatus() {
    $db = $this->connection;
    $this->errorCode = $db->errno;
    $this->errorMsg = $db->error;
  }
}
?>
