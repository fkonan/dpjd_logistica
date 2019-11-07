<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Leche;

class LecheController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Leche::find(['order'=>'leche']);
      $this->view->datos = $datos;
      $this->view->render('leche/index');
   }

   public function nuevoAction(){
      $datos = new Leche();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Leche::blackList);
         if($datos->save()){
            Router::redirect('leche');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'leche' . DS . 'nuevo';
      $this->view->render('leche/crear');
   }

   public function editarAction($id){
      $datos = Leche::findById((int)$id);
      if(!$datos) Router::redirect('leche');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('leche');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'leche' . DS . 'editar' . DS . $datos->id;
      $this->view->render('leche/editar');
   }

   public function eliminarAction($id){
      $datos = Leche::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('leche');
   }

}