<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Login extends Model {
  public $username, $password, $remember_me;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Usuario es requerido.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password es requerido.']));
  }

  public function getRememberMeChecked(){
    return $this->remember_me == 'on';
  }
}
