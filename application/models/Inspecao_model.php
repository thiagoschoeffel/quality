<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inspecao_model extends CI_Model
{

	public function buscar_codigo($codigo)
	{
		$this->db->select('ins.codigo, ins.tipo, ins.fornecedor as codigo_fornecedor, for.nome as nome_fornecedor, ins.local as codigo_local, loc.nome as nome_local, ins.familia, ins.espessura, ins.largura, ins.comprimento, ins.produto, ins.derivacao as codigo_derivacao, der.descricao as nome_derivacao, ins.nota_fiscal, ins.pedido, ins.observacao, ins.situacao, ins.datahora, ins.inspetor as codigo_inspetor, usu.nome as nome_inspetor, ins.liberacao');
		$this->db->join('fornecedores for', 'for.codigo = ins.fornecedor', 'inner');
		$this->db->join('fornecedores loc', 'loc.codigo = ins.local', 'inner');
		$this->db->join('derivacoes der', 'der.codigo = ins.derivacao', 'inner');
		$this->db->join('usuarios usu', 'usu.codigo = ins.inspetor', 'inner');
		$this->db->from('inspecoes ins');
		$this->db->where('ins.codigo', $codigo);

		return $this->db->get()->row_array();
	}

	public function criar($dados)
	{
		$this->db->insert('inspecoes', $dados);

		return $this->db->insert_id();
	}

	public function finalizar($dados)
	{
		$this->db->set('observacao', (empty($dados['observacao']) ? null : $dados['observacao']));
		$this->db->set('situacao', 'F');

		if (!empty($dados['liberacao'])) {
			$this->db->set('liberacao', $dados['liberacao']);
		}

		$this->db->where("codigo", $dados['inspecao_codigo']);

		return $this->db->update('inspecoes');
	}

	public function deletar()
	{

	}

	public function buscar_parametros_nao_visuais($codigo_inspecao)
	{
		$this->db->select("codigo, descricao");
		$this->db->from("parametros par");
		$this->db->where("par.codigo not in (select lei.parametro from leituras lei where lei.inspecao = " . $codigo_inspecao . ")");
		$this->db->where("par.tipo", "D");

		return $this->db->get()->result_array();
	}

	public function buscar_dados_parametros_nao_visuais($parametro)
	{
		$this->db->select("pontos, tolerancia_minima, tolerancia_maxima");
		$this->db->from("parametros");
		$this->db->where("codigo", $parametro);

		return $this->db->get()->row_array();
	}

	public function buscar_dados_parametros_visuais($codigo_inspecao)
	{
		$this->db->select("codigo, descricao");
		$this->db->from("parametros par");
		$this->db->where("par.codigo not in (select lei.parametro from leituras lei where lei.inspecao = " . $codigo_inspecao . ")");
		$this->db->where("par.tipo", "V");

		return $this->db->get()->result_array();
	}

	public function buscar_leituras_nao_visuais($codigo_inspecao)
	{
		$this->db->select("(case par.tipo when 'D' then 'DIMENSIONAL' else 'VISUAL' end) as tipo, par.codigo as codigo_parametro, par.descricao as nome_parametro, lei.amostras, min(lei.valor) as menor_leitura, max(lei.valor) as maior_leitura, (max(lei.valor) - min(lei.valor)) as amplitude, round(avg(lei.valor), 2) as media");
		$this->db->join("inspecoes ins", "ins.codigo = lei.inspecao", "inner");
		$this->db->join("parametros par", "par.codigo = lei.parametro", "inner");
		$this->db->from("leituras lei");
		$this->db->where("ins.codigo", $codigo_inspecao);
		$this->db->where("par.tipo", 'D');
		$this->db->group_by("tipo, par.codigo, par.descricao, lei.amostras");

		return $this->db->get()->result_array();
	}

	public function buscar_leituras_visuais($codigo_inspecao)
	{
		$this->db->select("(case par.tipo when 'D' then 'DIMENSIONAL' else 'VISUAL' end) as tipo, par.codigo as codigo_parametro, par.descricao as nome_parametro, lei.amostras, lei.valor, round(((lei.valor / lei.amostras) * 100), 2) as porcentagem_defeitos");
		$this->db->join("inspecoes ins", "ins.codigo = lei.inspecao", "inner");
		$this->db->join("parametros par", "par.codigo = lei.parametro", "inner");
		$this->db->from("leituras lei");
		$this->db->where("ins.codigo", $codigo_inspecao);
		$this->db->where("par.tipo", 'V');
		$this->db->group_by("tipo, par.codigo, par.descricao, lei.amostras, lei.valor");

		return $this->db->get()->result_array();
	}

	public function salvar_leituras_dimensionais($leituras)
	{
		$this->db->trans_start();

		for ($i = 0; $i < count($leituras); $i++) {
			$this->db->insert('leituras', $leituras[$i]);
		}

		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function salvar_leituras_visuais($leituras)
	{
		$this->db->trans_start();

		for ($i = 0; $i < count($leituras); $i++) {
			$this->db->insert('leituras', $leituras[$i]);
		}

		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function deletar_leituras($dados)
	{
		$this->db->where("inspecao", $dados['inspecao_codigo']);
		$this->db->where("parametro", $dados['parametro_codigo']);

		return $this->db->delete('leituras');
	}

	public function buscar_imagens($codigo_inspecao)
	{
		$this->db->select("codigo, imagem");
		$this->db->from("imagens");
		$this->db->where("inspecao", $codigo_inspecao);

		return $this->db->get()->result_array();
	}

	public function buscar_imagem($inspecao_codigo, $imagem_codigo)
	{
		$this->db->select("*");
		$this->db->from("imagens");
		$this->db->where("codigo", $imagem_codigo);
		$this->db->where("inspecao", $inspecao_codigo);

		return $this->db->get()->row_array();
	}

	public function salvar_imagem($dados)
	{
		return $this->db->insert('imagens', $dados);
	}

	public function deletar_imagem($dados)
	{
		$this->db->where("codigo", $dados['codigo']);
		$this->db->where("inspecao", $dados['inspecao']);

		return $this->db->delete('imagens');
	}

	public function buscar_resumo_leituras_nao_visuais($inspecao_codigo)
	{
		$this->db->select("par.descricao, lei.amostra, sum(valor*(1-abs(sign(ponto-1)))) as ponto_1, sum(valor*(1-abs(sign(ponto-2)))) as ponto_2, sum(valor*(1-abs(sign(ponto-3)))) as ponto_3");
		$this->db->from("leituras lei");
		$this->db->join("inspecoes ins", "ins.codigo = lei.inspecao", "inner");
		$this->db->join("parametros par", "par.codigo = lei.parametro", "inner");
		$this->db->where("par.tipo", "D");
		$this->db->where("ins.codigo", $inspecao_codigo);
		$this->db->group_by("par.descricao, lei.amostra");

		return $this->db->get()->result_array();
	}

	public function buscar_resumo_leituras_nao_visuais_parametros($inspecao_codigo, $parametro_codigo)
	{
		$this->db->select("par.descricao, lei.amostra, sum(valor*(1-abs(sign(ponto-1)))) as ponto_1, sum(valor*(1-abs(sign(ponto-2)))) as ponto_2, sum(valor*(1-abs(sign(ponto-3)))) as ponto_3");
		$this->db->from("leituras lei");
		$this->db->join("inspecoes ins", "ins.codigo = lei.inspecao", "inner");
		$this->db->join("parametros par", "par.codigo = lei.parametro", "inner");
		$this->db->where("par.tipo", "D");
		$this->db->where("ins.codigo", $inspecao_codigo);
		$this->db->where("lei.parametro", $parametro_codigo);
		$this->db->group_by("par.descricao, lei.amostra");

		return $this->db->get()->result_array();
	}

	public function buscar_resumo_leituras_visuais($inspecao_codigo)
	{
		$this->db->select("par.descricao, lei.amostras, lei.valor, round(((lei.valor / lei.amostras) * 100), 2) as porcentagem_defeitos");
		$this->db->from("leituras lei");
		$this->db->join("inspecoes ins", "ins.codigo = lei.inspecao", "inner");
		$this->db->join("parametros par", "par.codigo = lei.parametro", "inner");
		$this->db->where("par.tipo", "V");
		$this->db->where("ins.codigo", $inspecao_codigo);
		$this->db->group_by("par.descricao, lei.amostras, lei.valor");

		return $this->db->get()->result_array();
	}

	public function buscar_resumo_dados_parametros_nao_visuais_tolerancias()
	{
		$this->db->select("descricao, tolerancia_minima, tolerancia_maxima");
		$this->db->from("parametros");
		$this->db->where("tipo", "D");

		return $this->db->get()->result_array();
	}

	public function buscar_parametros_nao_visuais_inspecionados($codigo_inspecao)
	{
		$this->db->select("codigo, descricao");
		$this->db->from("parametros par");
		$this->db->where("par.codigo in (select lei.parametro from leituras lei where lei.inspecao = " . $codigo_inspecao . ")");
		$this->db->where("par.tipo", "D");

		return $this->db->get()->result_array();
	}

	public function buscar_leituras_nao_visuais_parametro($codigo_inspecao, $codigo_parametro)
	{
		$this->db->select('lei.valor');
		$this->db->from('leituras lei');
		$this->db->where('lei.inspecao', $codigo_inspecao);
		$this->db->where('lei.parametro', $codigo_parametro);

		return $this->db->get()->result_array();
	}

	public function reabrir($dados)
	{
		$this->db->set('situacao', 'A');

		$this->db->where("codigo", $dados['inspecao_codigo']);

		return $this->db->update('inspecoes');
	}

}
