<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Tamaño extends Model {

	public $tamaño;
	protected static $_table='tamaño';
	const blackList = ['id'];

	public function validator(){
		$this->runValidation(new RequiredValidator($this, ['field'=>'tamaño','msg'=>'El concepto es invalido.']));
	}
}