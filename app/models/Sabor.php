<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Sabor extends Model {

	public $sabor;
	protected static $_table='sabor';
	const blackList = ['id'];

	public function validator(){
		$this->runValidation(new RequiredValidator($this, ['field'=>'sabor','msg'=>'El concepto es invalido.']));
	}
}