<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\LogisticaPdaAuxiliares;
use App\Models\Users;

class LogisticaPdaAuxiliaresController extends Controller {

	public function onConstruct(){
		$this->view->setLayout('default');
		$this->currentUser=Users::currentUser();
	}

	public function indexAction(){
		$datos = LogisticaPdaAuxiliares::listarAuxiliares();
		$this->view->datos = $datos;
		$this->view->render('logistica_pda_auxiliares/index');
	}

	public function indexAPIAction(){
		$datos = LogisticaPdaAuxiliares::listarAuxiliares();
		echo $datos;
	}

	public function nuevoAction(){
		$datos = new LogisticaPdaAuxiliares();
		if($this->request->isPost()){

			$datos->assign($this->request->get());
			$datos->Estado=1;

			if(!empty($datos->CC)){
				$CC=explode (";", $this->request->get('CC'));
				$usuario=Users::findById('Identificacion',$CC[0]);
				$datos->CC=$CC[0];
				$datos->Nombres=$usuario->Nombre;
				$datos->Apellidos=$usuario->Apellido;
			}

	        $datos->validator();

	        if($datos->validationPassed())
	        {
				$datos->Estado=1;
				$CC=explode (";", $this->request->get('CC'));
				$usuario=Users::findById('Identificacion',$CC[0]);
				$datos->CC=$CC[0];
				$datos->Nombres=$usuario->Nombre;
				$datos->Apellidos=$usuario->Apellido;

				if($datos->save()){
					Session::addMsg('success','Auxiliar vinculado correctamente.');
					Router::redirect('logisticaPdaAuxiliares');
				}
			}else{
				$datos->CC=$this->request->get('CC');
				$datos->Agencia=$this->request->get('Agencia');
			}
		}

		$usuarios=Users::listarUsuarios();
		$usuarios=json_decode($usuarios);
		$arr_usuarios=[];
		foreach($usuarios as $usuarios){
			$arr_usuarios[$usuarios->Identificacion.';'.$usuarios->Sucursal.';'.$usuarios->Prefijo]=$usuarios->Nombre.' '.$usuarios->Apellido;
		}

		$this->view->datos = $datos;
		$this->view->usuarios = $arr_usuarios;
		$this->view->displayErrors = $datos->getErrorMessages();
		$this->view->postAction = PROOT . 'logisticaPdaAuxiliares' . DS . 'nuevo';
		$this->view->render('logistica_pda_auxiliares/crear');
	}

	public function editarAction($id){
		$datos = LogisticaPdaAuxiliares::findById('CC',(int)$id);
		if(!$datos) Router::redirect('logisticaPdaAuxiliares');

		if($this->request->isPost()){

			$datos->assign($this->request->get());
			$datos->id=$this->request->get('CC');

			if($datos->save('CC')){
				Router::redirect('logisticaPdaAuxiliares');
			}
		}
		
		$this->view->datos = $datos;
		$this->view->displayErrors = $datos->getErrorMessages();
		$this->view->postAction = PROOT . 'logisticaPdaAuxiliares' . DS . 'editar' . DS . $id;
		$this->view->render('logistica_pda_auxiliares/editar');
	}

	public function inactivarAction($id){
		$datos = LogisticaPdaAuxiliares::findById('CC',(int)$id);
		if($datos){
			$datos->Estado=0;
			$datos->id=$id;
			if($datos->save('CC')){
				Session::addMsg('success','Registro inactivado correctamente.');
			}
		}
		Router::redirect('logisticaPdaAuxiliares');
	}

	public function ActivarAction($id){
		$datos = LogisticaPdaAuxiliares::findById('CC',(int)$id);
		if($datos){
			$datos->Estado=1;
			$datos->id=$id;
			if($datos->save('CC')){
				Session::addMsg('success','Registro activado correctamente.');
			}
		}
		Router::redirect('logisticaPdaAuxiliares');
	}

	public function eliminarAction($id){
		$datos = LogisticaPdaAuxiliares::findById('CC',(int)$id);
		if($datos){
			$datos->id=(int)$id;
			if($datos->delete('CC'))
				Session::addMsg('success','Registro inactivado correctamente.');
		}
		Router::redirect('logisticaPdaAuxiliares');
	}
}