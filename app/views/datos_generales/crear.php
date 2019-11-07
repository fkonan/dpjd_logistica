<?php $this->setSiteTitle('Nuevo Ingreso'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Nuevo Ingreso
  </div>
  <div class="card-body pt-1">
    <?php $this->partial('datos_generales','form');?>
  </div>
</div>
<?php $this->end(); ?>