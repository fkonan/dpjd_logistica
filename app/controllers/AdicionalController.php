<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Adicional;

class AdicionalController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Adicional::find(['order'=>'adicional']);
      $this->view->datos = $datos;
      $this->view->render('adicional/index');
   }

   public function nuevoAction(){
      $datos = new Adicional();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Adicional::blackList);
         if($datos->save()){
            Router::redirect('adicional');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'adicional' . DS . 'nuevo';
      $this->view->render('adicional/crear');
   }

   public function editarAction($id){
      $datos = Adicional::findById((int)$id);
      if(!$datos) Router::redirect('adicional');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('adicional');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'adicional' . DS . 'editar' . DS . $datos->id;
      $this->view->render('adicional/editar');
   }

   public function eliminarAction($id){
      $datos = Adicional::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('adicional');
   }

}