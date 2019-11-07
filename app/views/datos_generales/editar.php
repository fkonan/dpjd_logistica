<?php $this->setSiteTitle('Editar beneficiario'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar beneficiario
  </div>
  <div class="card-body">
    <?php $this->partial('datos_generales','editar');?>
  </div>
</div>
<?php $this->end(); ?>