<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post">
  <?= FH::displayErrors($this->displayErrors) ?>
  <?= FH::csrfInput() ?>
  <div class="row">
    <?= FH::inputBlock('text','Documento','documento',$this->newUser->documento,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
    
    <?= FH::inputBlock('text','Nombres','nombres',$this->newUser->nombres,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
    
    <?= FH::inputBlock('text','Apellidos','apellidos',$this->newUser->apellidos,['class'=>'form-control input-sm'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

    <?= FH::inputBlock('text','Correo','correo',$this->newUser->correo,['class'=>'form-control input-sm'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

  </div>
  <div class="row">
    
    <?= FH::inputBlock('text','Nombre de usuario','user',$this->newUser->user,['class'=>'form-control input-sm'],['class'=>'form-group  col-md-4'],$this->displayErrors) ?>

    <?php if(!empty($this->newUser->id)):?>
      <?= FH::inputBlock('password','Contraseña','password',$this->newUser->password,['class'=>'form-control input-sm','readonly'=>'true'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
      <?= FH::inputBlock('password','Confirmar contraseña','confirm',$this->newUser->confirm,['class'=>'form-control input-sm','readonly'=>'true'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
    <?php else:?>
      <?= FH::inputBlock('password','Contraseña','password',$this->newUser->password,['class'=>'form-control input-sm'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
      <?= FH::inputBlock('password','Confirmar contraseña','confirm',$this->newUser->confirm,['class'=>'form-control input-sm'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
    <?php endif;?>
  </div>
    <div class="d-flex justify-content-end">
      <?= FH::submitTag('Guardar',['class'=>'btn btn-primary']) ?>
    </div>
</form>
