<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (!$this->session->userdata('usuario_logado')) {
			redirect(base_url('login'));
		}

		$this->load->view('template/header_html');
		$this->load->view('template/header');
		$this->load->view('template/dashboard');
		$this->load->view('template/footer');
		$this->load->view('template/footer_html');
	}

	public function laudo($inspecao_codigo)
	{
		if (empty($inspecao_codigo)) {
			echo "<p>Nenhuma Inspeção Informada.</p>";
			die();
		}

		$this->load->model('inspecao_model', 'model_inspecao');

		$inspecao = $this->model_inspecao->buscar_codigo($inspecao_codigo);

		if (!$inspecao) {
			echo "<p>Nenhuma Inspeção Encontrada.</p>";
			die();
		}

		/*
		 * Classificação Espessuras e Larguras
		 */
		$inspecao_parametros_dimensionais = $this->model_inspecao->buscar_parametros_nao_visuais_inspecionados($inspecao['codigo']);
		$leituras_parametros = array('espessura' => array(), 'largura' => array());

		if (count($inspecao_parametros_dimensionais) > 0) {
			for ($i = 0; $i < count($inspecao_parametros_dimensionais); $i++) {
				if ($inspecao_parametros_dimensionais[$i]['descricao'] === 'ESPESSURA') {
					$leituras_parametros['espessura'] = array('medida' => $inspecao['espessura'],
						'leituras' => $this->model_inspecao->buscar_leituras_nao_visuais_parametro($inspecao['codigo'],
							$inspecao_parametros_dimensionais[$i]['codigo'])
					);
				}

				if ($inspecao_parametros_dimensionais[$i]['descricao'] === 'LARGURA') {
					$leituras_parametros['largura'] = array('medida' => $inspecao['largura'],
						'leituras' => $this->model_inspecao->buscar_leituras_nao_visuais_parametro($inspecao['codigo'],
							$inspecao_parametros_dimensionais[$i]['codigo'])
					);
				}
			}
		}

		$classificacoes_espessura = fazer_calssificacoes($leituras_parametros['espessura']);
		$classificacoes_largura = fazer_calssificacoes($leituras_parametros['largura']);
		/*
		 * Classificação Espessuras e Larguras
		 */

		$dados = array(
			'inspecao' => $inspecao,
			'parametros' => $this->model_inspecao->buscar_resumo_dados_parametros_nao_visuais_tolerancias(),
			'leituras' => array(
				'nao_visuais' => $this->model_inspecao->buscar_resumo_leituras_nao_visuais($inspecao['codigo']),
				'visuais' => $this->model_inspecao->buscar_resumo_leituras_visuais($inspecao['codigo'])
			),
			'leituras_resumo' => $this->model_inspecao->buscar_leituras_nao_visuais($inspecao['codigo']),
			'classificacao' => array(
				'espessura' => $classificacoes_espessura,
				'largura' => $classificacoes_largura
			),
			'imagens' => $this->model_inspecao->buscar_imagens($inspecao['codigo']),
			'external' => true
		);

		$this->load->view('template/header_html');
		$this->load->view('modelos/resumo', $dados);
		$this->load->view('template/footer_html');
	}

}
