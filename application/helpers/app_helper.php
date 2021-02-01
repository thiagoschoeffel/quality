<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('data_hora_ptbr_para_db')) {

	function data_hora_ptbr_para_db($data)
	{
		$array = explode(' ', $data);
		$arrayData = explode('/', $array[0]);

		return $arrayData[2] . '-' . $arrayData[1] . '-' . $arrayData[0] . ' ' . $array[1];
	}

}

if (!function_exists('fazer_calssificacoes')) {

	function fazer_calssificacoes($dados)
	{
		$classificacao = array(
			'abaixo_menos_2' => array('coluna' => 'ABAIXO -2', 'valor' => 0),
			'menos_2' => array('coluna' => '-2', 'valor' => 0),
			'menos_1_5' => array('coluna' => '-1,5', 'valor' => 0),
			'menos_1' => array('coluna' => '-1', 'valor' => 0),
			'menos_0_5' => array('coluna' => '-0,5', 'valor' => 0),
			'igual_0' => array('coluna' => '0', 'valor' => 0),
			'mais_0_5' => array('coluna' => '0,5', 'valor' => 0),
			'mais_1' => array('coluna' => '1', 'valor' => 0),
			'mais_1_5' => array('coluna' => '1,5', 'valor' => 0),
			'mais_2' => array('coluna' => '2', 'valor' => 0),
			'acima_mais_2' => array('coluna' => 'ACIMA 2', 'valor' => 0)
		);

		if (!count($dados) > 0) {
			return false;
		}

		if (count($dados['leituras']) > 0) {
			for ($i = 0; $i < count($dados['leituras']); $i++) {
				if ($dados['leituras'][$i]['valor'] < ($dados['medida'] - 2)) {
					$classificacao['abaixo_menos_2']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] - 2) && $dados['leituras'][$i]['valor'] < ($dados['medida'] - 1.5)) {
					$classificacao['menos_2']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] - 1.5) && $dados['leituras'][$i]['valor'] < ($dados['medida'] - 1)) {
					$classificacao['menos_1_5']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] - 1) && $dados['leituras'][$i]['valor'] < ($dados['medida'] - 0.5)) {
					$classificacao['menos_1']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] - 0.5) && $dados['leituras'][$i]['valor'] < $dados['medida']) {
					$classificacao['menos_0_5']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= $dados['medida'] && $dados['leituras'][$i]['valor'] < ($dados['medida'] + 0.5)) {
					$classificacao['igual_0']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] + 0.5) && $dados['leituras'][$i]['valor'] < ($dados['medida'] + 1)) {
					$classificacao['mais_0_5']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] + 1) && $dados['leituras'][$i]['valor'] < ($dados['medida'] + 1.5)) {
					$classificacao['mais_1']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] >= ($dados['medida'] + 1.5) && $dados['leituras'][$i]['valor'] < ($dados['medida'] + 2)) {
					$classificacao['mais_1_5']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] == ($dados['medida'] + 2)) {
					$classificacao['mais_2']['valor']++;
				}

				if ($dados['leituras'][$i]['valor'] > ($dados['medida'] + 2)) {
					$classificacao['acima_mais_2']['valor']++;
				}
			}
		}

		return $classificacao;
	}

}
