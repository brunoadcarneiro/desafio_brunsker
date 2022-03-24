<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{


	public function cadastro()
	{
		
		$this->render('cadastro', 'layout');
	}

	public function cadastra()
	{

		$endereco = Container::getModel('Endereco');

		$endereco->__set('cep', $_POST['cep']);
		$endereco->__set('rua', $_POST['rua']);
		$endereco->__set('bairro', $_POST['bairro']);
		$endereco->__set('cidade', $_POST['cidade']);
		$endereco->__set('estado', $_POST['estado']);

		$endereco->verificaCep();

		if ($endereco->verificaCep() == TRUE) {
			$endereco->recuperaUm();
		} else {
			$endereco->inserir();
		}



		$imovel = Container::getModel('Imovel');

		$imovel->__set('titulo', $_POST['titulo']);
		$imovel->__set('descricao', $_POST['descricao']);
		$imovel->__set('valor', $_POST['valor']);
		$imovel->__set('tipo_contrato', $_POST['tipo_contrato']);
		$imovel->__set('tipo_imovel', $_POST['tipo_imovel']);
		$imovel->__set('endereco_id', $endereco->__get('lastId'));
		$imovel->__set('complemento_end', $_POST['complemento_end']);
		$imovel->__set('numero_end', $_POST['numero_end']);



		$arquivo = $_FILES['imagem']['name'];

		//Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = 'assets/img/';

		//Tamanho máximo do arquivo em Bytes
		$_UP['tamanho'] = 1024 * 1024 * 100; //5mb

		//Array com a extensões permitidas
		$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');

		//Renomeiar
		$_UP['renomeia'] = true;

		//Verifica se houve algum erro com o upload. Sem sim, exibe a mensagem do erro
		if ($_FILES['imagem']['error'] != 0) {
			die("Não foi possivel fazer o upload, erro: <br />" . $_UP['erros'][$_FILES['imagem']['error']]);
			exit; //Para a execução do script
		}

		if ($_UP['tamanho'] < $_FILES['imagem']['size']) {
			header('Location: /cadastro?erro=tamanho');
		}

		//O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto
		else {
			//Primeiro verifica se deve trocar o nome do arquivo
			if ($_UP['renomeia'] == true) {
				//Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
				$nome_final = time() . '.jpg';
				$destino = $_UP['pasta'] . $nome_final;
			} else {
				//mantem o nome original do arquivo
				$nome_final = $_FILES['imagem']['name'];
				$destino = $_UP['pasta'] . $nome_final;
			}
			//Verificar se é possivel mover o arquivo para a pasta escolhida
			if (move_uploaded_file($_FILES['imagem']['tmp_name'], $_UP['pasta'] . $nome_final)) {

				$imovel->__set('imagem', $destino);
			} else {
				header('Location: /cadastro?erro=mover');
			}
		}

		$imovel->inserir();
		header('Location: /cadastro?cad=ok');
	}

	public function atualizarImovel()
	{

		$imovel = Container::getModel('Imovel');	//Model
		$imovel->__set('id', $_GET['id']);
		$imovelReg = $imovel->recuperarUm($imovel->__get('id'));

		/* echo '<pre>';
		echo $imovel->__get('id');
		var_dump($imovelReg);
		echo '</pre>';
 */
		$this->view->imovelReg = $imovelReg;
		$this->render('editar', 'layout');
	}

	public function listarImovel()
	{

		$imovel = Container::getModel('Imovel');

		if (isset($_GET['pesqImovel']) && $_GET['pesqImovel'] != '') {
			$imovel->__set('search', $_GET['pesqImovel']);
			$imoveis = $imovel->getAllLike();
		} else {
			$imoveis = $imovel->recuperar();
		}
		/* echo '<pre>';
		var_dump($imoveis);
		echo '</pre>'; */

		$this->view->imoveis = $imoveis;
		$this->render('imovel', 'layout');
	}

	public function detalheImovel()
	{

		$imovel = Container::getModel('Imovel');
		$imovel->__set('id', $_GET['id']);

		$this->view->imovelDetalhe = $imovel->recuperarUm($imovel->__get('id'));
		$this->render('info', 'layout');
	}


	public function removerImovel()
	{

		$imovel = Container::getModel('Imovel');
		$imovel->__set('id', $_GET['id']);

		$imovel->remover();

		header('Location: /listar');
	}

	public function imovelEdit()
	{

		$endereco = Container::getModel('Endereco'); //Model

		//Definir o valor das variaveis no model de Endereco
		$endereco->__set('cep', $_POST['cep']);
		$endereco->__set('rua', $_POST['rua']);
		$endereco->__set('bairro', $_POST['bairro']);
		$endereco->__set('cidade', $_POST['cidade']);
		$endereco->__set('estado', $_POST['estado']);
		$endereco->verificaCep();

		if ($endereco->verificaCep() == TRUE) {
			$endereco->recuperaUm();
			/* echo '<pre>';
			echo $endereco->__get('lastId');
			echo '</pre>'; */
		} else {
			$endereco->inserir();
			/* echo '<pre>';
			echo $endereco->__get('lastId');
			echo '</pre>'; */
		}

		$imovel = Container::getModel('Imovel');

		$imovel->__set('id', $_POST['id']);
		$imovel->__set('titulo', $_POST['titulo']);
		$imovel->__set('descricao', $_POST['descricao']);
		$imovel->__set('valor', $_POST['valor']);
		$imovel->__set('tipo_contrato', $_POST['tipo_contrato']);
		$imovel->__set('tipo_imovel', $_POST['tipo_imovel']);
		$imovel->__set('endereco_id', $endereco->__get('lastId'));
		$imovel->__set('complemento_end', $_POST['complemento_end']);
		$imovel->__set('numero_end', $_POST['numero_end']);

		echo $_POST['id'];

		$imovel->atualizar();

		header('Location: /atualizarImovel?id=' . $_POST['id'] . '&inclusao=1');
	}
}
