<?php
namespace App\Models;
use Core\Model;
use App\Models\Users;
use App\Models\UserSessions;
use Core\Cookie;
use Core\Session;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use Core\DB;

class Users extends Model {
  protected static $_table='usuario', $_softDelete = true;
  public static $currentLoggedInUser = null;
  //public $id,$user,$password,$documento,$nombre,$acl,$estado = 0,$confirm;
  public $IdUsuario,$Usuario,$Password,$Estado,$Identificacion,$Nombre,$Apellido,$Cargo,$acl='["ADMIN"]';
  
  const blackList = ['IdUsuario'];

  public function beforeSave(){
    $this->getDate();
    $this->getTime();
    $this->estado=true;
    if($this->isNew()){
      $this->acl='["OPERADOR"]';
      $this->rol='OPERADOR';
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }

  public static function findByUsername($username) {
    return self::findFirst(['conditions'=> "user = ?", 'bind'=>[$username]]);
  }

  public static function currentUser() {
    //Validar si la cookie que viene de intranet esta definida
    //if(isset($_COOKIE['Datos']['IdUsuario'])){
    //Si la cookie esta definida se llena el array currentLoggedInUser consultando la bd por IdUsuario
      self::$currentLoggedInUser = self::findFirst(
        [
          'columns'=>'IdUsuario,Usuario,Password,Estado,Identificacion,Nombre,Apellido,Cargo,IdSucursal',
          'conditions'=>['IdUsuario = ?'],
          'bind'=>[(int)$_COOKIE['Datos']['IdUsuario']]
        ]);
      Session::set(CURRENT_USER_SESSION_NAME, self::$currentLoggedInUser->IdUsuario);
      return self::$currentLoggedInUser;
   // }else{
   //   header('Location: '.MASTER.'index.php');
    //  return;
   // }
    return self::$currentLoggedInUser;
  }

  public function logout() {
    Session::delete(CURRENT_USER_SESSION_NAME);
    self::$currentLoggedInUser = null;
    header('Location: '.MASTER.'Logout.php');
    return;
  }

  public function acls() {
    if(empty($this->acl)) return [];
    return json_decode($this->acl, true);
  }

  public static function listarUsuarios(){

    $sql = "SELECT Identificacion,Nombre,Apellido,cargo.NombreCargo,Sucursal,Prefijo FROM usuario 
    INNER JOIN rrhh_cargo as cargo on  cargo.IdCargo=usuario.cargo
    INNER JOIN sucursal ON usuario.IdSucursal=sucursal.IdSucursal
    WHERE  usuario.IdSucursal=? and Estado=1 and Empleado=1 ORDER BY Nombre,Apellido;";

    $sucursal=Users::currentUser()->IdSucursal;
    $db = DB::getInstance();
    $db->query($sql,[(int)$sucursal]);

    if($db->count()>0)
      return json_encode($db->results());
    else
      return [];
  }
}
