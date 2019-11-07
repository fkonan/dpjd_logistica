<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Producto extends Model {

	public $producto,$valor;
	protected static $_table='producto';
	const blackList = ['id'];

	public function validator(){
	    $this->runValidation(new RequiredValidator($this,['field'=>'producto','msg'=>'Nombre del producto es requerido.']));
	    $this->runValidation(new RequiredValidator($this,['field'=>'valor','msg'=>'El Valor es requerido.']));
	}
}