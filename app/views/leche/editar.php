<?php $this->setSiteTitle('Editar leche'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar tipo de leche: <?=$this->datos->leche?>
  </div>
  <div class="card-body">
    <?php $this->partial('leche','form');?>
  </div>
</div>
<?php $this->end(); ?>