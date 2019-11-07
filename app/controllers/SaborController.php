<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Sabor;

class SaborController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Sabor::find(['order'=>'sabor']);
      $this->view->datos = $datos;
      $this->view->render('sabor/index');
   }

   public function nuevoAction(){
      $datos = new Sabor();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Sabor::blackList);
         if($datos->save()){
            Router::redirect('sabor');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'sabor' . DS . 'nuevo';
      $this->view->render('sabor/crear');
   }

   public function editarAction($id){
      $datos = Sabor::findById((int)$id);
      if(!$datos) Router::redirect('sabor');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('sabor');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'sabor' . DS . 'editar' . DS . $datos->id;
      $this->view->render('sabor/editar');
   }

   public function eliminarAction($id){
      $datos = Sabor::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('sabor');
   }

}