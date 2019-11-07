<?php
use Core\Session;
use App\Models\Users;
?>
<!DOCTYPE html>
<html lang="en">
  <head>                        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle(); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=PROOT?>img/icono_dpjd.ico">

    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap4/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link href="<?=PROOT?>css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=PROOT?>css/select2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=PROOT?>css/fontawesome/css/all.min.css">
    
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css?v=<?=VERSION?>" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/alertMsg.css?v=<?=VERSION?>" media="screen" title="no title" charset="utf-8">
    
    <script src="<?=PROOT?>js/jQuery-3.3.1.min.js"></script>

    <?= $this->content('head'); ?>
  </head>
  <body>

    <?php include 'main_menu.php'?>
    <header class="text-center mb-3">

    </header>

    <h3 class="text-center">
      <?php if (isset(Users::currentUser()->nombre)):?>
        <?='Usuario: '.Users::currentUser()->nombre?>
      <?php endif;?>
    </h3>
    <div class="container pt-1 px-0 main ">
      <?= Session::displayMsg() ?>
      <?= $this->content('body'); ?>
    </div>
    <footer class="text-center footer col-12 col-sm-12">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <p class="float-right">
              Desarrollado e Implementado por el <b>DEPARTAMENTO DE SISTEMAS</b>
            </p>
            <p>
              © 2012 - <?=date('Y');?> Distribuciones Pastor Julio Delgado
            </p>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="<?=PROOT?>js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="<?=PROOT?>js/bootstrap4/bootstrap.min.js"></script>
    <script src="<?=PROOT?>js/gijgo.min.js" type="text/javascript"></script>
    <script src="<?=PROOT?>js/messages/messages.es-es.js" type="text/javascript"></script>
    <script src="<?=PROOT?>js/holder.min.js"></script>
    <script src="<?=PROOT?>js/alertMsg.js?v=<?=VERSION?>"></script>
    <script src="<?=PROOT?>js/select2.js?v=<?=VERSION?>"></script>
    <script src="<?=PROOT?>js/custom.js"></script>
    
    <?= $this->content('footer'); ?>
  </body>
</html>



