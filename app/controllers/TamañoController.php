<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Tamaño;

class TamañoController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Tamaño::find(['order'=>'tamaño']);
      $this->view->datos = $datos;
      $this->view->render('tamaño/index');
   }

   public function nuevoAction(){
      $datos = new Tamaño();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Tamaño::blackList);
         if($datos->save()){
            Router::redirect('tamaño');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'tamaño' . DS . 'nuevo';
      $this->view->render('tamaño/crear');
   }

   public function editarAction($id){
      $datos = Tamaño::findById((int)$id);
      if(!$datos) Router::redirect('tamaño');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('tamaño');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'tamaño' . DS . 'editar' . DS . $datos->id;
      $this->view->render('tamaño/editar');
   }

   public function eliminarAction($id){
      $datos = Tamaño::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('tamaño');
   }

}