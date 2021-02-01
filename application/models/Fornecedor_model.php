<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor_model extends CI_Model
{

	public function buscar_codigo($codigo)
	{
		$this->db->select('*');
		$this->db->from('fornecedores');
		$this->db->where('codigo', $codigo);

		return $this->db->get()->row_array();
	}

	public function buscar_nome($nome)
	{
		$this->db->select('*');
		$this->db->from('fornecedores');
		$this->db->like('nome', $nome);

		return $this->db->get()->result_array();
	}

}
