<?php $this->setSiteTitle('Editar adicional'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Editar tipo de adicional: <?=$this->datos->adicional?>
  </div>
  <div class="card-body">
    <?php $this->partial('adicional','form');?>
  </div>
</div>
<?php $this->end(); ?>