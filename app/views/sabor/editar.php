<?php $this->setSiteTitle('Editar sabor'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar tipo de sabor: <?=$this->datos->sabor?>
  </div>
  <div class="card-body">
    <?php $this->partial('sabor','form');?>
  </div>
</div>
<?php $this->end(); ?>