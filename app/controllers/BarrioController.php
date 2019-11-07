<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Barrio;

class BarrioController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Barrio::find(['order'=>'barrio']);
      $this->view->datos = $datos;
      $this->view->datos2 = 'xxx';
      $this->view->render('barrio/index');
   }

   public function nuevoAction(){
      $datos = new Barrio();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Barrio::blackList);
         if($datos->save()){
            Router::redirect('barrio');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'barrio' . DS . 'nuevo';
      $this->view->render('barrio/crear');
   }

   public function editarAction($id){
      $datos = Barrio::findById((int)$id);
      if(!$datos) Router::redirect('barrio');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('barrio');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'barrio' . DS . 'editar' . DS . $datos->id;
      $this->view->render('barrio/editar');
   }

   public function eliminarAction($id){
      $datos = Barrio::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('barrio');
   }

}