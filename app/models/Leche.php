<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Leche extends Model {

	public $leche;
	protected static $_table='leche';
	const blackList = ['id'];

	public function validator(){
		$this->runValidation(new RequiredValidator($this, ['field'=>'leche','msg'=>'El concepto es invalido.']));
	}
}