<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Adicional extends Model {

	public $adicional;
	protected static $_table='adicional';
	const blackList = ['id'];

	public function validator(){
		$this->runValidation(new RequiredValidator($this, ['field'=>'adicional','msg'=>'El concepto es invalido.']));
	}
}