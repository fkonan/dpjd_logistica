<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\TipoProducto;

class TipoProductoController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = TipoProducto::find(['order'=>'tipo_producto']);
      $this->view->datos = $datos;
      $this->view->render('tipo_producto/index');
   }

   public function nuevoAction(){
      $datos = new TipoProducto();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),TipoProducto::blackList);
         if($datos->save()){
            Router::redirect('tipoProducto');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'tipoProducto' . DS . 'nuevo';
      $this->view->render('tipo_producto/crear');
   }

   public function editarAction($id){
      $datos = TipoProducto::findById((int)$id);
      if(!$datos) Router::redirect('tipoProducto');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('tipoProducto');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'tipoProducto' . DS . 'editar' . DS . $datos->id;
      $this->view->render('tipo_producto/editar');
   }

   public function eliminarAction($id){
      $datos = TipoProducto::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('tipoProducto');
   }

}