<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('usuario_logado')) {
			redirect(base_url('login'));
		}

		$this->load->model('fornecedor_model', 'model_fornecedor');
	}

	public function buscar_codigo()
	{
		$codigo = $this->input->post('codigo_fornecedor');

		$response = $this->model_fornecedor->buscar_codigo($codigo);

		if (!$response) {
			$response = array(
				'erro' => array(
					'tipo' => 'primary',
					'texto' => '<b>Informação:</b> Nenhum fornecedor encontrado.'
				)
			);

			echo json_encode($response);
			return;
		}

		echo json_encode($response);
		return;
	}

	public function buscar_nome()
	{
		$nome = $this->input->post('nome_fornecedor');

		$response = $this->model_fornecedor->buscar_nome($nome);

		echo json_encode($response);
		return;
	}

}
