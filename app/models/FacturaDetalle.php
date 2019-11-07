<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class FacturaDetalle extends Model {

	public $factura_id,$tipo_producto,$leche,$sabor,$tamaño,$adicional,$cantidad,$valor;
	protected static $_table='factura_detalle';
	const blackList = ['id'];

	public function validator(){
	    $this->runValidation(new RequiredValidator($this,['field'=>'tipo_producto','msg'=>"El tipo producto es requerido."]));
	}
}