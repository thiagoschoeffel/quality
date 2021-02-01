<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-12">
		<div id="j_app_card_cria_inspecao" class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h5 class="mb-2">
							<span class="app_icon app_icon_page_white_add"></span> Nova Inspeção
						</h5>
					</div>
				</div>

				<hr class="my-2">

				<div class="form-row">
					<div class="form-group col-12 col-sm-3">
						<label for="inspecao_codigo_fornecedor">Cód. Fornecedor</label>
						<input type="number" name="inspecao_codigo_fornecedor" id="inspecao_codigo_fornecedor"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-9">
						<label for="inspecao_nome_fornecedor">Nome Fornecedor</label>
						<input type="text" name="inspecao_nome_fornecedor" id="inspecao_nome_fornecedor"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-3">
						<label for="inspecao_codigo_local">Cód. Local</label>
						<input type="number" name="inspecao_codigo_local" id="inspecao_codigo_local"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-9">
						<label for="inspecao_nome_local">Nome Local</label>
						<input type="text" name="inspecao_nome_local" id="inspecao_nome_local"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-3">
						<label for="inspecao_codigo_derivacao">Derivação</label>
						<select name="inspecao_codigo_derivacao" id="inspecao_codigo_derivacao"
								class="form-control form-control-sm">
							<option value=""></option>
							<?php
							foreach ($derivacoes as $derivacao) :
								echo '<option value="' . $derivacao['codigo'] . '">' . $derivacao['descricao'] . '</option>';
							endforeach;
							?>
						</select>
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="inspecao_produto_espessura">Esp.</label>
						<input type="number" name="inspecao_produto_espessura" id="inspecao_produto_espessura"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="inspecao_produto_largura">Larg.</label>
						<input type="number" name="inspecao_produto_largura" id="inspecao_produto_largura"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="inspecao_produto_comprimento">Comp.</label>
						<input type="number" name="inspecao_produto_comprimento" id="inspecao_produto_comprimento"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-2">
						<label for="inspecao_nota_fiscal">NF</label>
						<input type="number" name="inspecao_nota_fiscal" id="inspecao_nota_fiscal"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-2">
						<label for="inspecao_pedido">Pedido</label>
						<input type="number" name="inspecao_pedido" id="inspecao_pedido"
							   class="form-control form-control-sm j_app_input_enter" autocomplete="off">
					</div>

					<div class="form-group col-12 col-sm-6 col-lg-2">
						<label for="inspecao_tipo">Tipo Inspeção</label>
						<select name="inspecao_tipo" id="inspecao_tipo" class="form-control form-control-sm">
							<option value="ROTINA">ROTINA</option>
							<option value="LIBERAÇÃO">LIBERAÇÃO</option>
						</select>
					</div>

					<div class="col-12">
						<div id="j_app_lista_autocompletar1" class="list-group"></div>

						<div id="j_app_lista_autocompletar2" class="list-group"></div>
					</div>
				</div>

				<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
					<button id="j_app_btn_cria_inspecao" class="btn btn-sm btn-light app_btn_icon j_app_input_enter">
						<span class="app_icon app_icon_add"></span> Criar Inspeção
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div id="j_app_card_gerencia_inspecao" class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h5 class="mb-2">
							<span class="app_icon app_icon_page_white_edit"></span> Editar Inspeção
						</h5>
					</div>
				</div>

				<hr class="my-2">

				<div class="form-row">
					<div class="form-group col-12 col-sm-2 col-lg-1">
						<label for="inspecao_codigo">Inspeção</label>
						<input type="number" name="inspecao_codigo" id="inspecao_codigo"
							   class="form-control form-control-sm j_app_input_enter">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-2">
						<label for="parametro_tipo">Tipo Leitura</label>
						<select name="parametro_tipo" id="parametro_tipo" class="form-control form-control-sm">
							<option value=""></option>
							<option value="D">DIMENSIONAL</option>
							<option value="V">VISUAL</option>
						</select>
					</div>

					<div class="form-group col-12 col-sm-5 col-lg-3">
						<label for="parametro_codigo">Parâmetro</label>
						<select name="parametro_codigo" id="parametro_codigo"
								class="form-control form-control-sm"></select>
					</div>

					<div class="form-group col-12 col-sm-2 col-lg-2">
						<label for="parametro_amostras">Nº Amostras</label>
						<input type="number" name="parametro_amostras" id="parametro_amostras"
							   class="form-control form-control-sm j_app_input_enter">
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="parametro_pontos">Ptos.</label>
						<input type="number" name="parametro_pontos" id="parametro_pontos"
							   class="form-control form-control-sm" disabled>
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="parametro_tolerancia_minima">Tol. Min.</label>
						<input type="number" name="parametro_tolerancia_minima" id="parametro_tolerancia_minima"
							   class="form-control form-control-sm" disabled>
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="parametro_valor_nominal">Val. Nom.</label>
						<input type="number" name="parametro_valor_nominal" id="parametro_valor_nominal"
							   class="form-control form-control-sm" disabled>
					</div>

					<div class="form-group col-12 col-sm-3 col-lg-1">
						<label for="parametro_tolerancia_maxima">Tol. Máx.</label>
						<input type="number" name="parametro_tolerancia_maxima" id="parametro_tolerancia_maxima"
							   class="form-control form-control-sm" disabled>
					</div>

					<input type="hidden" name="parametro_produto_espessura" id="parametro_produto_espessura" value="0">
					<input type="hidden" name="parametro_produto_largura" id="parametro_produto_largura" value="0">
					<input type="hidden" name="parametro_produto_comprimento" id="parametro_produto_comprimento"
						   value="0">
				</div>

				<div class="d-flex justify-content-sm-end flex-column flex-sm-row mb-2">
					<button id="j_app_btn_cria_leitura" class="btn btn-sm btn-light app_btn_icon j_app_input_enter">
						<span class="app_icon app_icon_ruler"></span> Realizar Leitura
					</button>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="card mb-2">
							<div class="card-header py-1 px-2">
								<span class="small font-weight-bold">Resumo da Inspeção</span>
							</div>

							<div class="card-body py-1 px-2">
								<div class="row mb-2">
									<div class="col-12 col-md-4 mb-1">
										<span class="d-block small">Data/Hora Geração:</span>
										<p id="j_app_texto_inspecao_datahora" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-4 mb-1">
										<span class="d-block small">Inspetor:</span>
										<p id="j_app_texto_inspecao_inspetor" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-4 mb-1">
										<span class="d-block small">Tipo Inspeção:</span>
										<p id="j_app_texto_inspecao_tipo" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-6 mb-1">
										<span class="d-block small">Fornecedor:</span>
										<p id="j_app_texto_inspecao_fornecedor" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-6 mb-1">
										<span class="d-block small">Local:</span>
										<p id="j_app_texto_inspecao_local" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-4 mb-1">
										<span class="d-block small">Cód. Produto:</span>
										<p id="j_app_texto_inspecao_produto" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-4 mb-1">
										<span class="d-block small">Medidas:</span>
										<p id="j_app_texto_inspecao_medidas" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-4 mb-1">
										<span class="d-block small">Derivação:</span>
										<p id="j_app_texto_inspecao_derivacao" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-6 mb-1">
										<span class="d-block small">Nota Fiscal:</span>
										<p id="j_app_texto_inspecao_nota_fiscal"
										   class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12 col-md-6 mb-1">
										<span class="d-block small">Pedido:</span>
										<p id="j_app_texto_inspecao_pedido" class="small font-weight-bold mb-0"></p>
									</div>

									<div class="col-12">
										<span class="d-block small">Observação:</span>
										<p id="j_app_texto_inspecao_observacao" class="small font-weight-bold mb-0"></p>
									</div>
								</div>

								<div class="row">
									<div class="col-12">
										<div class="table-responsive mb-2">
											<table id="j_app_tabela_resumo_inspecao_leituras_dimensionais"
												   class="table table-sm table-striped mb-0 text-center">
												<thead class="bg-light">
												<tr>
													<th colspan="7">Leituras Dimensionais</th>
												</tr>

												<tr>
													<th></th>
													<th>Parâmetro</th>
													<th>Nº Amostras</th>
													<th>Menor Leitura</th>
													<th>Maior Leitura</th>
													<th>Amplitude</th>
													<th>Média</th>
												</tr>

												</thead>

												<tbody>
												</tbody>
											</table>
										</div>

										<div class="table-responsive">
											<table id="j_app_tabela_resumo_inspecao_leituras_visuais"
												   class="table table-sm table-striped mb-0 text-center">
												<thead class="bg-light">
												<tr>
													<th colspan="5">Leituras Visuais</th>
												</tr>

												<tr>
													<th></th>
													<th>Parâmetro</th>
													<th>Nº Amostras</th>
													<th>Defeitos</th>
													<th>% Defeitos</th>
												</tr>
												</thead>

												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
					<button id="j_app_btn_abre_card_finaliza_inspecao"
							class="btn btn-sm btn-light app_btn_icon mb-2 mb-sm-0 mr-sm-2">
						<span class="app_icon app_icon_accept_button"></span> Finalizar Inspeção
					</button>

					<button id="j_app_btn_cancela_inspecao" class="btn btn-sm btn-light app_btn_icon">
						<span class="app_icon app_icon_cancel"></span> Cancelar Inspeção
					</button>

					<!-- <button id="j_app_btn_abre_modal_deleta_inspecao" class="btn btn-sm btn-danger app_btn_icon">
						<span class="app_icon app_icon_delete"></span> Deletar Inspeção
					</button> -->
				</div>
			</div>
		</div>
	</div>
