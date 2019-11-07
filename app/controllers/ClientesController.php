<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Clientes;

class ClientesController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Clientes::find(['order'=>'nombre']);
      $this->view->datos = $datos;
      $this->view->render('clientes/index');
   }

   public function nuevoAction(){
      $datos = new Clientes();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Clientes::blackList);
         if($datos->save()){
            Router::redirect('clientes');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'clientes' . DS . 'nuevo';
      $this->view->render('clientes/crear');
   }

   public function editarAction($id){
      $datos = Clientes::findById((int)$id);
      if(!$datos) Router::redirect('clientes');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('clientes');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'clientes' . DS . 'editar' . DS . $datos->id;
      $this->view->render('clientes/editar');
   }

   public function eliminarAction($id){
      $datos = Clientes::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('clientes');
   }

}