<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\NumericValidator;
use Core\Validators\EmailValidator;
use Core\Validators\UniqueValidator;

class DatosGenerales extends Model {

  public $id,$tipo_doc_id,$documento,$primer_apellido,$segundo_apellido,$nombres,$fecha_nacimiento,$edad,$sexo,$estado_civil;
  public $pais_nac_id,$depto_nac_codigo,$muni_nac_codigo,$nivel_educativo_id,$graduado_opcion,$ocupacion_id,$profesion_id,$pais_id;
  public $depto_codigo,$muni_codigo,$comuna_codigo,$barrio_codigo,$corregimiento_codigo,$vereda_codigo,$direccion,$estrato;
  public $grupo_etnico_id,$discapacidad_id,$telefono,$telefono2,$correo,$correo2,$situacion_particular_id,$fecha_registro;


  public $niveles_cursados,$ocupacion_opcion ,$nucleo_familiar ,$tipo_doc_acudiente_id ,$documento_acudiente ,$nombre_acudiente,$telefono_acudiente ,$parentesco_id ,$afiliacion_id,$eps_id,$tipo_servicio,$servicio_id;

  protected static $_table='datos_generales';
  const blackList = ['id','eps_id '];

	public function validator(){
		$camposRequeridos=[
		    'tipo_doc_id'=>"Tipo de documento",
		    'documento'=>"Documento",
		    'primer_apellido'=>"Primer apellido",
		    'nombres'=>"Nombres",
		    'fecha_nacimiento'=>"Fecha de nacimiento",
		    'edad'=>"Edad",
		    'pais_nac_id'=>"Pais de nacimiento",
		    'depto_nac_codigo'=>"Departamento de nacimiento",
		    'muni_nac_codigo'=>"Municipio de nacimiento",
		    'muni_codigo'=>"Municipio de residencia",
		    'direccion'=>"Dirección",
		    'telefono'=>"Teléfono",
		    'tipo_servicio'=>'Tipo de servicio',
		    'servicio_id'=>'Servicio'
		];
		foreach($camposRequeridos as $campo => $msn){
		    $this->runValidation(new RequiredValidator($this,['field'=>$campo,'msg'=>$msn." es requerido."]));
		}
		$this->runValidation(new NumericValidator($this, ['field'=>'estrato','msg'=>'Estrato es numerico.']));
		$this->runValidation(new EmailValidator($this, ['field'=>'correo','msg'=>'El correo electrónico es invalido.']));
		$this->runValidation(new EmailValidator($this, ['field'=>'correo2','msg'=>'El correo electrónico es invalido.']));
		$this->runValidation(new UniqueValidator($this,['field'=>'documento','msg'=>'Este documento ya se encuentra registrado.']));
	}

}