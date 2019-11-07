<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class DatosPrograma extends Model {

  public $id,$general_id,$programa_id;
  protected static $_table='datos_programa';
  const blackList = ['id'];

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'general_id','msg'=>'Persona es requerido.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'programa_id','msg'=>'Programa es requerido.']));
  }
}