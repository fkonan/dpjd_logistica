<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\DatosGenerales;
use App\Models\TipoDocumento;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\NivelEducativo;
use App\Models\Ocupacion;
use App\Models\Barrio;
use App\Models\Comuna;
use App\Models\Vereda;
use App\Models\Corregimiento;
use App\Models\GrupoEtnico;
use App\Models\Discapacidad;
use App\Models\Users;
use App\Models\DatosPrograma;
use App\Models\SituacionParticular;
use App\Models\Profesion;
use App\Models\Ingreso;
use App\Models\ServiciosPrograma;

class DatosGeneralesController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
      $this->currentUser=Users::currentUser();
   }

   public function indexAction(){
      $datos = DatosGenerales::find(['order'=>'primer_apelllido,segundo_apellido,nombres']);
      $this->view->datos = $datos;
      $this->view->render('datos_generales/index');
   }

   public function mensajeAction($documento){
      $this->view->documento = $documento;
      $this->view->render('datos_generales/mensaje');
   }

   public function buscarAction($editar=false){
      $datos= new DatosGenerales();
      if($this->request->isPost()){
         $validar=DatosGenerales::find([
            'columns'=>'id,documento,nombres,primer_apellido,segundo_apellido',
            'conditions'=>'documento like ?  and nombres like  ? and primer_apellido like ? ',
            'bind'=>[$this->request->get('documento').'%',$this->request->get('nombres').'%',$this->request->get('primer_apellido').'%']
         ]);
         if($validar){
            $resp=['success'=>true,'datos'=>$validar,'editar'=>$editar];
            $this->jsonResponse($resp);
         }else{
            $resp=['danger'=>true,'error'=>'No se encontraron registros'];
            $this->jsonResponse($resp);
         }
      }else{
         $this->view->datos = $datos;
         $this->view->displayErrors = $datos->getErrorMessages();
         $this->view->postAction = PROOT . 'datosGenerales' . DS . 'buscar'.DS.$editar;
         $this->view->render('datos_generales/buscar');
      }
   }


   public function nuevoAction($id=null){
      $ingreso=new Ingreso();
      if(empty($id)){
         $datos=new DatosGenerales();
      }else{
         $datos=DatosGenerales::findById($id);
      }
      $datos->user_id=$this->currentUser->id;

      if($this->request->isPost()){
         //$this->request->csrfCheck();
         if(empty($id)){
            $datos->assign($this->request->get(),DatosGenerales::blackList);
         }else{
            $datos->assign($this->request->get());
         }
         $datos->user_id=$this->currentUser->id;
         $datos->pais_id=45;
         $datos->depto_codigo=68;
         $fecha_nacimiento=date_create($this->request->get('fecha_nacimiento'));
         $datos->fecha_nacimiento=date_format($fecha_nacimiento,'Y-m-d');
         if(empty($id))
         {
            $dt = new \DateTime("now", new \DateTimeZone("America/Bogota"));
            $now = $dt->format('Y-m-d H:i:s');
            $datos->fecha_registro=$now;
         }
         
         $ingreso->assign($this->request->get(),Ingreso::blackList);

         if($datos->save()){
            $datos_programa=DatosPrograma::find([
               'conditions'=>'general_id= ?  and programa_id= ? ',
               'bind'=>[$datos->id,$this->currentUser->programa_id]
            ]);
            if(!$datos_programa){
               $nuevo=new DatosPrograma();
               $nuevo->general_id=$datos->id;
               $nuevo->programa_id=$this->currentUser->programa_id;
               $dt = new \DateTime("now", new \DateTimeZone("America/Bogota"));
               $now = $dt->format('Y-m-d H:i:s');
               $nuevo->fecha_registro=$now;
               $nuevo->user_id=$this->currentUser->id;
               $nuevo->save();
            }
            $ingreso->assign($this->request->get(),Ingreso::blackList);
            $general_id=$datos->id;
            $ingreso->general_id=$general_id;
            $ingreso->programa_id=$this->currentUser->programa_id;
            $fecha_ingreso=date_create($this->request->get('fecha_ingreso'));
            $ingreso->fecha_ingreso=date_format($fecha_ingreso,'Y-m-d');
            $dt = new \DateTime("now", new \DateTimeZone("America/Bogota"));
            $now = $dt->format('H:i:s');
            $ingreso->hora_ingreso=$now;
            $ingreso->user_id=$this->currentUser->id;
            if(!$ingreso->save())
               $ingreso->addErrorMessage('fecha_ingreso','Error al registrar el ingreso.');
            else{
               Session::addMsg('success','Ingreso guardado exitosamente.');
               Router::redirect('datosGenerales/buscar');
            }
         }else{
            if(!empty($this->request->get('fecha_nacimiento')))
            {
               $año=substr($datos->fecha_nacimiento,0,4);
               $mes=substr($datos->fecha_nacimiento,5,2);
               $dia=substr($datos->fecha_nacimiento,8);
               $fecha_nacimiento=$dia.'/'.$mes.'/'.$año;
               $datos->fecha_nacimiento=$fecha_nacimiento;
            }
         }
      }

#cargar combos de seleccion

      $tipo_doc= TipoDocumento::find(['order'=>'tipo_documento']);
      $arr_tipo_doc=[];
      foreach($tipo_doc as $tipo_doc){
         $arr_tipo_doc[$tipo_doc->id]=$tipo_doc->tipo_documento;
      }

      $pais_nac= Pais::find(['order'=>'pais']);
      $arr_pais_nac=[];
      foreach($pais_nac as $pais_nac){
         $arr_pais_nac[$pais_nac->id]=$pais_nac->pais;
      }

      $depto= Departamento::find(['order'=>'departamento']);
      $arr_depto=[];
      foreach($depto as $depto){
         $arr_depto[$depto->codigo_depto]=$depto->departamento;
      }

      $muni= Municipio::find(['order'=>'municipio']);
      $arr_muni=[];
      foreach($muni as $muni){
         $arr_muni[$muni->codigo_muni]=$muni->municipio;
      }

      $nivel_educativo= NivelEducativo::find(['order'=>'id']);
      $arr_nivel_educativo=[];
      foreach($nivel_educativo as $nivel_educativo){
         $arr_nivel_educativo[$nivel_educativo->id]=$nivel_educativo->nivel_educativo;
      }

      $ocupacion= Ocupacion::find(['order'=>'ocupacion']);
      $arr_ocupacion=[];
      foreach($ocupacion as $ocupacion){
         $arr_ocupacion[$ocupacion->id]=$ocupacion->ocupacion;
      }

      $barrio= Barrio::find(['order'=>'nombre']);
      $arr_barrio=[];
      foreach($barrio as $barrio){
         $arr_barrio[$barrio->codigo]=$barrio->nombre;
      }

      $comuna= Comuna::find(['order'=>'nombre']);
      $arr_comuna=[];
      foreach($comuna as $comuna){
         $arr_comuna[$comuna->codigo]=$comuna->nombre;
      }

      $vereda= Vereda::find(['order'=>'nombre']);
      $arr_vereda=[];
      foreach($vereda as $vereda){
         $arr_vereda[$vereda->codigo]=$vereda->nombre;
      }

      $grupo_etnico= GrupoEtnico::find(['order'=>'id']);
      $arr_grupo_etnico=[];
      foreach($grupo_etnico as $grupo_etnico){
         $arr_grupo_etnico[$grupo_etnico->id]=$grupo_etnico->grupo_etnico;
      }

      $discapacidad= Discapacidad::find(['order'=>'id']);
      $arr_discapacidad=[];
      foreach($discapacidad as $discapacidad){
         $arr_discapacidad[$discapacidad->id]=$discapacidad->discapacidad;
      }

      $situacion= SituacionParticular::find(['order'=>'id']);
      $arr_situacion=[];
      foreach($situacion as $situacion){
         $arr_situacion[$situacion->id]=$situacion->situacion_particular;
      }

      $profesion= Profesion::find(['order'=>'id']);
      $arr_profesion=[];
      foreach($profesion as $profesion){
         $arr_profesion[$profesion->id]=$profesion->profesion;
      }

      $tipo_servicio= ServiciosPrograma::find([
         'columns'=>'tipo_servicio',
         'conditions'=>'programa_id= ? ',
         'bind'=>[$this->currentUser->programa_id],
         'order'=>'tipo_servicio']);
      $arr_tipo_servicio=[];
      foreach($tipo_servicio as $tipo_servicio){
         $arr_tipo_servicio[$tipo_servicio->tipo_servicio]=$tipo_servicio->tipo_servicio;
      }
      $arr_servicios=[];
      if($ingreso->tipo_servicio!=''){
         $servicios=ServiciosPrograma::find([
            'conditions'=>'tipo_servicio= ? and programa_id= ? ',
            'bind'=>[$ingreso->tipo_servicio,$this->currentUser->programa_id]
         ]);
         $arr_servicios=[];

         foreach($servicios as $servicio){
            $arr_servicios[$servicio->id]=$servicio->servicio;
         }
      }
     

#fin carga

      $dt = new \DateTime("now", new \DateTimeZone("America/Bogota"));
      $now = $dt->format('d-m-Y');
      $ingreso->fecha_ingreso=$now;
      $datos->situacion_particular_id=18;
      $datos->afiliacion_id=5;
      $datos->discapacidad_id=10;
      $datos->grupo_etnico_id=6;
      $datos->nivel_educativo_id=13;
      $datos->pais_nac_id=45;
      $datos->depto_nac_codigo='68';
      $datos->muni_nac_codigo='68001';
      $datos->muni_codigo='68001';
      $datos->direccion='No registra';
      $datos->fecha_nacimiento= date('d/m/Y',strtotime($datos->fecha_nacimiento));

      $this->view->datos = $datos;
      $this->view->ingreso = $ingreso;
      $this->view->tipo_doc = $arr_tipo_doc;
      $this->view->pais = $arr_pais_nac;
      $this->view->depto = $arr_depto;
      $this->view->muni = $arr_muni;
      $this->view->nivel_educativo = $arr_nivel_educativo;
      $this->view->ocupacion = $arr_ocupacion;
      $this->view->barrio = $arr_barrio;
      $this->view->comuna = $arr_comuna;
      $this->view->vereda = $arr_vereda;
      $this->view->grupo_etnico = $arr_grupo_etnico;
      $this->view->discapacidad = $arr_discapacidad;
      $this->view->situacion = $arr_situacion;
      $this->view->tipo_servicio = $arr_tipo_servicio;
      $this->view->servicios = $arr_servicios;
      $this->view->profesion = $arr_profesion;
      $this->view->displayErrors = $datos->getErrorMessages();
      if(empty($id)){
         $this->view->postAction = PROOT . 'datosGenerales' . DS . 'nuevo';
      }else{
         $this->view->postAction = PROOT . 'datosGenerales' . DS . 'nuevo'.DS.$id;
      }
      $this->view->render('datos_generales/crear');
   }

   public function editarAction($id){
      $datos = DatosGenerales::findById((int)$id);
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         $fecha_nacimiento=date_create($this->request->get('fecha_nacimiento'));
         $datos->fecha_nacimiento=date_format($fecha_nacimiento,'Y-m-d');
         if($datos->save()){
            Session::addMsg('success','Cambios realizados exitosamente.');
            Router::redirect('datosGenerales/buscar/1');
         }
      }

