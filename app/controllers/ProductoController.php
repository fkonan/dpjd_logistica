<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Producto;

class ProductoController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Producto::find(['order'=>'producto']);
      $this->view->datos = $datos;
      $this->view->render('producto/index');
   }

   public function nuevoAction(){
      $datos = new Producto();
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get(),Producto::blackList);
         if($datos->save()){
            Router::redirect('producto');
         }
      }
      $this->view->datos = $datos;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'producto' . DS . 'nuevo';
      $this->view->render('producto/crear');
   }

   public function editarAction($id){
      $datos = Producto::findById((int)$id);
      if(!$datos) Router::redirect('producto');
      if($this->request->isPost()){
         $this->request->csrfCheck();
         $datos->assign($this->request->get());
         if($datos->save()){
            Router::redirect('producto');
         }
      }
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->datos = $datos;
      $this->view->postAction = PROOT . 'producto' . DS . 'editar' . DS . $datos->id;
      $this->view->render('producto/editar');
   }

   public function eliminarAction($id){
      $datos = Producto::findById((int)$id);
      if($datos){
         $datos->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('producto');
   }

   public function cargarValorAction($id){
      $datos = Producto::findById((int)$id);
      if($datos)
      {
         $resp=['success'=>true,'datos'=>$datos];
         $this->jsonResponse($resp);
      }
   }

}