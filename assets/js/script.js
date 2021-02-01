function ativaCarregamento() {
	$('.j_app_carregamento').fadeIn(500);
}

function desativaCarregamento() {
	$('.j_app_carregamento').fadeOut(500);
}

function exibeMensagem(tipo, texto) {
	$('.j_app_mensagem')
		.fadeOut(500, function () {
			$(this).html('<div class="alert alert-' + tipo + ' alert-dismissible">' + texto + '</div>');

			$(this).fadeIn(500, function () {
				setTimeout(function () {
					$('.j_app_mensagem').fadeOut(500);
				}, 4000);
			});
		});
}

function carregaDadosInspecao(codigo, observacao = 'S') {
	var url = base_url + 'inspecao/carregar';
	var dados = {
		inspecao_codigo: codigo
	};

	$.ajax({
		url: url,
		type: 'post',
		dataType: 'json',
		data: dados,
		beforeSend: function () {
			ativaCarregamento();

			$('#j_app_tabela_resumo_inspecao_leituras_dimensionais').find('tbody').html('');
			$('#j_app_tabela_resumo_inspecao_leituras_visuais').find('tbody').html('');
		},
		success: function (response) {
			if (response.erro) {
				exibeMensagem(response.erro.tipo, response.erro.texto);
			}

			if (response.inspecao) {
				if (response.inspecao.situacao === 'A') {
					esvaziaCamposCriaInspecao();
					desativaCamposCriaInspecao();

					$('#inspecao_codigo').prop('disabled', true);

					$('#inspecao_codigo').val(response.inspecao.codigo);
					$('#parametro_produto_espessura').val(response.inspecao.espessura);
					$('#parametro_produto_largura').val(response.inspecao.largura);
					$('#parametro_produto_comprimento').val(response.inspecao.comprimento);

					var datahora = moment(response.inspecao.datahora, 'YYYY-MM-DD HH:mm:ss');
					$('#j_app_texto_inspecao_datahora').html(datahora.format('DD/MM/YYYY HH:mm:ss'));

					$('#j_app_texto_inspecao_inspetor').html(response.inspecao.codigo_inspetor + ' - ' + response.inspecao.nome_inspetor);
					$('#j_app_texto_inspecao_tipo').html(response.inspecao.tipo);
					$('#j_app_texto_inspecao_fornecedor').html(response.inspecao.codigo_fornecedor + ' - ' + response.inspecao.nome_fornecedor);
					$('#j_app_texto_inspecao_local').html(response.inspecao.codigo_local + ' - ' + response.inspecao.nome_local);
					$('#j_app_texto_inspecao_produto').html(response.inspecao.produto);
					$('#j_app_texto_inspecao_medidas').html(response.inspecao.espessura + ' x ' + response.inspecao.largura + ' x ' + response.inspecao.comprimento);
					$('#j_app_texto_inspecao_derivacao').html(response.inspecao.codigo_derivacao + ' - ' + response.inspecao.nome_derivacao);
					$('#j_app_texto_inspecao_nota_fiscal').html(response.inspecao.nota_fiscal);
					$('#j_app_texto_inspecao_pedido').html(response.inspecao.pedido);
					$('#j_app_texto_inspecao_observacao').html(response.inspecao.observacao);

					var conteudo_tabela_resumo_inspecao_leituras_dimensionais = '';

					if (response.inspecao_leituras_nao_visuais.length > 0) {
						$.each(response.inspecao_leituras_nao_visuais, function (index, value) {
							conteudo_tabela_resumo_inspecao_leituras_dimensionais += '<tr><td><button class="btn btn-sm btn-light app_btn_icon j_app_btn_deleta_leitura" data-codigo-parametro="' + value.codigo_parametro + '"><span class="app_icon app_icon_delete"></span></button></td><td>' + value.nome_parametro + '</td><td>' + value.amostras + '</td><td>' + value.menor_leitura + '</td><td>' + value.maior_leitura + '</td><td>' + value.amplitude + '</td><td>' + value.media + '</td></tr>';
						});
					} else {
						conteudo_tabela_resumo_inspecao_leituras_dimensionais += '<tr><td colspan="7">Nenhuma leitura realizada nesta inspeção até o momento.</td></tr>';
					}

					var conteudo_tabela_resumo_inspecao_leituras_visuais = '';

					if (response.inspecao_leituras_visuais.length > 0) {
						$.each(response.inspecao_leituras_visuais, function (index, value) {
							conteudo_tabela_resumo_inspecao_leituras_visuais += '<tr><td><button class="btn btn-sm btn-light app_btn_icon j_app_btn_deleta_leitura" data-codigo-parametro="' + value.codigo_parametro + '"><span class="app_icon app_icon_delete"></span></button></td><td>' + value.nome_parametro + '</td><td>' + value.amostras + '</td><td>' + value.valor + '</td><td>' + value.porcentagem_defeitos + '</td></tr>';
						});
					} else {
						conteudo_tabela_resumo_inspecao_leituras_visuais += '<tr><td colspan="5">Nenhuma leitura realizada nesta inspeção até o momento.</td></tr>';
					}

					$('#j_app_tabela_resumo_inspecao_leituras_dimensionais').find('tbody').append(conteudo_tabela_resumo_inspecao_leituras_dimensionais);
					$('#j_app_tabela_resumo_inspecao_leituras_visuais').find('tbody').append(conteudo_tabela_resumo_inspecao_leituras_visuais);

					var conteudo_imagens_inspecao = '';

					if (response.inspecao_imagens.length > 0) {
						$.each(response.inspecao_imagens, function (index, value) {
							conteudo_imagens_inspecao += '<div class="col-12 col-md-4 col-lg-2 mb-2"><div class="card border-0"><div class="card-body p-1 text-center"><img src="' + base_url + value.imagem + '" class="img-thumbnail mb-2"><button class="btn btn-sm btn-danger app_btn_icon j_app_btn_deleta_imagem_inspecao" data-codigo-imagem="' + value.codigo + '"><span class="app_icon app_icon_delete"></span> Deletar Imagem</button></div></div></div>';
						});
					}

					$('#j_app_imagens_upload').html(conteudo_imagens_inspecao);

					if (observacao === 'S') {
						$('#observacao').val(response.inspecao.observacao);
					}
				}

				if (response.inspecao.situacao === 'F') {
					$('#j_app_card_gerencia_inspecao').fadeOut('fast', function () {
						esvaziaCamposCriaInspecao();
						desativaCamposCriaInspecao();

						var url = base_url + 'inspecao/buscar_resumo';
						var dados = {
							inspecao_codigo: response.inspecao.codigo
						};

						$.ajax({
							url: url,
							type: 'post',
							dataType: 'json',
							data: dados,
							beforeSend: function () {
								ativaCarregamento();
							},
							success: function (response) {
								if (response.erro) {
									exibeMensagem(response.erro.tipo, response.erro.texto);
								}

								$('#j_app_div_resumo_inspecao').html(response.resumo);
							},
							error: function (jqXHR, textStatus, errorThrown) {
								alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
								desativaCarregamento();
							},
							complete: function (jqXHR, textStatus) {
								desativaCarregamento();
							}
						});

						$('#j_app_card_resumo_inspecao').fadeIn('fast', function () {
						});
					});
				}
			} else {
				$('#inspecao_codigo').val('');
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
			desativaCarregamento();
		},
		complete: function (jqXHR, textStatus) {
			desativaCarregamento();
		}
	});
}

function ativaCamposCriaInspecao() {
	$('#inspecao_codigo_fornecedor').prop('disabled', false);
	$('#inspecao_nome_fornecedor').prop('disabled', false);
	$('#inspecao_codigo_local').prop('disabled', false);
	$('#inspecao_nome_local').prop('disabled', false);
	$('#inspecao_codigo_derivacao').prop('disabled', false);
	$('#inspecao_produto_espessura').prop('disabled', false);
	$('#inspecao_produto_largura').prop('disabled', false);
	$('#inspecao_produto_comprimento').prop('disabled', false);
	$('#inspecao_nota_fiscal').prop('disabled', false);
	$('#inspecao_pedido').prop('disabled', false);
	$('#inspecao_tipo').prop('disabled', false);
	$('#j_app_btn_cria_inspecao').prop('disabled', false);
}

function desativaCamposCriaInspecao() {
	$('#inspecao_codigo_fornecedor').prop('disabled', true);
	$('#inspecao_nome_fornecedor').prop('disabled', true);
	$('#inspecao_codigo_local').prop('disabled', true);
	$('#inspecao_nome_local').prop('disabled', true);
	$('#inspecao_codigo_derivacao').prop('disabled', true);
	$('#inspecao_produto_espessura').prop('disabled', true);
	$('#inspecao_produto_largura').prop('disabled', true);
	$('#inspecao_produto_comprimento').prop('disabled', true);
	$('#inspecao_nota_fiscal').prop('disabled', true);
	$('#inspecao_pedido').prop('disabled', true);
	$('#inspecao_tipo').prop('disabled', true);
	$('#j_app_btn_cria_inspecao').prop('disabled', true);
}

function esvaziaCamposCriaInspecao() {
	$('#inspecao_codigo_fornecedor').val('');
	$('#inspecao_nome_fornecedor').val('');
	$('#inspecao_codigo_local').val('');
	$('#inspecao_nome_local').val('');
	$('#inspecao_codigo_derivacao').val('');
	$('#inspecao_produto_espessura').val('');
	$('#inspecao_produto_largura').val('');
	$('#inspecao_produto_comprimento').val('');
	$('#inspecao_nota_fiscal').val('');
	$('#inspecao_pedido').val('');
	$('#inspecao_tipo').val('ROTINA');
}

function ativaCamposEditaInspecao(codigo = 'S') {
	if (codigo === 'S') {
		$('#inspecao_codigo').prop('disabled', false);
	}

	$('#parametro_tipo').prop('disabled', false);
	$('#parametro_codigo').prop('disabled', false);
	$('#parametro_amostras').prop('disabled', false);
	$('#parametro_produto_espessura').prop('disabled', false);
	$('#parametro_produto_largura').prop('disabled', false);
	$('#parametro_produto_comprimento').prop('disabled', false);
	$('#j_app_btn_cria_leitura').prop('disabled', false);
	$('#j_app_btn_abre_card_finaliza_inspecao').prop('disabled', false);
	$('#j_app_btn_cancela_inspecao').prop('disabled', false);
	$('#j_app_btn_abre_modal_deleta_inspecao').prop('disabled', false);
}

function desativaCamposEditaInspecao() {
	$('#inspecao_codigo').prop('disabled', true);
	$('#parametro_tipo').prop('disabled', true);
	$('#parametro_codigo').prop('disabled', true);
	$('#parametro_amostras').prop('disabled', true);
	$('#parametro_produto_espessura').prop('disabled', true);
	$('#parametro_produto_largura').prop('disabled', true);
	$('#parametro_produto_comprimento').prop('disabled', true);
	$('#j_app_btn_cria_leitura').prop('disabled', true);
	$('#j_app_btn_abre_card_finaliza_inspecao').prop('disabled', true);
	$('#j_app_btn_cancela_inspecao').prop('disabled', true);
	$('#j_app_btn_abre_modal_deleta_inspecao').prop('disabled', true);
}

function esvaziaCamposEditaInspecao(codigo = 'S') {
	if (codigo === 'S') {
		$('#inspecao_codigo').val('');
	}

	$('#parametro_tipo').val('');
	$('#parametro_codigo').html('');
	$('#parametro_amostras').val('');
	$('#parametro_pontos').val('');
	$('#parametro_tolerancia_minima').val('');
	$('#parametro_valor_nominal').val('');
	$('#parametro_tolerancia_maxima').val('');
	$('#parametro_produto_espessura').val('');
	$('#parametro_produto_largura').val('');
	$('#parametro_produto_comprimento').val('');
	$('#j_app_texto_inspecao_datahora').html('');
	$('#j_app_texto_inspecao_inspetor').html('');
	$('#j_app_texto_inspecao_tipo').html('');
	$('#j_app_texto_inspecao_fornecedor').html('');
	$('#j_app_texto_inspecao_local').html('');
	$('#j_app_texto_inspecao_produto').html('');
	$('#j_app_texto_inspecao_medidas').html('');
	$('#j_app_texto_inspecao_derivacao').html('');
	$('#j_app_texto_inspecao_nota_fiscal').html('');
	$('#j_app_texto_inspecao_pedido').html('');
	$('#j_app_texto_inspecao_observacao').html('');
	$('#j_app_tabela_resumo_inspecao_leituras_dimensionais').find('tbody').html('');
	$('#j_app_tabela_resumo_inspecao_leituras_visuais').find('tbody').html('');
	$('#observacao').val('');
	$('#j_app_imagens_upload').html('');
}

$(document).ready(function () {

	$('#j_app_btn_efetua_login').on('click', function () {
		var url = base_url + 'login/entrar';
		var dados = {
			nome_usuario: $('#nome_usuario').val(),
			senha: $('#senha').val()
		};

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: dados,
			beforeSend: function () {
				ativaCarregamento();
			},
			success: function (response) {
				if (response.erro) {
					exibeMensagem(response.erro.tipo, response.erro.texto);
				}

				if (response.redirecionamento) {
					window.location.href = response.redirecionamento;
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
				desativaCarregamento();
			},
			complete: function (jqXHR, textStatus) {
				desativaCarregamento();
			}
		});
	});

	$('#inspecao_codigo_fornecedor').on('blur', function () {
		if (this.value.length > 0) {
			var url = base_url + 'fornecedor/buscar_codigo';
			var dados = {
				codigo_fornecedor: $('#inspecao_codigo_fornecedor').val()
			};

			$.ajax({
				url: url,
				type: 'post',
				data: dados,
				dataType: 'json',
				beforeSend: function () {
					ativaCarregamento();

					$('#inspecao_nome_fornecedor').val('');
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);

						$('#inspecao_codigo_fornecedor').val('');
						$('#inspecao_nome_fornecedor').val('');
					} else {
						$('#inspecao_nome_fornecedor').val(response.nome);
					}
				},
				error: function () {
					desativaCarregamento();
				},
				complete: function () {
					desativaCarregamento();
				}
			});
		} else {
			$('#inspecao_nome_fornecedor').val('');
		}
	});

	$('#inspecao_nome_fornecedor').on('keyup', function (event) {
		if (this.value.length > 2) {
			if (event.which !== 9 && event.which !== 13 && event.which !== 16 && event.which !== 17 && event.which !== 18 && event.which !== 20 && event.which !== 27) {
				var url = base_url + 'fornecedor/buscar_nome';
				var dados = {
					nome_fornecedor: $('#inspecao_nome_fornecedor').val()
				};

				$.ajax({
					url: url,
					type: 'post',
					data: dados,
					dataType: 'json',
					beforeSend: function () {
						$('#j_app_lista_autocompletar1').html('');
						$('#j_app_lista_autocompletar1').removeClass('mb-2');
					},
					success: function (response) {
						var html_lista_fornecedor_busca_nome = '';

						$.each(response, function (index, value) {
							html_lista_fornecedor_busca_nome += '<a href="#" class="list-group-item list-group-item-action px-2 py-1 j_app_lista_autocompletar1_item" data-codigo="' + value.codigo + '" data-nome="' + value.nome + '"><small>' + value.codigo + ' - ' + value.nome + '</small></a>';
						});

						$('#j_app_lista_autocompletar1').addClass('mb-2');
						$('#j_app_lista_autocompletar1').html(html_lista_fornecedor_busca_nome);
					},
					error: function () {
					},
					complete: function () {
					}
				});
			}
		} else {
			$('#j_app_lista_autocompletar1').html('');
			$('#j_app_lista_autocompletar1').removeClass('mb-2');
		}
	});

	$(document).on('click', '.j_app_lista_autocompletar1_item', function (event) {
		event.preventDefault();

		$('#inspecao_codigo_fornecedor').val($(this).attr('data-codigo'));
		$('#inspecao_nome_fornecedor').val($(this).attr('data-nome'));

		$('#j_app_lista_autocompletar1').html('');
		$('#j_app_lista_autocompletar1').removeClass('mb-2');
	});

	$('#inspecao_codigo_local').on('blur', function () {
		if (this.value.length > 0) {
			var url = base_url + 'fornecedor/buscar_codigo';
			var dados = {
				codigo_fornecedor: $('#inspecao_codigo_local').val()
			};

			$.ajax({
				url: url,
				type: 'post',
				data: dados,
				dataType: 'json',
				beforeSend: function () {
					ativaCarregamento();

					$('#inspecao_nome_local').val('');
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);

						$('#inspecao_codigo_local').val('');
						$('#inspecao_nome_local').val('');
					} else {
						$('#inspecao_nome_local').val(response.nome);
					}
				},
				error: function () {
					desativaCarregamento();
				},
				complete: function () {
					desativaCarregamento();
				}
			});
		} else {
			$('#inspecao_nome_local').val('');
		}
	});

	$('#inspecao_nome_local').on('keyup', function (event) {
		if (this.value.length > 2) {
			if (event.which !== 9 && event.which !== 13 && event.which !== 16 && event.which !== 17 && event.which !== 18 && event.which !== 20 && event.which !== 27) {
				var url = base_url + 'fornecedor/buscar_nome';
				var dados = {
					nome_fornecedor: $('#inspecao_nome_local').val()
				};

				$.ajax({
					url: url,
					type: 'post',
					data: dados,
					dataType: 'json',
					beforeSend: function () {
						$('#j_app_lista_autocompletar2').html('');
						$('#j_app_lista_autocompletar2').removeClass('mb-2');
					},
					success: function (response) {
						var html_lista_fornecedor_busca_nome = '';

						$.each(response, function (index, value) {
							html_lista_fornecedor_busca_nome += '<a href="#" class="list-group-item list-group-item-action px-2 py-1 j_app_lista_autocompletar2_item" data-codigo="' + value.codigo + '" data-nome="' + value.nome + '"><small>' + value.codigo + ' - ' + value.nome + '</small></a>';
						});

						$('#j_app_lista_autocompletar2').addClass('mb-2');
						$('#j_app_lista_autocompletar2').html(html_lista_fornecedor_busca_nome);
					},
					error: function () {
					},
					complete: function () {
					}
				});
			}
		} else {
			$('#j_app_lista_autocompletar2').html('');
			$('#j_app_lista_autocompletar2').removeClass('mb-2');
		}
	});

	$(document).on('click', '.j_app_lista_autocompletar2_item', function (event) {
		event.preventDefault();

		$('#inspecao_codigo_local').val($(this).attr('data-codigo'));
		$('#inspecao_nome_local').val($(this).attr('data-nome'));

		$('#j_app_lista_autocompletar2').html('');
		$('#j_app_lista_autocompletar2').removeClass('mb-2');
	});

	$('#j_app_btn_cria_inspecao').on('click', function () {
		var url = base_url + 'inspecao/criar';
		var dados = {
			inspecao_codigo_fornecedor: $('#inspecao_codigo_fornecedor').val(),
			inspecao_codigo_local: $('#inspecao_codigo_local').val(),
			inspecao_codigo_derivacao: $('#inspecao_codigo_derivacao').val(),
			inspecao_produto_espessura: $('#inspecao_produto_espessura').val(),
			inspecao_produto_largura: $('#inspecao_produto_largura').val(),
			inspecao_produto_comprimento: $('#inspecao_produto_comprimento').val(),
			inspecao_nota_fiscal: $('#inspecao_nota_fiscal').val(),
			inspecao_pedido: $('#inspecao_pedido').val(),
			inspecao_tipo: $('#inspecao_tipo').val()
		};

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: dados,
			beforeSend: function () {
				ativaCarregamento();
			},
			success: function (response) {
				if (response.erro) {
					exibeMensagem(response.erro.tipo, response.erro.texto);
				}

				if (response.codigo) {
					carregaDadosInspecao(response.codigo);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
				desativaCarregamento();
			},
			complete: function (jqXHR, textStatus) {
				desativaCarregamento();
			}
		});
	});

	$('#inspecao_codigo').on('blur', function () {
		if (this.value.length > 0) {
			carregaDadosInspecao((this.value));
		}
	});

	$('#parametro_tipo').on('change', function () {
		var url = base_url + 'inspecao/buscar_parametros_nao_visuais';
		var dados = {
			inspecao_codigo: $('#inspecao_codigo').val()
		};

		if ($('#parametro_tipo').val() === 'D') {
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					var conteudo_select_parametro = '<option value=""></option>';

					if (response.parametros_nao_visuais) {
						$.each(response.parametros_nao_visuais, function (index, value) {
							conteudo_select_parametro += '<option value="' + value.codigo + '">' + value.descricao + '</option>';
						});
					}

					$('#parametro_codigo').html(conteudo_select_parametro);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		} else {
			$('#parametro_codigo').html('');

			$('#parametro_amostras').val('');
			$('#parametro_pontos').val('');
			$('#parametro_tolerancia_minima').val('');
			$('#parametro_valor_nominal').val('');
			$('#parametro_tolerancia_maxima').val('');
		}
	});

	$('#parametro_codigo').on('change', function () {
		var url = base_url + 'inspecao/buscar_dados_parametros_nao_visuais';
		var dados = {
			parametro_codigo: $('#parametro_codigo').val()
		};

		if ($('#parametro_codigo').val() !== '') {
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					if (response.parametros_nao_visuais_dados) {
						$('#parametro_pontos').val(response.parametros_nao_visuais_dados.pontos);

						if ($('#parametro_codigo').val() === '1') {
							$('#parametro_tolerancia_minima').val(parseFloat($('#parametro_produto_espessura').val()) - parseFloat(response.parametros_nao_visuais_dados.tolerancia_minima));
							$('#parametro_valor_nominal').val(parseFloat($('#parametro_produto_espessura').val()));
							$('#parametro_tolerancia_maxima').val(parseFloat($('#parametro_produto_espessura').val()) + parseFloat(response.parametros_nao_visuais_dados.tolerancia_maxima));
						}

						if ($('#parametro_codigo').val() === '2') {
							$('#parametro_tolerancia_minima').val(parseFloat($('#parametro_produto_largura').val()) - parseFloat(response.parametros_nao_visuais_dados.tolerancia_minima));
							$('#parametro_valor_nominal').val(parseFloat($('#parametro_produto_largura').val()));
							$('#parametro_tolerancia_maxima').val(parseFloat($('#parametro_produto_largura').val()) + parseFloat(response.parametros_nao_visuais_dados.tolerancia_maxima));
						}

						if ($('#parametro_codigo').val() === '3') {
							$('#parametro_tolerancia_minima').val(parseFloat($('#parametro_produto_comprimento').val()) - parseFloat(response.parametros_nao_visuais_dados.tolerancia_minima));
							$('#parametro_valor_nominal').val(parseFloat($('#parametro_produto_comprimento').val()));
							$('#parametro_tolerancia_maxima').val(parseFloat($('#parametro_produto_comprimento').val()) + parseFloat(response.parametros_nao_visuais_dados.tolerancia_maxima));
						}

						if ($('#parametro_codigo').val() === '4') {
							$('#parametro_tolerancia_minima').val(parseFloat(response.parametros_nao_visuais_dados.tolerancia_minima));
							$('#parametro_valor_nominal').val(parseFloat(response.parametros_nao_visuais_dados.tolerancia_minima));
							$('#parametro_tolerancia_maxima').val(parseFloat(response.parametros_nao_visuais_dados.tolerancia_maxima));
						}
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		} else {
			$('#parametro_amostras').val('');
			$('#parametro_pontos').val('');
			$('#parametro_tolerancia_minima').val('');
			$('#parametro_valor_nominal').val('');
			$('#parametro_tolerancia_maxima').val('');
		}
	});

	$('#j_app_btn_cria_leitura').on('click', function () {
		if ($('#parametro_tipo').val() === 'D') {
			var quantidade_amostras = $('#parametro_amostras').val();
			var quantidade_pontos = $('#parametro_pontos').val();
			var y = 0;
			var x = 0;
			var conteudo_tabela_leitura_dimensional = '<thead class="bg-light"><tr><th>Amostra</th>';

			for (x = 1; x <= quantidade_pontos; x++) {
				conteudo_tabela_leitura_dimensional += '<th>Ponto ' + x + '</th>';
			}

			conteudo_tabela_leitura_dimensional += '<tr></thead><tbody>';

			for (y = 1; y <= quantidade_amostras; y++) {
				conteudo_tabela_leitura_dimensional += '<tr><td>' + y + '</td>';

				for (x = 1; x <= quantidade_pontos; x++) {
					conteudo_tabela_leitura_dimensional += '<td><input type="tel" name="leitura_dimensional_' + y + '_' + x + '" id="leitura_dimensional_' + y + '_' + x + '" class="form-control form-control-sm text-center j_app_input_leitura_dimensional j_app_input_enter"></td>';
				}

				conteudo_tabela_leitura_dimensional += '</tr>';
			}

			conteudo_tabela_leitura_dimensional += '</tbody>';

			$('#j_app_card_leitura_dimensional').fadeIn('fast', function () {
				desativaCamposEditaInspecao();

				$('#j_app_tabela_leitura_dimensional').html(conteudo_tabela_leitura_dimensional);

				$('#leitura_dimensional_1_1').focus();
			});
		} // Leituras dimensionais.

		if ($('#parametro_tipo').val() === 'V') {
			var url = base_url + 'inspecao/buscar_dados_parametros_visuais';
			var dados = {
				inspecao_codigo: $('#inspecao_codigo').val()
			};

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					var y = 0;
					var conteudo_tabela_leitura_visual = '<thead class="bg-light"><tr><th>Defeito</th><th>Quantidade</th></thead><tbody>';

					if (response.parametros_visuais_dados) {
						$.each(response.parametros_visuais_dados, function (index, value) {
							y = (index + 1);

							conteudo_tabela_leitura_visual += '<tr><td>' + value.descricao + '</td><td><input type="tel" name="leitura_visual_' + y + '" id="leitura_visual_' + y + '" class="form-control form-control-sm text-center j_app_input_leitura_visual j_app_input_enter" data-codigo-parametro="' + value.codigo + '"></td></tr>';
						});
					}

					conteudo_tabela_leitura_visual += '</tbody>';

					$('#j_app_card_leitura_visual').fadeIn('fast', function () {
						desativaCamposEditaInspecao();

						$('#j_app_tabela_leitura_visual').html(conteudo_tabela_leitura_visual);

						$('#leitura_visual_1').focus();
					});
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		} // Leituras visuais.
	});

	$('#j_app_btn_cancela_inspecao').on('click', function () {
		esvaziaCamposEditaInspecao();
		ativaCamposEditaInspecao();
		ativaCamposCriaInspecao();
	});

	$('#j_app_btn_cancela_leitura_dimensional').on('click', function () {
		$('#j_app_card_leitura_dimensional').fadeOut('fast', function () {
			ativaCamposEditaInspecao('N');
			$('#j_app_tabela_leitura_dimensional').html('');
		});
	});

	$('#j_app_btn_cancela_leitura_visual').on('click', function () {
		$('#j_app_card_leitura_visual').fadeOut('fast', function () {
			ativaCamposEditaInspecao('N');
			$('#j_app_tabela_leitura_visual').html('');
		});
	});

	$('#j_app_btn_abre_card_finaliza_inspecao').on('click', function () {
		if ($('#inspecao_codigo').val() === '') {
			alert("Você deve primeiramente carregar uma inspeção para conseguir finalizar.");
			return;
		}

		$('#j_app_card_finaliza_inspecao').fadeIn('fast', function () {
			$('#parametro_tipo').val('');
			$('#parametro_codigo').html('');
			$('#parametro_amostras').val('');
			$('#parametro_pontos').val('');
			$('#parametro_tolerancia_minima').val('');
			$('#parametro_valor_nominal').val('');
			$('#parametro_tolerancia_maxima').val('');

			desativaCamposEditaInspecao();

			$('#observacao').focus();

			if ($('#j_app_texto_inspecao_tipo').text() === 'LIBERAÇÃO') {
				$('#j_app_div_libera_inspecao').css('display', 'block');
			}
		});
	});

	$('#j_app_btn_volta_finaliza_inspecao').on('click', function () {
		$('#j_app_card_finaliza_inspecao').fadeOut('fast', function () {
			ativaCamposEditaInspecao('N');
		});
	});

	$(document).on('click', '.j_app_btn_deleta_leitura', function () {
		var confirmacao = confirm('Deseja realmente deletar esta leitura da inspeção?');

		if (confirmacao) {
			var url = base_url + 'inspecao/deletar_leituras';
			var dados = {
				inspecao_codigo: $('#inspecao_codigo').val(),
				parametro_codigo: $(this).attr('data-codigo-parametro')
			};

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					if (response.resultado === true) {
						ativaCamposEditaInspecao('N');
						esvaziaCamposEditaInspecao('N');
						carregaDadosInspecao($('#inspecao_codigo').val(), 'N');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		}
	});

	$('#j_app_btn_finaliza_leitura_dimensional').on('click', function () {
		var url = base_url + 'inspecao/criar_leituras_dimensionais';
		var quantidade_amostras = $('#parametro_amostras').val();
		var quantidade_pontos = $('#parametro_pontos').val();
		var y = 0;
		var x = 0;
		var leituras_dimensionais = [];

		for (y = 1; y <= quantidade_amostras; y++) {
			for (x = 1; x <= quantidade_pontos; x++) {
				if ($('#leitura_dimensional_' + y + '_' + x).val() === '' || $('#leitura_dimensional_' + y + '_' + x).val() <= 0) {
					alert("Todos as leituras devem ser preenchidas, lembrando que são aceitos apenas valores númericos maiores de 0.");
					return;
				}
			}
		}

		for (y = 1; y <= quantidade_amostras; y++) {
			for (x = 1; x <= quantidade_pontos; x++) {
				leituras_dimensionais.push({
					inspecao: $('#inspecao_codigo').val(),
					parametro: $('#parametro_codigo').val(),
					amostras: $('#parametro_amostras').val(),
					amostra: y,
					ponto: x,
					valor: $('#leitura_dimensional_' + y + '_' + x).val()
				});
			}
		}

		var dados = {
			leituras_dimensionais: leituras_dimensionais
		};

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: dados,
			beforeSend: function () {
				ativaCarregamento();
			},
			success: function (response) {
				if (response.erro) {
					exibeMensagem(response.erro.tipo, response.erro.texto);
				}

				if (response.resultado === true) {
					$('#j_app_card_leitura_dimensional').fadeOut('fast', function () {
						ativaCamposEditaInspecao('N');
						esvaziaCamposEditaInspecao('N');
						carregaDadosInspecao($('#inspecao_codigo').val(), 'N');

						$('#j_app_tabela_leitura_dimensional').html('');
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
				console.log(jqXHR, textStatus, errorThrown);

				desativaCarregamento();
			},
			complete: function (jqXHR, textStatus) {
				console.log(jqXHR, textStatus);

				desativaCarregamento();
			}
		});
	});

	$('#j_app_btn_finaliza_leitura_visual').on('click', function () {
		var url = base_url + 'inspecao/criar_leituras_visuais';
		var valor = 0;
		var y = 0;
		var inputs = $('.j_app_input_leitura_visual').length;
		var leituras_visuais = [];

		for (y = 1; y <= inputs; y++) {
			valor = $('#leitura_visual_' + y).val();

			if (valor !== '') {
				leituras_visuais.push({
					inspecao: $('#inspecao_codigo').val(),
					parametro: $('#leitura_visual_' + y).attr('data-codigo-parametro'),
					amostras: $('#parametro_amostras').val(),
					amostra: 0,
					ponto: 0,
					valor: valor
				});
			}
		}

		var dados = {
			leituras_visuais: leituras_visuais
		};

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: dados,
			beforeSend: function () {
				ativaCarregamento();
			},
			success: function (response) {
				if (response.erro) {
					exibeMensagem(response.erro.tipo, response.erro.texto);
				}

				if (response.resultado === true) {
					$('#j_app_card_leitura_visual').fadeOut('fast', function () {
						ativaCamposEditaInspecao('N');
						esvaziaCamposEditaInspecao('N');
						carregaDadosInspecao($('#inspecao_codigo').val(), 'N');

						$('#j_app_tabela_leitura_visual').html('');
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
				console.log(jqXHR, textStatus, errorThrown);

				desativaCarregamento();
			},
			complete: function (jqXHR, textStatus) {
				console.log(jqXHR, textStatus);

				desativaCarregamento();
			}
		});
	});

	$('#imagens').on('change', function () {
		var url = base_url + 'inspecao/mandar_imagens';
		var inspecao_codigo = $('#inspecao_codigo').val();
		var imagens = $('#imagens')[0].files;
		var dados = new FormData();

		dados.append('inspecao_codigo', inspecao_codigo);

		for (var x = 0; x < imagens.length; x++) {
			dados.append('imagens[]', imagens[x]);
		}

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: dados,
			cache: false,
			processData: false,
			contentType: false,
			beforeSend: function () {
				ativaCarregamento();

				$('#imagens').val('');
			},
			success: function (response) {
				if (response.erro) {
					exibeMensagem(response.erro.tipo, response.erro.texto);
				}

				if(response.erro_redimensionamento) {
					var texto = '';
					
					$.each(response.erro_redimensionamento, function (index, value) {
						texto += value;
					});

					exibeMensagem('danger', texto);
				}

				if(response.erro_salvamento) {
					var texto = '';

					$.each(response.erro_salvamento, function (index, value) {
						texto += value;
					});

					exibeMensagem('danger', texto);
				}

				if(response.erro_upload) {
					var texto = '';

					$.each(response.erro_upload, function (index, value) {
						texto += value;
					});

					exibeMensagem('danger', texto);
				}

				carregaDadosInspecao(inspecao_codigo, 'N');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
				desativaCarregamento();
			},
			complete: function (jqXHR, textStatus) {
				desativaCarregamento();
			}
		});
	});

	$(document).on('click', '.j_app_btn_deleta_imagem_inspecao', function () {
		var confirmacao = confirm('Deseja realmente deletar esta imagem da inspeção?');

		if (confirmacao) {
			var url = base_url + 'inspecao/deletar_imagens';
			var dados = {
				inspecao_codigo: $('#inspecao_codigo').val(),
				imagem_codigo: $(this).attr('data-codigo-imagem')
			};

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					if (response.resultado === true) {
						carregaDadosInspecao($('#inspecao_codigo').val(), 'N');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		}
	});

	$('#j_app_btn_finaliza_inspecao').on('click', function () {
		var confirmacao = confirm("Deseja realmente finalizar esta inspeção?");

		if (confirmacao) {
			var url = base_url + 'inspecao/finalizar';
			var dados = {
				inspecao_codigo: $('#inspecao_codigo').val(),
				tipo: $('#j_app_texto_inspecao_tipo').text(),
				observacao: $('#observacao').val(),
				liberacao: $("input[name='liberacao']:checked").val()
			};

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					if (response.resultado === true) {
						exibeMensagem(response.sucesso.tipo, response.sucesso.texto);

						$('#j_app_card_finaliza_inspecao').fadeOut('fast', function () {
							carregaDadosInspecao($('#inspecao_codigo').val(), 'N');
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		}
	});

	$('#j_app_btn_fecha_resumo_inspecao').on('click', function () {
		$('#j_app_card_resumo_inspecao').fadeOut('fast', function () {
			esvaziaCamposEditaInspecao();
			ativaCamposEditaInspecao();
			ativaCamposCriaInspecao();

			$('#j_app_card_gerencia_inspecao').fadeIn('fast', function () {
				$('#j_app_div_resumo_inspecao').html('');
			});
		});
	});

	$(document).on('focusout', '.j_app_input_leitura_dimensional', function () {
		var valor_leitura = parseFloat($(this).val().replace(',', '.'));
		var tolerancia_minima = parseFloat($('#parametro_tolerancia_minima').val());
		var tolerancia_maxima = parseFloat($('#parametro_tolerancia_maxima').val());

		if (!isNaN(valor_leitura)) {
			if (valor_leitura < tolerancia_minima) {
				$(this).addClass('text-danger');
				$(this).addClass('font-weight-bold');
			}

			if (valor_leitura >= tolerancia_minima && valor_leitura <= tolerancia_maxima) {
				$(this).addClass('text-success');
			}

			if (valor_leitura > tolerancia_maxima) {
				$(this).addClass('text-warning');
				$(this).addClass('font-weight-bold');
			}
		}
	});

	$(document).on('focusin', '.j_app_input_leitura_dimensional', function () {
		$(this).removeClass('text-success');
		$(this).removeClass('text-warning');
		$(this).removeClass('text-danger');
		$(this).removeClass('text-secondary');
		$(this).removeClass('font-weight-bold');
	});

	$(document).on('keyup', '.j_app_input_enter', function (event) {
		if (event.which == 13) {
			var generico = $(document).find('.j_app_input_enter:visible');
			var indice = generico.index(event.target) + 1;
			var seletor = $(generico[indice]).focus();

			if (seletor.length == 0) {
				event.target.focus();
			}
		}
	});

	$(document).on('focus', 'input', function (event) {
		$(this).select();
	});

	$('#j_app_btn_reenvia_email').on('click', function () {
		var confirmacao = confirm("Deseja realmente reenviar o e-mail desta inspeção?");

		if (confirmacao) {
			var url = base_url + 'inspecao/reenviar_email';
			var dados = {
				inspecao_codigo: $('#inspecao_codigo').val()
			};

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					console.log(response);

					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					exibeMensagem(response.sucesso.tipo, response.sucesso.texto);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		}
	});

	$('#j_app_btn_reabre_inspecao').on('click', function () {
		var confirmacao = confirm("Deseja realmente reabrir esta inspeção?");

		if (confirmacao) {
			var url = base_url + 'inspecao/reabrir';
			var dados = {
				inspecao_codigo: $('#inspecao_codigo').val()
			};

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: dados,
				beforeSend: function () {
					ativaCarregamento();
				},
				success: function (response) {
					if (response.erro) {
						exibeMensagem(response.erro.tipo, response.erro.texto);
					}

					if (response.resultado === true) {
						exibeMensagem(response.sucesso.tipo, response.sucesso.texto);

						$('#j_app_card_resumo_inspecao').fadeOut('fast', function () {
							carregaDadosInspecao($('#inspecao_codigo').val());

							$('#j_app_card_gerencia_inspecao').fadeIn('fast', function () {
							});
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro ao executar esta acão, tente novamente e caso o erro persista entre em contato com o administrador do sistema.');
					console.log(jqXHR, textStatus, errorThrown);

					desativaCarregamento();
				},
				complete: function (jqXHR, textStatus) {
					console.log(jqXHR, textStatus);

					desativaCarregamento();
				}
			});
		}
	});

});
