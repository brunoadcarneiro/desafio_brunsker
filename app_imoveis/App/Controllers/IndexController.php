<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$imovel = Container::getModel('Imovel');

		if (isset($_GET['pesqEmp']) && $_GET['pesqEmp'] != '') {
			$imovel->__set('search', $_GET['pesqEmp']);
			$imoveis = $imovel->getAllLike();
		} else {
			$imoveis = $imovel->recuperar();
		}

		$this->view->imoveis = $imoveis;
		$this->render('index', 'layout');
	}

}


?>