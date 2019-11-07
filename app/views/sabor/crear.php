<?php $this->setSiteTitle('Nueva registro'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Nueva registro
  </div>
  <div class="card-body">
    <?php $this->partial('sabor','form');?>
  </div>
</div>
<?php $this->end(); ?>