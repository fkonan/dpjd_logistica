<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Discapacidad;

class DiscapacidadController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Discapacidad::find(['order'=>'discapacidad']);
      $this->view->datos = $datos;
      $this->view->render('discapacidad/index');
   }

   public function nuevoAction(){
      $datos = new Discapacidad();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Discapacidad::blackList);
         if($datos->save()){
            Router::redirect('discapacidad');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'discapacidad' . DS . 'nuevo';
      $this->view->render('discapacidad/crear');
   }

   public function editarAction($id){
      $datos = Discapacidad::findById((int)$id);
      if(!$datos) Router::redirect('discapacidad');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('discapacidad');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'discapacidad' . DS . 'editar' . DS . $datos->id;
      $this->view->render('discapacidad/editar');
   }

   public function eliminarAction($id){
      $datos = Discapacidad::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('discapacidad');
   }

}