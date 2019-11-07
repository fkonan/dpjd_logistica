<?php
use Core\Session;
use Core\FH;
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle(); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=PROOT?>img/icono.ico">
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap4/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css?v=<?=VERSION?>" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/login.css?v=<?=VERSION?>" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/alertMsg.min.css?v=<?=VERSION?>" media="screen" title="no title" charset="utf-8">

    <?= $this->content('head'); ?>

  </head>
  <body>
    <header class="text-center mb-5">
      <!--<img class="img-fluid" src="<?=PROOT?>img/header.jpg"/>-->
    </header>
    <?= Session::displayMsg() ?>
    <?= $this->content('body'); ?>

   <footer class="text-center footer col-12 col-sm-12">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            © <?=date('Y');?> <a href="<?=PROOT?>">Lacteos Pertuz</a>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="<?=PROOT?>js/jQuery-3.3.1.min.js"></script>
    <script src="<?=PROOT?>js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="<?=PROOT?>js/bootstrap4/bootstrap.min.js"></script>
    <script src="<?=PROOT?>/js/holder.min.js"></script>
    <script src="<?=PROOT?>js/alertMsg.min.js?v=<?=VERSION?>"></script>

  </body>
</html>