</div>

<div id="j_app_card_leitura_dimensional" class="row" style="display: none;">
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h5 class="mb-2">
							<span class="app_icon app_icon_ruler"></span> Leituras Dimensionais
						</h5>
					</div>
				</div>

				<hr class="my-2">

				<div class="table-responsive">
					<table id="j_app_tabela_leitura_dimensional" class="table table-sm table-striped mb-2 text-center">
					</table>
				</div>

				<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
					<button id="j_app_btn_finaliza_leitura_dimensional"
							class="btn btn-sm btn-light app_btn_icon mb-2 mb-sm-0 mr-sm-2 j_app_input_enter">
						<span class="app_icon app_icon_accept_button"></span> Finalizar Leitura
					</button>

					<button id="j_app_btn_cancela_leitura_dimensional" class="btn btn-sm btn-light app_btn_icon">
						<span class="app_icon app_icon_cancel"></span> Cancelar Leitura
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="j_app_card_leitura_visual" class="row" style="display: none;">
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h5 class="mb-2">
							<span class="app_icon app_icon_ruler"></span> Leituras Visuais
						</h5>
					</div>
				</div>

				<hr class="my-2">

				<div class="table-responsive">
					<table id="j_app_tabela_leitura_visual" class="table table-sm table-striped mb-2 text-center">
					</table>
				</div>

				<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
					<button id="j_app_btn_finaliza_leitura_visual"
							class="btn btn-sm btn-light app_btn_icon mb-2 mb-sm-0 mr-sm-2 j_app_input_enter">
						<span class="app_icon app_icon_accept_button"></span> Finalizar Leitura
					</button>

					<button id="j_app_btn_cancela_leitura_visual" class="btn btn-sm btn-light app_btn_icon">
						<span class="app_icon app_icon_cancel"></span> Cancelar Leitura
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="j_app_card_finaliza_inspecao" class="row" style="display: none;">
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h5 class="mb-2">
							<span class="app_icon app_icon_page_white_go"></span> Finalizar Inspeção
						</h5>
					</div>
				</div>

				<hr class="my-2">

				<div class="form-row">
					<div class="form-group col-12">
						<label for="observacao">Observações</label>
						<textarea name="observacao" id="observacao" rows="10"
								  class="form-control form-control-sm"></textarea>
					</div>

					<div class="form-group col-12">
						<label for="imagens">Imagens</label>

						<div class="custom-file">
							<input type="file" name="imagens" id="imagens" class="custom-file-input" lang="pt-br"
								   multiple>
							<label for="imagens" class="custom-file-label">Escolha as imagens que deseja enviar!</label>
						</div>
					</div>
				</div>

				<div id="j_app_imagens_upload" class="row mb-2"></div>

				<div id="j_app_div_libera_inspecao" class="row" style="display: none;">
					<div class="form-group col-12">
						<label for="">Liberdado?</label>

						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" name="liberacao" id="liberacao_sim" class="custom-control-input"
										   value="S">
									<label for="liberacao_sim" class="custom-control-label">Sim</label>
								</div>

								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" name="liberacao" id="liberacao_nao" class="custom-control-input"
										   value="N">
									<label for="liberacao_nao" class="custom-control-label">Não</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
					<button id="j_app_btn_finaliza_inspecao"
							class="btn btn-sm btn-light app_btn_icon mb-2 mb-sm-0 mr-sm-2">
						<span class="app_icon app_icon_diskette"></span> Salvar Inspeção
					</button>

					<button id="j_app_btn_volta_finaliza_inspecao" class="btn btn-sm btn-light app_btn_icon">
						<span class="app_icon app_icon_arrow_undo"></span> Voltar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="j_app_card_resumo_inspecao" class="row" style="display: none;">
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h5 class="mb-0">
							<span class="app_icon app_icon_page_white_find"></span> Resumo da Inspeção
						</h5>
					</div>
				</div>

				<hr class="my-4">

				<div id="j_app_div_resumo_inspecao" class="mb-2"></div>

				<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
					<button id="j_app_btn_reabre_inspecao"
							class="btn btn-sm btn-light app_btn_icon mb-2 mb-sm-0 mr-sm-2">
						<span class="app_icon app_icon_arrow_rotate_clockwise"></span> Reabrir
					</button>

					<button id="j_app_btn_reenvia_email" class="btn btn-sm btn-light app_btn_icon mb-2 mb-sm-0 mr-sm-2">
						<span class="app_icon app_icon_email_go"></span> Reenviar E-Mail
					</button>

					<button id="j_app_btn_fecha_resumo_inspecao" class="btn btn-sm btn-light app_btn_icon">
						<span class="app_icon app_icon_cancel"></span> Fechar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
