<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\MargenesProd;
use App\Models\Users;

class MargenesProdController extends Controller {

	public function onConstruct(){
		$this->view->setLayout('index');
	}

	public function indexAction(){
		$datos = MargenesProd::listarMargenes2();
		$this->view->datos = $datos;

		$this->view->render('margenes_prod/index2');
	}

	public function indexAPIAction(){
		$datos = MargenesProd::listarMargenes();
		echo $datos;
	}

	public function nuevoAction(){
		$datos = new MargenesProd();
		if($this->request->isPost()){

			$datos->assign($this->request->get());

	        $datos->validator();

	        if($datos->validationPassed())
	        {
		        $datos->assign($this->request->get(),MargenesProd::blackList);

	        	if(!$datos->guardar('BUC',$datos->U_CardCode,$datos->U_MargenBaseBuc,$datos->U_MargenTatBuc,1))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Bucaramanga.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}
	        	if(!$datos->guardar('CUC',$datos->U_CardCode,$datos->U_MargenBaseCuc,$datos->U_MargenTatCuc,1))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Cucuta.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}

	        	if(!$datos->guardar('VAL',$datos->U_CardCode,$datos->U_MargenBaseValle,$datos->U_MargenTatValle,1))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Valledupar.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}
	        	
	        	if(!$datos->guardar('DUI',$datos->U_CardCode,$datos->U_MargenBaseDui,$datos->U_MargenTatDui,1))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Duitama.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}

				Session::addMsg('success','Registro guardado correctamente.');
				Router::redirect('margenesProd');
			}else{
				//H::dnd($datos->getErrorMessages());	
			}
		}

		$casas=$datos->listarCasas();
		$casas=json_decode($casas);
		$arr_casas=[];
		foreach($casas as $casas){
			$arr_casas[$casas->CardCode]=$casas->CardCode.' - '.$casas->CardName;
		}

		$this->view->datos = $datos;
		$this->view->casas = $arr_casas;
		$this->view->displayErrors = $datos->getErrorMessages();
		$this->view->postAction = PROOT . 'MargenesProd' . DS . 'nuevo';
		$this->view->render('margenes_prod/crear');
	}

	public function editarAction($id){
		$datos = MargenesProd::buscarId($id);
		if(!$datos) Router::redirect('margenesProd');

		if($this->request->isPost()){

			$datos[0]->assign($this->request->get());
	        $datos[0]->validator();

	        if($datos[0]->validationPassed()){

	        	if(!$datos[0]->actualizar('BUC',$datos[0]->U_CardCode,$datos[0]->U_MargenBaseBuc,$datos[0]->U_MargenTatBuc))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Bucaramanga.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}

	        	if(!$datos[0]->actualizar('CUC',$datos[0]->U_CardCode,$datos[0]->U_MargenBaseCuc,$datos[0]->U_MargenTatCuc))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Cucuta.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}

	        	if(!$datos[0]->actualizar('VAL',$datos[0]->U_CardCode,$datos[0]->U_MargenBaseValle,$datos[0]->U_MargenTatValle))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Valledupar.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}

	        	if(!$datos[0]->actualizar('DUI',$datos[0]->U_CardCode,$datos[0]->U_MargenBaseDui,$datos[0]->U_MargenTatDui))
	        	{
	        		Session::addMsg('danger','Error al guardar en sede Duitama.');
	        		Router::redirect('margenesProd');
	        		return;
	        	}
	        	Session::addMsg('success','Registro guardado correctamente.');
				Router::redirect('margenesProd');
			}else{
				//H::dnd($datos[0]->getErrorMessages());	
			}
		}

		$casas=MargenesProd::listarCasas();
		$casas=json_decode($casas);
		$arr_casas=[];
		foreach($casas as $casas){
			$arr_casas[$casas->CardCode]=$casas->CardCode.' - '.$casas->CardName;
		}

		foreach ($datos as $key=> $value) {
			switch ($value->Name) {
				case 'BUC':
					$datos[0]->U_MargenBaseBuc=$value->U_MargenBase;
					$datos[0]->U_MargenTatBuc=$value->U_MargenTat;
					break;
				case 'CUC':
					$datos[0]->U_MargenBaseCuc=$value->U_MargenBase;
					$datos[0]->U_MargenTatCuc=$value->U_MargenTat;
				break;
				case 'VAL':
					$datos[0]->U_MargenBaseValle=$value->U_MargenBase;
					$datos[0]->U_MargenTatValle=$value->U_MargenTat;
				break;
				case 'DUI':
					$datos[0]->U_MargenBaseDui=$value->U_MargenBase;
					$datos[0]->U_MargenTatDui=$value->U_MargenTat;
				break;
				default:
					$datos[0]->U_MargenBaseBuc=$value->U_MargenBase;
					$datos[0]->U_MargenTatBuc=$value->U_MargenTat;
					break;
			}
		}

		$datos[0]->id=$datos[0]->U_CardCode;
		$this->view->datos = $datos[0];
		$this->view->casas = $arr_casas;
		$this->view->displayErrors = $datos[0]->getErrorMessages();

		$this->view->postAction = PROOT . 'margenesProd' . DS . 'editar' . DS . $id;
		$this->view->render('margenes_prod/editar');
	}

	public function activarAction($id){
		$datos = MargenesProd::buscarId($id);
		if($datos){
			if(!$datos[0]->activar(1,$id))
        	{
        		Session::addMsg('danger','Error al activar casa.');
        		Router::redirect('margenesProd');
        		return;
        	}
			Session::addMsg('success','Registro activado correctamente.');
		}
		Router::redirect('margenesProd');
	}

	public function inactivarAction($id){
		$datos = MargenesProd::buscarId($id);
		if($datos){
			if(!$datos[0]->activar(0,$id))
        	{
        		Session::addMsg('danger','Error al inactivar casa.');
        		Router::redirect('margenesProd');
        		return;
        	}
			Session::addMsg('success','Registro inactivado correctamente.');
		}
		Router::redirect('margenesProd');
	}
}