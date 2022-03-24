<?php

namespace App\Models;

use MF\Model\Model;

class Endereco extends Model
{

	private $id;
	private $cep;
	private $rua;
	private $complemento;
	private $bairro;
	private $cidade;
	private $estado;
	private $lastId;


	public function __get($atributo)
	{
		return $this->$atributo;
	}

	public function __set($atributo, $valor)
	{
		$this->$atributo = $valor;
		return $this;
	}

	public function inserir()
	{ //Insere novos registros na tabela

		$query = 'INSERT INTO endereco(cep, rua, bairro, cidade, estado) 
        VALUES (:cep, :rua, :bairro, :cidade, :estado)';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':cep', $this->__get('cep'));
		$stmt->bindValue(':rua', $this->__get('rua'));
		$stmt->bindValue(':bairro', $this->__get('bairro'));
		$stmt->bindValue(':cidade', $this->__get('cidade'));
		$stmt->bindValue(':estado', $this->__get('estado'));
		$stmt->execute();

		$lastId = $this->db->lastInsertId();

		$this->__set('lastId', $lastId);
	}

	public function recuperarUltimo()
	{ //Recuperar o ultimo ID gerado para que possa associar ao Socio.
		try {
			$stmt = $this->db->prepare("SELECT last_insert_id() as last FROM endereco");
			$stmt->execute();
			$lastId = $stmt->fetchObject();

			$this->__set('lastId', $lastId);
		} catch (\PDOException $ex) {
			die($ex->getMessage());
		}
	}

	public function verificaCep()
	{ //Verificar se um deretminado CEP já existe no banco, se existir ele tras o id
		try {

			$query = 'SELECT * FROM endereco WHERE cep = :cep';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':cep', $this->__get('cep'));
			$stmt->execute();

			if ($stmt->rowCount()) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (\PDOException $ex) {
			die($ex->getMessage());
		}
	}

	public function recuperaUm()
	{ //Verificar se um deretminado CEP já existe no banco, se existir ele tras o id
		try {

			$query = 'SELECT id FROM endereco WHERE cep = :cep LIMIT 1';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':cep', $this->__get('cep'));
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_NUM);

			$this->__set('lastId', $row[0]);

		} catch (\PDOException $ex) {
			die($ex->getMessage());
		}
	}

	public function recuperar()
	{ //Recupera tudo da tabela

	}



	public function atualizar()
	{ //Atualiza os registros da tabela

	}

	public function deletar()
	{ //Deleta um registro da tabela CUIDADO

	}
}
