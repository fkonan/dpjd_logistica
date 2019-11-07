<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Users;
use App\Models\Ofertas;
use Core\Session;
use Core\H;

class HomeController extends Controller {

	public function onConstruct(){
		$this->view->setLayout('default');
		$this->currentUser=Users::currentUser();
	}

	public function indexAction() {
		$this->view->render('home/index');
	}
}
