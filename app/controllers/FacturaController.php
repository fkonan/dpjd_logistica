<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Clientes;
use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\TipoProducto;
use App\Models\Leche;
use App\Models\Sabor;
use App\Models\Tamaño;
use App\Models\Adicional;

class FacturaController extends Controller {

   public function onConstruct(){
      $this->view->setLayout('default');
   }

   public function indexAction(){
      $datos = Factura::find([
         'columns'=>'factura.id,factura_no,nombre,telefono,celular,tipo_producto.tipo_producto,cantidad,factura_detalle.valor,fecha,fecha_notificacion',
         'joins'=>
         [
            'joins'=>
            ['factura_detalle','factura.id=factura_detalle.factura_id','factura_detalle','INNER'],
            ['clientes','factura.cliente_id=clientes.id','clientes','INNER'],
            ['tipo_producto','factura_detalle.tipo_producto=tipo_producto.id','tipo_producto','INNER'],
         ],
         'order'=>'fecha_notificacion'
      ]);
      $this->view->datos = $datos;
      $this->view->render('factura/index');
   }

   public function nuevoAction(){
      $datos = new Factura();
      $factura_detalle = new FacturaDetalle();

      if($this->request->isPost()){
         $this->request->csrfCheck();
         
         $datos->assign($this->request->get(),Factura::blackList);
         $datos->fecha=date('Y-m-d',strtotime($datos->fecha));
         //$fecha_noti=date('Y-m-d',strtotime($datos->fecha.' +30 days'));
         //$datos->fecha_notificacion=$fecha_noti;
         $datos->fecha_notificacion=date('Y-m-d',strtotime($datos->fecha_notificacion));
         
         if($datos->save()){

            $factura_detalle->factura_id=$datos->id;
            $factura_detalle->tipo_producto=$this->request->get('tipo_producto');
            $factura_detalle->leche=$this->request->get('leche');
            $factura_detalle->sabor=$this->request->get('sabor');
            $factura_detalle->tamaño=$this->request->get('tamaño');
            $factura_detalle->adicional=$this->request->get('adicional');
            $factura_detalle->cantidad=$this->request->get('cantidad');
            $factura_detalle->valor=$this->request->get('valor');
            $factura_detalle->save();

            Session::addMsg('success','Registro guardado correctamente.');
            Router::redirect('factura');
         }
      }

      $clientes= Clientes::find(['order'=>'nombre']);
      $arr_clientes=[];
      foreach($clientes as $clientes){
         $arr_clientes[$clientes->id]=$clientes->nombre;
      }

      $tipo_producto= TipoProducto::find(['order'=>'tipo_producto']);
      $arr_tipo_producto=[];
      foreach($tipo_producto as $tipo_producto){
         $arr_tipo_producto[$tipo_producto->id]=$tipo_producto->tipo_producto;
      }

      $leche= Leche::find(['order'=>'leche']);
      $arr_leche=[];
      foreach($leche as $leche){
         $arr_leche[$leche->id]=$leche->leche;
      }

      $sabor= Sabor::find(['order'=>'sabor']);
      $arr_sabor=[];
      foreach($sabor as $sabor){
         $arr_sabor[$sabor->id]=$sabor->sabor;
      }

      $tamaño= Tamaño::find(['order'=>'tamaño']);
      $arr_tamaño=[];
      foreach($tamaño as $tamaño){
         $arr_tamaño[$tamaño->id]=$tamaño->tamaño;
      }

      $adicional= Adicional::find(['order'=>'adicional']);
      $arradicional=[];
      foreach($adicional as $adicional){
         $arr_adicional[$adicional->id]=$adicional->adicional;
      }

      $this->view->clientes = $arr_clientes;
      $this->view->tipo_producto = $arr_tipo_producto;
      $this->view->leche = $arr_leche;
      $this->view->sabor = $arr_sabor;
      $this->view->tamaño = $arr_tamaño;
      $this->view->adicional = $arr_adicional;
      $this->view->datos = $datos;
      $this->view->factura_detalle = $factura_detalle;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'factura' . DS . 'nuevo';
      $this->view->render('factura/crear');
   }