#cargar combos de seleccion

      $tipo_doc= TipoDocumento::find(['order'=>'tipo_documento']);
      $arr_tipo_doc=[];
      foreach($tipo_doc as $tipo_doc){
         $arr_tipo_doc[$tipo_doc->id]=$tipo_doc->tipo_documento;
      }

      $pais_nac= Pais::find(['order'=>'pais']);
      $arr_pais_nac=[];
      foreach($pais_nac as $pais_nac){
         $arr_pais_nac[$pais_nac->id]=$pais_nac->pais;
      }

      $depto= Departamento::find(['order'=>'departamento']);
      $arr_depto=[];
      foreach($depto as $depto){
         $arr_depto[$depto->codigo_depto]=$depto->departamento;
      }

      $muni= Municipio::find(['order'=>'municipio']);
      $arr_muni=[];
      foreach($muni as $muni){
         $arr_muni[$muni->codigo_muni]=$muni->municipio;
      }

      $nivel_educativo= NivelEducativo::find(['order'=>'id']);
      $arr_nivel_educativo=[];
      foreach($nivel_educativo as $nivel_educativo){
         $arr_nivel_educativo[$nivel_educativo->id]=$nivel_educativo->nivel_educativo;
      }

      $ocupacion= Ocupacion::find(['order'=>'ocupacion']);
      $arr_ocupacion=[];
      foreach($ocupacion as $ocupacion){
         $arr_ocupacion[$ocupacion->id]=$ocupacion->ocupacion;
      }

      $barrio= Barrio::find(['order'=>'nombre']);
      $arr_barrio=[];
      foreach($barrio as $barrio){
         $arr_barrio[$barrio->codigo]=$barrio->nombre;
      }

      $comuna= Comuna::find(['order'=>'nombre']);
      $arr_comuna=[];
      foreach($comuna as $comuna){
         $arr_comuna[$comuna->codigo]=$comuna->nombre;
      }

      $vereda= Vereda::find(['order'=>'nombre']);
      $arr_vereda=[];
      foreach($vereda as $vereda){
         $arr_vereda[$vereda->codigo]=$vereda->nombre;
      }

      $grupo_etnico= GrupoEtnico::find(['order'=>'id']);
      $arr_grupo_etnico=[];
      foreach($grupo_etnico as $grupo_etnico){
         $arr_grupo_etnico[$grupo_etnico->id]=$grupo_etnico->grupo_etnico;
      }

      $discapacidad= Discapacidad::find(['order'=>'id']);
      $arr_discapacidad=[];
      foreach($discapacidad as $discapacidad){
         $arr_discapacidad[$discapacidad->id]=$discapacidad->discapacidad;
      }

      $situacion= SituacionParticular::find(['order'=>'id']);
      $arr_situacion=[];
      foreach($situacion as $situacion){
         $arr_situacion[$situacion->id]=$situacion->situacion_particular;
      }

      $profesion= Profesion::find(['order'=>'id']);
      $arr_profesion=[];
      foreach($profesion as $profesion){
         $arr_profesion[$profesion->id]=$profesion->profesion;
      }


