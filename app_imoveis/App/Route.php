<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		/* Rotas Index */

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);
		/* Rotas da aplicação */	
		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'appController',
			'action' => 'cadastro'
		);

		$routes['cadastra'] = array(
			'route' => '/cadastra',
			'controller' => 'appController',
			'action' => 'cadastra'
		);

		$routes['atualizar'] = array(
			'route' => '/atualizar',
			'controller' => 'appController',
			'action' => 'atualizarImovel'
		);

		$routes['listar'] = array(
			'route' => '/listar',
			'controller' => 'appController',
			'action' => 'listarImovel'
		);

		
		$routes['removerImovel'] = array(
			'route' => '/removerImovel',
			'controller' => 'appController',
			'action' => 'removerImovel'
		);

		$routes['atualizarImovel'] = array(
			'route' => '/atualizarImovel',
			'controller' => 'appController',
			'action' => 'atualizarImovel'
		);

		$routes['imovelEdit'] = array(
			'route' => '/editar',
			'controller' => 'appController',
			'action' => 'imovelEdit'
		);

		$routes['detalheImovel'] = array(
			'route' => '/detalheImovel',
			'controller' => 'appController',
			'action' => 'detalheImovel'
		);



		$this->setRoutes($routes);
	}

}

?>