   public function editarAction($id){
      $datos = Factura::findById((int)$id);
      $factura_detalle = FacturaDetalle::findFirst([
         'conditions'=>'factura_id = ? ',
         'bind'=>[(int)$id]
      ]);

      if(!$datos) Router::redirect('factura');

      if($this->request->isPost()){
         $this->request->csrfCheck();
         
         $datos->assign($this->request->get());
         $datos->fecha=date('Y-m-d',strtotime($datos->fecha));
         //$fecha_noti=date('Y-m-d',strtotime($datos->fecha.' +30 days'));
         //$datos->fecha_notificacion=$fecha_noti;
         $datos->fecha_notificacion=date('Y-m-d',strtotime($datos->fecha_notificacion));

         if($datos->save()){

            $factura_detalle->tipo_producto=$this->request->get('tipo_producto');
            $factura_detalle->leche=$this->request->get('leche');
            $factura_detalle->sabor=$this->request->get('sabor');
            $factura_detalle->tamaño=$this->request->get('tamaño');
            $factura_detalle->adicional=$this->request->get('adicional');
            $factura_detalle->cantidad=$this->request->get('cantidad');
            $factura_detalle->valor=$this->request->get('valor');
            $factura_detalle->save();

            Router::redirect('factura');
         }
      }
      
      $clientes= Clientes::find(['order'=>'nombre']);
      $arr_clientes=[];
      foreach($clientes as $clientes){
         $arr_clientes[$clientes->id]=$clientes->nombre;
      }

      $tipo_producto= TipoProducto::find(['order'=>'tipo_producto']);
      $arr_tipo_producto=[];
      foreach($tipo_producto as $tipo_producto){
         $arr_tipo_producto[$tipo_producto->id]=$tipo_producto->tipo_producto;
      }

      $leche= Leche::find(['order'=>'leche']);
      $arr_leche=[];
      foreach($leche as $leche){
         $arr_tipo_producto[$leche->id]=$leche->leche;
      }

      $sabor= Sabor::find(['order'=>'sabor']);
      $arr_sabor=[];
      foreach($sabor as $sabor){
         $arr_sabor[$sabor->id]=$sabor->sabor;
      }

      $tamaño= Tamaño::find(['order'=>'tamaño']);
      $arr_tamaño=[];
      foreach($tamaño as $tamaño){
         $arr_tamaño[$tamaño->id]=$tamaño->tamaño;
      }

      $adicional= Adicional::find(['order'=>'adicional']);
      $arradicional=[];
      foreach($adicional as $adicional){
         $arr_adicional[$adicional->id]=$adicional->adicional;
      }

      $this->view->clientes = $arr_clientes;
      $this->view->tipo_producto = $arr_tipo_producto;
      $this->view->leche = $arr_leche;
      $this->view->sabor = $arr_sabor;
      $this->view->tamaño = $arr_tamaño;
      $this->view->adicional = $arr_adicional;
      $this->view->datos = $datos;
      $this->view->factura_detalle = $factura_detalle;
      $this->view->displayErrors = $datos->getErrorMessages();
      $this->view->postAction = PROOT . 'factura' . DS . 'editar' . DS . $datos->id;
      $this->view->render('factura/editar');
   }

   public function eliminarAction($id){
      $datos = Factura::findById((int)$id);
      $factura_detalle = FacturaDetalle::findFirst([
         'conditions'=>'factura_id = ? ',
         'bind'=>[(int)$id]
      ]);

      if($datos){
         $datos->delete();
         $factura_detalle->delete();
         Session::addMsg('success','Registro eliminado correctamente.');
      }
      Router::redirect('factura');
   }

}