#fin carga
      $this->view->datos = $datos;
      $this->view->tipo_doc = $arr_tipo_doc;
      $this->view->pais = $arr_pais_nac;
      $this->view->depto = $arr_depto;
      $this->view->muni = $arr_muni;
      $this->view->nivel_educativo = $arr_nivel_educativo;
      $this->view->ocupacion = $arr_ocupacion;
      $this->view->barrio = $arr_barrio;
      $this->view->comuna = $arr_comuna;
      $this->view->vereda = $arr_vereda;
      $this->view->grupo_etnico = $arr_grupo_etnico;
      $this->view->discapacidad = $arr_discapacidad;
      $this->view->situacion = $arr_situacion;
      $this->view->profesion = $arr_profesion;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'datosGenerales' . DS . 'editar'.DS.$id;
      $this->view->render('datos_generales/editar');
   }

   public function cargarMuniAction($codigo_depto){
      $municipio= Municipio::find([
         'conditions'=>'codigo_depto = ?',
         'bind'=>[$codigo_depto],
         'order'=>'municipio'
      ]);

      $arr_municipio=[];
      foreach($municipio as $municipio){
         $arr_municipio[$municipio->codigo_muni]=$municipio->municipio;
      }
      $resp=['success'=>true,'municipio'=>$arr_municipio];
      $this->jsonResponse($resp);
   }

   public function validarDocumentoAction($documento){
      $datos_generales= DatosGenerales::findFirst([
         'conditions'=>'documento = ?',
         'bind'=>[$documento]
      ]);
      if($datos_generales){
         $resp=['success'=>true];
         $this->jsonResponse($resp);
      }else{
         $resp=['success'=>false];
         $this->jsonResponse($resp);
      }
   }

   public function cargarComunaAction($codigo){
      $barrio=Barrio::findFirst([
         'conditions'=>'codigo= ?',
         'bind'=>[$codigo]
      ]);
      $comuna=Comuna::findFirst([
         'conditions'=>'codigo= ? ',
         'bind'=>[$barrio->codigo_comuna]
      ]);

      $arr_comuna=['codigo'=>$comuna->codigo,'nombre'=>$comuna->nombre];
      $resp=['success'=>true,'comuna'=>$arr_comuna];
      $this->jsonResponse($resp);
   }

   public function cargarCorregimientoAction($codigo){
      $vereda=Vereda::findFirst([
         'conditions'=>'codigo= ?',
         'bind'=>[$codigo]
      ]);
      $corregimiento=Corregimiento::findFirst([
         'conditions'=>'codigo= ? ',
         'bind'=>[$vereda->codigo_corregimiento]
      ]);

      $arr_corregimiento=['codigo'=>$corregimiento->codigo,'nombre'=>$corregimiento->nombre];
      $resp=['success'=>true,'corregimiento'=>$arr_corregimiento];
      $this->jsonResponse($resp);
   }

   public function cargarServiciosAction($tipo_servicio){
      $servicios=ServiciosPrograma::find([
         'conditions'=>'tipo_servicio= ? and programa_id= ? ',
         'bind'=>[$tipo_servicio,$this->currentUser->programa_id]
      ]);
      $arr_servicios=[];

      foreach($servicios as $servicio){
         $arr_servicios[$servicio->id]=$servicio->servicio;
      }

      $resp=['success'=>true,'servicios'=>$arr_servicios];
      $this->jsonResponse($resp);
   }
}