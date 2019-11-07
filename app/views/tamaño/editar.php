<?php $this->setSiteTitle('Editar tamaño'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar tipo de tamaño: <?=$this->datos->tamaño?>
  </div>
  <div class="card-body">
    <?php $this->partial('tamaño','form');?>
  </div>
</div>
<?php $this->end(); ?>