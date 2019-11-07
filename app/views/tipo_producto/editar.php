<?php $this->setSiteTitle('Editar tipo de producto'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar tipo de tipo de producto: <?=$this->datos->tipo_producto?>
  </div>
  <div class="card-body">
    <?php $this->partial('tipo_producto','form');?>
  </div>
</div>
<?php $this->end(); ?>