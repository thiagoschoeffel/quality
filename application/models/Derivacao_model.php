<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Derivacao_model extends CI_Model
{

	public function buscar_todos()
	{
		$this->db->select('*');
		$this->db->from('derivacoes');

		return $this->db->get()->result_array();
	}

}
