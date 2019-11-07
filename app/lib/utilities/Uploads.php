<?php
  namespace App\Lib\Utilities;

  use Core\H;

  class Uploads {

    private $_errors = [], $_files=[], $_maxAllowedSize = 5242880;
    private $_allowedImageTypes = [IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG];

    public function __construct($files){
      $this->_files = self::restructureFiles($files);
    }

    public function runValidation(){
      $this->validateSize();
      $this->validateImageType();
    }

    public function validates(){
      return (empty($this->_errors))? true : $this->_errors;
    }

    public function upload($bucket,$name,$tmp){
      if (!file_exists($bucket)) {
          mkdir($bucket);
        }
      $resp = move_uploaded_file($tmp,ROOT.DS.$bucket.$name);
    }

    public function getFiles(){
      return $this->_files;
    }

    protected function validateImageType(){
      foreach($this->_files as $file){
        // checking file type
        if(!in_array(exif_imagetype($file['tmp_name']),$this->_allowedImageTypes)){
          $name = $file['name'];
          $msg = $name . " tipo de archivo no soportado. Por favor use jpeg, gif, o png.";
          $this->addErrorMessage($name,$msg);
        }
      }
    }

    protected function validateSize(){
      foreach($this->_files as $file){
        $name = $file['name'];
        if($file['size'] > $this->_maxAllowedSize){
          $msg = $name . " el tamaño maximo del arhicvo es 5mb.";
          $this->addErrorMessage($name,$msg);
        }
      }
    }

    protected function addErrorMessage($name,$message){
      if(array_key_exists($name,$this->_errors)){
        $this->_errors[$name] .= $this->_errors[$name] . " " . $message;
      } else {
        $this->_errors[$name] = $message;
      }
    }

    public static function restructureFiles($files){
      $structured = [];
      foreach($files['tmp_name'] as $key => $val){
        $structured[] = [
          'tmp_name'=>$files['tmp_name'][$key],'name'=>$files['name'][$key],
          'size'=>$files['size'][$key],'error'=>$files['error'][$key],'type'=>$files['type'][$key]
        ];
      }
      return $structured;
    }
  }