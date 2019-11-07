<?php
namespace Core;
use \PDO;
use \PDOException;
use \PDOStatement;

class DB {
  private static $_instance = null;
  private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

  private function __construct($driver='MySql',$sistema='B') {
    try {
      switch ($driver) {
        
        case 'MySql':

          $server=CONEXIONES[$driver]['server'];
          $port=CONEXIONES[$driver]['port'];
          $db=CONEXIONES[$driver]['db'];
          $userName=CONEXIONES[$driver]['userName'];
          $password=CONEXIONES[$driver]['password'];
          $driver=CONEXIONES[$driver]['driver'];

          //$this->_pdo = new PDO('mysql:host='.$server.';port='.$port.'dbname='.$db, $userName,$password);
          $this->_pdo = new PDO('mysql:host='.$server.';dbname='.$db, $userName, $password);

          //$this->_pdo = new PDO('mysql:dbname='.$db';host='.$server, $userName,$password);
          $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          $this->_pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES 'utf8'");

          //$this->_pdo->exec("SET NAMES UTF8");
         
          break;
          
        case 'SqlServer':
          
          $server=CONEXIONES[$driver]['server'];
          $userName=CONEXIONES[$driver]['userName'];
          $password=CONEXIONES[$driver]['password'];
          $driver=CONEXIONES[$driver]['driver'];
          if($sistema='B')
            //$db='CAP_DPJ';
            $db='TestSystem_B';
          else
            //$db='TAT_DPJ';
            $db='TestSystem_B';

          $this->_pdo = new PDO('sqlsrv:Server='.$server.';Database='.$db, $userName, $password);
          $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->_pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES , false);
          break;
        
        default:
          die('default');
          $driver=CONEXIONES[$driver]['driver'];
          $server=CONEXIONES[$driver]['server'];
          $port=CONEXIONES[$driver]['port'];
          $db=CONEXIONES[$driver]['db'];
          $userName=CONEXIONES[$driver]['userName'];
          $password=CONEXIONES[$driver]['password'];
          
          $this->_pdo = new PDO('mysql:host='.$server.';port='.$port.'dbname='.$db, $userName, $password);
          $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          $this->_pdo->exec("SET NAMES UTF8");
          break;
      }
    } catch(PDOException $e) {
      die($e);//->getMessage());
    }
  }

  public static function getInstance($driver='MySql') {

    /*if($driver=='MySql'){
      if(!isset(self::$_instance)) {
        self::$_instance = new self($driver);
      }
    }else{
      self::$_instance = new self($driver);
    }*/

    self::$_instance = new self($driver);
    return self::$_instance;
  }


  public function query($sql, $params = [],$class = false) {

    if($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;

      if(count($params)) {

        foreach($params as $param) {
          if($param==""){
            if(gettype($param)==NULL)
              $param=null;
          }
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
      //var_dump($sql);
      if($this->_query->execute()) {
        if($class){
          $this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS,$class);
        } else {
          if(preg_match('/update/i', $sql)||preg_match('/insert/i', $sql)||preg_match('/delete/i', $sql)){  
            $this->_count = $this->_query->rowCount();
            $this->_lastInsertID = $this->_pdo->lastInsertId();
          }else{
            $this->_result =$this->_query->fetchALL(PDO::FETCH_OBJ);
          }
        }

        $this->_count = $this->_query->rowCount();
        $this->_lastInsertID = $this->_pdo->lastInsertId();

      } else {
        $this->_error = true;
      }
    }
       
    return $this;
  }

  protected function _read($table, $params=[],$class) {
    $columns = '*';
    $joins = "";
    $conditionString = '';
    $bind = [];
    $order = '';
    $limit = '';
    $offset = '';
    // conditions
    if(isset($params['conditions'])) {
      if(is_array($params['conditions'])) {
        foreach($params['conditions'] as $condition) {
          $conditionString .= ' ' . $condition . ' AND';
        }
        $conditionString = trim($conditionString);
        $conditionString = rtrim($conditionString, ' AND');
      } else {
        $conditionString = $params['conditions'];
      }
      if($conditionString != '') {
        $conditionString = ' Where ' . $conditionString;
      }
    }

    // columns
    if(array_key_exists('columns',$params)){
      $columns = $params['columns'];
    }

    if(array_key_exists('joins',$params)){

      foreach($params['joins'] as $join){
        //H::dnd($params['joins']);
        $joins .= $this->_buildJoin($join);
      }
      $joins .= " ";
      //H::dnd($joins);
    }

    // bind
    if(array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }

    // order
    if(array_key_exists('order', $params)) {
      $order = ' ORDER BY ' . $params['order'];
    }

    // limit
    if(array_key_exists('limit', $params)) {
      $limit = ' LIMIT ' . $params['limit'];
    }

    // offset
    if(array_key_exists('offset', $params)) {
      $offset = ' OFFSET ' . $params['offset'];
    }

    $sql = "SELECT {$columns} FROM {$table}{$joins}{$conditionString}{$order}{$limit}{$offset}";

    if($this->query($sql, $bind,$class)) {
      if(!count($this->_result)) return false;
      return true;
    }
    return false;
  }

  public function find($table, $params=[],$class=false) {
    if($this->_read($table, $params,$class)) {
      return $this->results();
    }
    return false;
  }

  public function findFirst($table, $params=[],$class=false) {
    if($this->_read($table, $params,$class)) {
      return $this->first();
    }
    return false;
  }

  public function insert($table, $fields = []) {
    $fieldString = '';
    $valueString = '';
    $values = [];
    foreach($fields as $field => $value) {
      $fieldString .= '`' . $field . '`,';
      $valueString .= '?,';
      $values[] = ($value);
    }

    $fieldString = rtrim($fieldString, ',');
    $valueString = rtrim($valueString, ',');
    $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

    if(!$this->query($sql, $values)->error()) {
      return true;
    }
    return false;
  }

  public function update($table, $llave='id',$id, $fields = []) {
    $fieldString = '';
    $values = [];
    foreach($fields as $field => $value) {
      
      if($field!=$llave)
      {
        $fieldString .= ' ' . $field . ' = ?,';
        $values[] = ($value);
      }
    }

    $fieldString = trim($fieldString);
    $fieldString = rtrim($fieldString, ',');

    $sql = "UPDATE {$table} SET {$fieldString} WHERE {$llave} = {$id}";
    if(!$this->query($sql, $values)->error()) {
      return true;
    }
    return false;
  }

  public function delete($table,$llave='id', $id) {
    $sql = "DELETE FROM {$table} WHERE {$llave} = {$id}";
    if(!$this->query($sql)->error()) {
      return true;
    }
    return false;
  }

  public function results() {
    return $this->_result;
  }

  public function first() {
    return (!empty($this->_result))? $this->_result[0] : [];
  }

  public function count() {
    return $this->_count;
  }

  public function lastID() {
    return $this->_lastInsertID;
  }

  public function get_columns($table) {
    return $this->query("SHOW COLUMNS FROM {$table}")->results();
  }

  public function error() {
    return $this->_error;
  }

  protected function _buildJoin($join=[]){
    $table = $join[0];
    $condition = $join[1];
    $alias = $join[2];
    $type = (isset($join[3]))? strtoupper($join[3]) : "INNER";
    $jString = "{$type} JOIN {$table} {$alias} ON {$condition}";
    return " " . $jString;
  }
}
