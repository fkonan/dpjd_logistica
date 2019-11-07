<?php $this->setSiteTitle('Editar producto'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar producto: <?=$this->datos->producto?>
  </div>
  <div class="card-body">
    <?php $this->partial('producto','form');?>
  </div>
</div>
<?php $this->end(); ?>