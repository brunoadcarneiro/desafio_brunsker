<?php

namespace App\Models;

use MF\Model\Model;

class Imovel extends Model
{

    private $id;
    private $titulo;
    private $descricao;
    private $imagem;
    private $valor;
    private $tipo_contrato;
    private $tipo_imovel;
    private $status_imovel;
    private $endereco_id;
    private $numero_end;
    private $complemento_end;
    private $search;

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
    {
        try {

            $query = 'INSERT INTO imovel(titulo, descricao, imagem, valor, tipo_contrato, tipo_imovel, endereco_id, numero_end, complemento_end) 
            VALUES (:titulo, :descricao, :imagem, :valor, :tipo_contrato, :tipo_imovel, :endereco_id, :numero_end, :complemento_end)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':imagem', $this->__get('imagem'));
            $stmt->bindValue(':valor', $this->__get('valor'));
            $stmt->bindValue(':tipo_contrato', $this->__get('tipo_contrato'));
            $stmt->bindValue(':tipo_imovel', $this->__get('tipo_imovel'));
            $stmt->bindValue(':endereco_id', $this->__get('endereco_id'));
            $stmt->bindValue(':numero_end', $this->__get('numero_end'));
            $stmt->bindValue(':complemento_end', $this->__get('complemento_end'));
            $stmt->execute();
        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function recuperar()
    {

        try {

            $query = 'SELECT 
                    i.id as id_imovel, i.titulo, i.descricao, i.imagem, i.valor, i.tipo_contrato, i.tipo_imovel, i.endereco_id, i.numero_end, i.complemento_end, e.id, e.cep, e.rua, e.bairro, e.cidade, e.estado
                FROM 
                    imovel as i
                LEFT JOIN endereco as e on (i.endereco_id = e.id)
                ORDER BY i.id ASC
        ';
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function getAllLike()
    {

        try {

            $query = 'SELECT 
                        i.id as id_imovel, i.titulo, i.descricao, i.imagem, i.valor, i.tipo_contrato, i.tipo_imovel, i.endereco_id, i.numero_end, i.complemento_end, e.id, e.cep, e.rua, e.bairro, e.cidade, e.estado
                    FROM 
                        imovel as i
                    LEFT JOIN endereco as e on (i.endereco_id = e.id)
                    ORDER BY i.id ASC
                    ';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':search', '%' . $this->__get('search') . '%');
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function recuperarUm($id)
    {

        try {

            $query = 'SELECT 
                    i.id as id_imovel, i.titulo, i.descricao, i.imagem, i.valor, i.tipo_contrato, i.tipo_imovel, i.endereco_id, i.numero_end, i.complemento_end, e.id, e.cep, e.rua, e.bairro, e.cidade, e.estado
                FROM 
                     imovel as i
                LEFT JOIN endereco as e on (i.endereco_id = e.id)
                WHERE i.id = :id
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function atualizar()
    {
        try {

            $query = 'UPDATE imovel
                        SET titulo = :titulo, descricao = :descricao, valor = :valor, tipo_contrato = :tipo_contrato, tipo_imovel = :tipo_imovel, endereco_id = :endereco_id, numero_end = :numero_end, complemento_end = :complemento_end
                        WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':valor', $this->__get('valor'));
            $stmt->bindValue(':tipo_contrato', $this->__get('tipo_contrato'));
            $stmt->bindValue(':tipo_imovel', $this->__get('tipo_imovel'));
            $stmt->bindValue(':endereco_id', $this->__get('endereco_id'));
            $stmt->bindValue(':numero_end', $this->__get('numero_end'));
            $stmt->bindValue(':complemento_end', $this->__get('complemento_end'));
            $stmt->execute();


        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function remover()
    {

        try {

            $query = "DELETE FROM imovel WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }
}
