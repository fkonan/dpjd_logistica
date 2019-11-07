<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;

class LogisticaPdaAuxiliares extends Model {

	public $CC,$Nombres,$Apellidos,$Tipo,$Estado,$Agencia,$Sistema;
	protected static $_table='logistica_pda_auxiliares';

	public function validator(){
		$camposRequeridos=[
			'CC'=>"Documento",
			'Nombres'=>"Nombres",
			'Apellidos'=>"Apellidos",
			'Tipo'=>"Tipo de separación",
			'Estado'=>"Estado",
			'Agencia'=>"Agencia",
			'Sistema'=>"Sistema"
		];
		foreach($camposRequeridos as $campo => $msn){
			$this->runValidation(new RequiredValidator($this,['field'=>$campo,'msg'=>$msn." es requerido."]));
		}
	    
		$this->runValidation(new UniqueValidator($this,['field'=>'CC','msg'=>'Esta persona ya se encuentra vinculada como auxiliar.']));
	}

	public static function listarAuxiliares(){

  	$sql = "SELECT CC,Nombres,Apellidos,Tipo,Estado,sucursal.Sucursal,pda.Agencia,Sistema 
			FROM logistica_pda_auxiliares as pda
			INNER JOIN  sucursal on pda.Agencia=sucursal.Prefijo order by Nombres,Apellidos";

  	$db = DB::getInstance();
  	if($db->query($sql)->count()>0)
  		return json_encode($db->query($sql)->results());
  	else
  		return [];
  	}
}