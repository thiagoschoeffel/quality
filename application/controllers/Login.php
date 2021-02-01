<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('usuario_logado')) {
			redirect('');
			return;
		}

		$this->load->view('template/header_html');
		$this->load->view('template/login');
		$this->load->view('template/footer_html');
	}

	public function entrar()
	{
		if (!$this->input->is_ajax_request()) {
			if (!$this->session->userdata('usuario_logado')) {
				redirect('login');
				return;
			}

			redirect('');
			return;
		}

		$response = array();

		$campos = array(
			'nome_usuario' => $this->input->post('nome_usuario'),
			'senha' => $this->input->post('senha')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('nome_usuario', 'nome do usuário', 'required');
		$this->form_validation->set_rules('senha', 'senha', 'required');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$this->load->model('usuario_model', 'model_usuario');

		$buscar_usuario = $this->model_usuario->buscar_usuario($campos['nome_usuario']);

		if (!$buscar_usuario) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Usuário e/ou senha inválido(s).</p>'
			);

			echo json_encode($response);
			return;
		}

		$verifcar_senha = password_verify($campos['senha'], $buscar_usuario['senha']);

		if (!$verifcar_senha) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Usuário e/ou senha inválido(s).</p>'
			);

			echo json_encode($response);
			return;
		}

		unset($buscar_usuario['senha']);

		$usuario_logado = array(
			'codigo' => $buscar_usuario['codigo'],
			'nome' => $buscar_usuario['nome'],
			'email' => $buscar_usuario['email'],
			'nome_usuario' => $buscar_usuario['nome_usuario'],
			'admin' => $buscar_usuario['administrador'],
		);

		$this->session->set_userdata('usuario_logado', $usuario_logado);

		$response['redirecionamento'] = base_url();

		echo json_encode($response);
		return;
	}

	public function sair()
	{
		if (!$this->session->userdata('usuario_logado')) {
			redirect('login');
			return;
		}

		$this->session->unset_userdata('usuario_logado');

		redirect('login');
		return;
	}

}
