<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inspecao extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('usuario_logado')) {
			redirect('login');
			return;
		}

		$this->load->model('inspecao_model', 'model_inspecao');
	}

	public function index()
	{
		$this->load->model('derivacao_model', 'model_derivacao');

		$dados['derivacoes'] = $this->model_derivacao->buscar_todos();

		$this->load->view('template/header_html');
		$this->load->view('template/header');
		$this->load->view('inspecao', $dados);
		$this->load->view('template/footer');
		$this->load->view('template/footer_html');
	}

	public function criar()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_tipo' => $this->input->post('inspecao_tipo'),
			'inspecao_codigo_fornecedor' => $this->input->post('inspecao_codigo_fornecedor'),
			'inspecao_codigo_local' => $this->input->post('inspecao_codigo_local'),
			'inspecao_produto_espessura' => $this->input->post('inspecao_produto_espessura'),
			'inspecao_produto_largura' => $this->input->post('inspecao_produto_largura'),
			'inspecao_produto_comprimento' => $this->input->post('inspecao_produto_comprimento'),
			'inspecao_codigo_derivacao' => $this->input->post('inspecao_codigo_derivacao'),
			'inspecao_nota_fiscal' => $this->input->post('inspecao_nota_fiscal'),
			'inspecao_pedido' => $this->input->post('inspecao_pedido')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_tipo', 'tipo de inspeção', 'required');
		$this->form_validation->set_rules('inspecao_codigo_fornecedor', 'fornecedor',
			'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('inspecao_codigo_local', 'local', 'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('inspecao_produto_espessura', 'epsessura',
			'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('inspecao_produto_largura', 'largura', 'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('inspecao_produto_comprimento', 'comprimento',
			'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('inspecao_codigo_derivacao', 'derivação', 'required|integer');
		$this->form_validation->set_rules('inspecao_nota_fiscal', 'nota fiscal', 'integer|is_natural_no_zero');
		$this->form_validation->set_rules('inspecao_pedido', 'pedido', 'integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$dados = array(
			'tipo' => $campos['inspecao_tipo'],
			'fornecedor' => $campos['inspecao_codigo_fornecedor'],
			'local' => $campos['inspecao_codigo_local'],
			'familia' => 'S0',
			'espessura' => $campos['inspecao_produto_espessura'],
			'largura' => $campos['inspecao_produto_largura'],
			'comprimento' => $campos['inspecao_produto_comprimento'],
			'produto' => 'S0' . str_pad($campos['inspecao_produto_espessura'], 4, '0',
					STR_PAD_LEFT) . str_pad($campos['inspecao_produto_largura'], 4, '0',
					STR_PAD_LEFT) . str_pad($campos['inspecao_produto_comprimento'], 4, '0', STR_PAD_LEFT),
			'derivacao' => $campos['inspecao_codigo_derivacao'],
			'nota_fiscal' => (empty($campos['inspecao_nota_fiscal'])) ? null : $campos['inspecao_nota_fiscal'],
			'pedido' => (empty($campos['inspecao_pedido'])) ? null : $campos['inspecao_pedido'],
			'inspetor' => $this->session->userdata('usuario_logado')['codigo']
		);

		$criar = $this->model_inspecao->criar($dados);

		if (!$criar) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro e a inspeção não foi criada.</p>'
			);

			echo json_encode($response);
			return;
		}

		$response['codigo'] = $criar;

		echo json_encode($response);
		return;
	}

	public function deletar()
	{
	}

	public function carregar()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$carregar = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$carregar) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		$response['inspecao'] = $carregar;
		$response['inspecao_leituras_nao_visuais'] = $this->model_inspecao->buscar_leituras_nao_visuais($campos['inspecao_codigo']);
		$response['inspecao_leituras_visuais'] = $this->model_inspecao->buscar_leituras_visuais($campos['inspecao_codigo']);
		$response['inspecao_imagens'] = $this->model_inspecao->buscar_imagens($campos['inspecao_codigo']);

		echo json_encode($response);
		return;
	}

	public function buscar_resumo()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
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
			'external' => false
		);

		$response['resumo'] = $this->load->view('modelos/resumo', $dados, true);

		echo json_encode($response);
		return;
	}

	public function buscar_parametros_nao_visuais()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$response['parametros_nao_visuais'] = $this->model_inspecao->buscar_parametros_nao_visuais($campos['inspecao_codigo']);

		echo json_encode($response);
		return;
	}

	public function buscar_dados_parametros_nao_visuais()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'parametro_codigo' => $this->input->post('parametro_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('parametro_codigo', 'código do parâmetro',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$response['parametros_nao_visuais_dados'] = $this->model_inspecao->buscar_dados_parametros_nao_visuais($campos['parametro_codigo']);

		echo json_encode($response);
		return;
	}

	public function buscar_dados_parametros_visuais()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$response['parametros_visuais_dados'] = $this->model_inspecao->buscar_dados_parametros_visuais($campos['inspecao_codigo']);

		echo json_encode($response);
		return;
	}

	public function criar_leituras_dimensionais()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$leituras = $this->input->post('leituras_dimensionais');

		if (!$leituras) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p><b>Atenção!</b> Você obrigatóriamente deve informar leituras.</p>'
			);

			echo json_encode($response);
			return;
		}

		for ($i = 0; $i < count($leituras); $i++) {
			$leituras[$i]['valor'] = str_replace(',', '.', $leituras[$i]['valor']);
		}

		$criar = $this->model_inspecao->salvar_leituras_dimensionais($leituras);

		if (!$criar) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro ao gravar as leituras dimensionais, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}

	public function criar_leituras_visuais()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$leituras = $this->input->post('leituras_visuais');

		if (!$leituras) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p><b>Atenção!</b> Você obrigatóriamente deve informar leituras.</p>'
			);

			echo json_encode($response);
			return;
		}

		for ($i = 0; $i < count($leituras); $i++) {
			$leituras[$i]['valor'] = str_replace(',', '.', $leituras[$i]['valor']);
		}

		$criar = $this->model_inspecao->salvar_leituras_visuais($leituras);

		if (!$criar) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro ao gravar as leituras visuais, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}

	public function deletar_leituras()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo'),
			'parametro_codigo' => $this->input->post('parametro_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('parametro_codigo', 'código do parâmetro',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		$deletar_leituras = $this->model_inspecao->deletar_leituras($campos);

		if (!$deletar_leituras) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro ao deletar a leitura da inspeção, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}

	public function mandar_imagens()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		if ($_FILES['imagens']['name'] && count($_FILES['imagens']['name']) > 0) {
			if (!is_dir('./uploads/' . $inspecao['codigo'])) {
				mkdir('./uploads/' . $inspecao['codigo'], 0755);
			}

			$configura_upload['upload_path'] = './uploads/' . $inspecao['codigo'] . '/';
			$configura_upload['allowed_types'] = 'jpg|jpeg';
			$configura_upload['overwrite'] = true;
			$configura_upload['max_size'] = 5000;

			$this->load->library('upload');

			$this->upload->initialize($configura_upload);

			for ($x = 0; $x < count($_FILES['imagens']['name']); $x++) {
				$_FILES['imagem']['name'] = $_FILES['imagens']['name'][$x];
				$_FILES['imagem']['type'] = $_FILES['imagens']['type'][$x];
				$_FILES['imagem']['tmp_name'] = $_FILES['imagens']['tmp_name'][$x];
				$_FILES['imagem']['error'] = $_FILES['imagens']['error'][$x];
				$_FILES['imagem']['size'] = $_FILES['imagens']['size'][$x];

				if ($this->upload->do_upload('imagem')) {
					$dados_imagem = $this->upload->data();

					$configura_imagem['image_library'] = 'gd2';
					$configura_imagem['source_image'] = $dados_imagem['full_path'];
					$configura_imagem['width'] = 1000;
					$configura_imagem['maintain_ratio'] = true;
					$configura_imagem['quality'] = 80;
					$configura_imagem['new_image'] = 'uploads/' . $campos['inspecao_codigo'] . '/' . $campos['inspecao_codigo'] . '_' . rand(0,
							99999) . $dados_imagem['file_ext'];

					$this->load->library('image_lib');

					$this->image_lib->initialize($configura_imagem);

					if (!$this->image_lib->resize()) {
						$response['erro_redimensionamento'][] = '<p><b>Erro!</b> Ocorreu um erro ao redimensionar a imagem: ' . $dados_imagem['file_name'] . '. Verifique a imagem para ver se seque os padrões requeridos pelo sistema. Caso o erro persista, contate o administrador do sistema.</p>';

						unlink('uploads/' . $campos['inspecao_codigo'] . '/' . $dados_imagem['file_name']);
					}

					$dados = array(
						'inspecao' => $campos['inspecao_codigo'],
						'imagem' => $configura_imagem['new_image']
					);

					$salvar_imagem = $this->model_inspecao->salvar_imagem($dados);

					if (!$salvar_imagem) {
						unlink('uploads/' . $campos['inspecao_codigo'] . '/' . $dados_imagem['file_name']);
						unlink('uploads/' . $campos['inspecao_codigo'] . '/' . $configura_imagem['new_image']);

						$response['erro_salvamento'][] = '<p><b>Erro!</b> Ocorreu um erro ao salvar a imagem: ' . $dados_imagem['file_name'] . '. Verifique a imagem para ver se seque os padrões requeridos pelo sistema. Caso o erro persista, contate o administrador do sistema.</p>';
					} else {
						unlink('uploads/' . $campos['inspecao_codigo'] . '/' . $dados_imagem['file_name']);
					}
				} else {
					$response['erro_upload'][] = '<p><b>Erro!</b> Ocorreu um erro ao mandar a imagem: ' . $_FILES['imagem']['name'] . '. Verifique a imagem para ver se seque os padrões requeridos pelo sistema. Caso o erro persista, contate o administrador do sistema.</p>';
				}
			}

			echo json_encode($response);
			return;
		}
	}

	public function deletar_imagens()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo'),
			'imagem_codigo' => $this->input->post('imagem_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');
		$this->form_validation->set_rules('imagem_codigo', 'código da imagem', 'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		$imagem = $this->model_inspecao->buscar_imagem($campos['inspecao_codigo'], $campos['imagem_codigo']);

		if (!$imagem) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma imagem com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		$deletar_imagens = $this->model_inspecao->deletar_imagem($imagem);

		if (!$deletar_imagens) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro ao deletar a imagem da inspeção, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		if (file_exists($imagem['imagem'])) {
			unlink($imagem['imagem']);
		}

		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}

	public function finalizar()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo'),
			'observacao' => $this->input->post('observacao'),
			'liberacao' => ($this->input->post('tipo') === 'LIBERAÇÃO') ? $this->input->post('liberacao') : null
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if ($this->input->post('tipo') === 'LIBERAÇÃO') {
			$this->form_validation->set_rules('liberacao', 'liberação', 'required|exact_length[1]|in_list[S,N]');
		}

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		if ($inspecao['tipo'] === 'LIBERAÇÃO' && empty($campos['liberacao'])) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p><b>Atenção!</b> Esta inspeção não pode ser finalizada pois seu tipo é de <b>LIBERAÇÃO</b> e não foi informado se a mesma está ou não liberada. Corrija ela e tente novamente, persistindo o problema contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		$finalizar = $this->model_inspecao->finalizar($campos);

		if (!$finalizar) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro ao finalizar a inspeção, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		/*
		 * Envia o e-mail da inspeção para
		 */
		$this->load->library('email');

		$de_nome = "";
		$de_email = "";

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
			'imagens' => $this->model_inspecao->buscar_imagens($inspecao['codigo'])
		);

		$corpo_email = $this->load->view('email/inspecao', $dados, true);

		$configura_email['mailtype'] = 'html';
		$configura_email['charset'] = 'utf-8';
		$configura_email['protocol'] = 'smtp';
		$configura_email['smtp_crypto'] = 'ssl';
		$configura_email['smtp_host'] = '';
		$configura_email['smtp_port'] = '';
		$configura_email['smtp_user'] = '';
		$configura_email['smtp_pass'] = '';
		$configura_email['validate'] = 'TRUE';

		$this->email->initialize($configura_email);

		$this->email->from($de_email, $de_nome);
		$this->email->to('');
		// $this->email->cc('thiago.schoeffel@sardo.com.br');
		$this->email->subject('Inspeção ' . $inspecao['codigo'] . ' | ' . $inspecao['nome_fornecedor']);
		$this->email->message($corpo_email);

		if (!$this->email->send()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p><b>Atenção!</b> A inspeção foi finalizada, porém o e-mail de aviso não pode ser enviado.</p>'
			);

			echo json_encode($response);
			return;
		}
		/*
		 * Finaliza o e-mail da inspeção para
		 */

		$response['sucesso'] = array(
			'tipo' => 'success',
			'texto' => '<p><b>Sucesso!</b> A inspeção foi finalizada e o e-mail de aviso foi enviado aos responsáveis.</p>'
		);
		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}

	public function reenviar_email()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		/*
		 * Envia o e-mail da inspeção para
		 */
		$this->load->library('email');

		$de_nome = "";
		$de_email = "";

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
			'imagens' => $this->model_inspecao->buscar_imagens($inspecao['codigo'])
		);

		$corpo_email = $this->load->view('email/inspecao', $dados, true);

		$configura_email['mailtype'] = 'html';
		$configura_email['charset'] = 'utf-8';
		$configura_email['protocol'] = 'smtp';
		$configura_email['smtp_crypto'] = 'ssl';
		$configura_email['smtp_host'] = '';
		$configura_email['smtp_port'] = '';
		$configura_email['smtp_user'] = '';
		$configura_email['smtp_pass'] = '';
		$configura_email['validate'] = 'TRUE';

		$this->email->initialize($configura_email);

		$this->email->from($de_email, $de_nome);
		$this->email->to('');
		// $this->email->cc('thiago.schoeffel@sardo.com.br');
		$this->email->subject('Inspeção ' . $inspecao['codigo'] . ' | ' . $inspecao['nome_fornecedor']);
		$this->email->message($corpo_email);

		if (!$this->email->send()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p><b>Atenção!</b> Não foi possível reenviar o e-mail aos responsáveis, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}
		/*
		 * Finaliza o e-mail da inspeção para
		 */

		$response['sucesso'] = array(
			'tipo' => 'success',
			'texto' => '<p><b>Sucesso!</b> A inspeção foi reenviada por e-mail aos responsáveis.</p>'
		);
		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}

	public function reabrir()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('inspecao');
			return;
		}

		$response = array();

		$campos = array(
			'inspecao_codigo' => $this->input->post('inspecao_codigo')
		);

		$this->form_validation->set_data($campos);

		$this->form_validation->set_rules('inspecao_codigo', 'código da inspeção',
			'required|integer|is_natural_no_zero');

		if (!$this->form_validation->run()) {
			$response['erro'] = array(
				'tipo' => 'warning',
				'texto' => '<p class="mb-2"><b>Atenção!</b> Ocorreram erros de validação.</p><ul class="mb-0">' . validation_errors() . '</ul>'
			);

			echo json_encode($response);
			return;
		}

		$inspecao = $this->model_inspecao->buscar_codigo($campos['inspecao_codigo']);

		if (!$inspecao) {
			$response['erro'] = array(
				'tipo' => 'primary',
				'texto' => '<p><b>Informação!</b> Não foi encontrada nenhuma inspeção com este código.</p>'
			);

			echo json_encode($response);
			return;
		}

		if ($this->session->userdata('usuario_logado')['admin'] != 'S') {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Você não tem permissão para reabrir esta inspeção, contate o responsável e solicite a reabertura.</p>'
			);

			echo json_encode($response);
			return;
		}

		$reabrir = $this->model_inspecao->reabrir($campos);

		if (!$reabrir) {
			$response['erro'] = array(
				'tipo' => 'danger',
				'texto' => '<p><b>Erro!</b> Ocorreu um erro ao reabrir a inspeção, tente novamente e caso o erro persista contate o administrador do sistema.</p>'
			);

			echo json_encode($response);
			return;
		}

		$response['sucesso'] = array(
			'tipo' => 'success',
			'texto' => '<p><b>Sucesso!</b> A inspeção foi reaberta.</p>'
		);
		$response['resultado'] = true;

		echo json_encode($response);
		return;
	}
}
