<?php
namespace App\Models;
use Core\Model;
use Core\Validators\EmailValidator;

class Clientes extends Model {

	public $documento,$nombre,$direccion,$barrio,$telefono,$celular,$correo,$fecha_nacimiento;
	protected static $_table='clientes';
	const blackList = ['id'];

	public function validator(){
		$this->runValidation(new EmailValidator($this, ['field'=>'correo','msg'=>'El correo electrónico es invalido.']));
	}
}