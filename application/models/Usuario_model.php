<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

	private static $tabela = 'usuarios';

	public function buscar_usuario($nome_usuario)
	{
		$this->db->select("codigo, nome, email, nome_usuario, senha, administrador");
		$this->db->from(static::$tabela);
		$this->db->where("nome_usuario", $nome_usuario);

		return $this->db->get()->row_array();
	}

}
