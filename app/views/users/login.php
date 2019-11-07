<?php
use Core\FH; 
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="container h-100 mb-4 mt-1">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card bg-info">
            <div class="d-flex justify-content-center mb-3">
                <div class="brand_logo_container">
                    <img src="<?=PROOT?>img/candado.png" class="brand_logo" alt="Logo">
                </div>
            </div>
            <h2 class="text-center text-white mt-2">Iniciar sesión</h2>
            <div class="d-flex justify-content-center mt-1">
                <form class="form needs-validation" action="<?=PROOT?>users/login" method="post" novalidate>
                    <?= FH::csrfInput() ?>
                    <?= FH::displayErrors($this->displayErrors)?>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa fa-user"></i></span>
                        </div>
                        <?= FH::inputBlock('text','','username',$this->login->username,['class'=>'form-control','placeholder'=>'Usuario'],[],$this->displayErrors) ?>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa fa-key"></i></span>
                        </div>
                        <?= FH::inputBlock('password','','password',$this->login->password,['class'=>'form-control','placeholder'=>'Contraseña'],[],$this->displayErrors) ?>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                            <label class="custom-control-label text-white font-weight-bold" for="customControlInline">Recordar sesión</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_containerd">
                        <?= FH::submitTag('Iniciar sesión',['class'=>'btn login_btn']) ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
