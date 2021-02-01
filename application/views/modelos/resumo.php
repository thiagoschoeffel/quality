<?php
defined('BASEPATH') or exit('No direct script access allowed');

$grafico_classificacao_espessura_classes = array();
$grafico_classificacao_espessura_valores = array();

$grafico_classificacao_largura_classes = array();
$grafico_classificacao_largura_valores = array();

$red = array('abaixo_menos_2', 'menos_2', 'menos_1_5', 'menos_1', 'menos_0_5');
$green = array('igual_0', 'mais_0_5', 'mais_1', 'mais_1_5', 'mais_2');
$yellow = array('acima_mais_2');

if ($classificacao['espessura'] && count($classificacao['espessura']) > 0) :
	foreach ($classificacao['espessura'] as $key => $value):
		array_push($grafico_classificacao_espessura_classes, $value['coluna']);

		if (in_array($key, $red)) {
			array_push($grafico_classificacao_espessura_valores, array("y" => $value['valor'], "color" => '#dc3545'));
		}

		if (in_array($key, $green)) {
			array_push($grafico_classificacao_espessura_valores, array("y" => $value['valor'], "color" => '#28a745'));
		}

		if (in_array($key, $yellow)) {
			array_push($grafico_classificacao_espessura_valores, array("y" => $value['valor'], "color" => '#ffc107'));
		}
	endforeach;
endif;

if ($classificacao['largura'] && count($classificacao['largura']) > 0) :
	foreach ($classificacao['largura'] as $key => $value):
		array_push($grafico_classificacao_largura_classes, $value['coluna']);

		if (in_array($key, $red)) {
			array_push($grafico_classificacao_largura_valores, array("y" => $value['valor'], "color" => '#dc3545'));
		}

		if (in_array($key, $green)) {
			array_push($grafico_classificacao_largura_valores, array("y" => $value['valor'], "color" => '#28a745'));
		}

		if (in_array($key, $yellow)) {
			array_push($grafico_classificacao_largura_valores, array("y" => $value['valor'], "color" => '#ffc107'));
		}
	endforeach;
endif;

if ($external):
?>

<div class="container-fluid py-4">
	<div class="card">
		<div class="card-body">

			<?php
			endif;
			?>

			<div class="row align-items-center mb-4">
				<div class="col-12 col-md-3 col-lg-2 mb-4 mb-md-0">
					<img alt="" title=""
						 src="<?= base_url('') ?>" class="d-block mx-auto img-fluid">
				</div>

				<div class="col-12 col-md-5 col-lg-7 mb-4 mb-md-0">
					<h4 class="mb-0 font-weight-bold text-center">Laudo da Inspeção</h4>

					<p class="mb-2 small text-center"><?= $inspecao['tipo'] ?></p>

					<div class="row">
						<div class="col-12 col-md-6">
							<p class="mb-0 small text-center">Inspetor:</p>

							<p class="mb-2 mb-0 small font-weight-bold text-center">
								<?= $inspecao['codigo_inspetor'] ?> - <?= $inspecao['nome_inspetor'] ?>
							</p>
						</div>

						<div class="col-12 col-md-6">
							<p class="mb-0 small text-center">Liberado?</p>

							<p class="mb-0 small font-weight-bold text-center">
								<?php
								if (!empty($inspecao['liberacao'])):
									if ($inspecao['liberacao'] === 'S'):
										echo "S - SIM";
									elseif ($inspecao['liberacao'] === 'N'):
										echo "N - NÃO";
									else:
										echo '';
									endif;
								else:
									echo 'Inspeção não é liberação.';
								endif;
								?>
							</p>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-4 col-lg-3 mb-0">
					<div class="card">
						<div class="card-header p-1 bg-white">
							<p class="mb-0 small text-center">Inspeção</p>
						</div>

						<div class="card-body p-1">
							<h2 class="mb-0 font-weight-bold text-center"><?= $inspecao['codigo'] ?></h2>
						</div>

						<div class="card-footer p-1 bg-white">
							<p class="mb-0 small text-center">
								<?= date('d/m/Y H:s:i', strtotime($inspecao['datahora'])) ?>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-12 col-md-6 mb-2">
					<span class="d-block small">Fornecedor:</span>
					<p class="small font-weight-bold mb-0">
						<?= $inspecao['codigo_fornecedor'] ?> - <?= $inspecao['nome_fornecedor'] ?>
					</p>
				</div>

				<div class="col-12 col-md-6 mb-2">
					<span class="d-block small">Local:</span>
					<p class="small font-weight-bold mb-0">
						<?= $inspecao['codigo_local'] ?> - <?= $inspecao['nome_local'] ?>
					</p>
				</div>

				<div class="col-12 col-md-4 mb-2">
					<span class="d-block small">Cód. Produto:</span>
					<p class="small font-weight-bold mb-0"><?= $inspecao['produto'] ?></p>
				</div>

				<div class="col-12 col-md-4 mb-2">
					<span class="d-block small">Medidas:</span>
					<p class="small font-weight-bold mb-0">
						<?= $inspecao['espessura'] ?> x <?= $inspecao['largura'] ?> x <?= $inspecao['comprimento'] ?>
					</p>
				</div>

				<div class="col-12 col-md-4 mb-2">
					<span class="d-block small">Derivação:</span>
					<p class="small font-weight-bold mb-0">
						<?= $inspecao['codigo_derivacao'] ?> - <?= $inspecao['nome_derivacao'] ?>
					</p>
				</div>

				<div class="col-12 col-md-6 mb-2">
					<span class="d-block small">Nota Fiscal:</span>
					<p class="small font-weight-bold mb-0">
						<?= (empty($inspecao['nota_fiscal'])) ? '' : $inspecao['nota_fiscal'] ?>
					</p>
				</div>

				<div class="col-12 col-md-6 mb-2">
					<span class="d-block small">Pedido:</span>
					<p class="small font-weight-bold mb-0">
						<?= (empty($inspecao['pedido'])) ? '' : $inspecao['pedido'] ?>
					</p>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-12">
					<div class="table-responsive mb-4">
						<table class="table table-sm table-striped mb-0 text-center">
							<thead class="bg-light">
							<tr>
								<th colspan="5">Leituras Dimensionais</th>
							</tr>

							<tr>
								<th>Parâmetro</th>
								<th>Amostra</th>
								<th>Ponto 1</th>
								<th>Ponto 2</th>
								<th>Ponto 3</th>
							</tr>
							</thead>
							<tbody>

							<?php
							if (count($leituras['nao_visuais']) > 0):

								foreach ($leituras['nao_visuais'] as $leitura):
									$ponto1 = '';
									$ponto2 = '';
									$ponto3 = '';

									foreach ($parametros as $parametro):
										if ($parametro['descricao'] == 'ESPESSURA' && $leitura['descricao'] == $parametro['descricao']) {
											if ($leitura['ponto_1'] > 0) {
												if ($leitura['ponto_1'] < ($inspecao['espessura'] - $parametro['tolerancia_minima'])) {
													$ponto1 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} elseif ($leitura['ponto_1'] > ($inspecao['espessura'] + $parametro['tolerancia_maxima'])) {
													$ponto1 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} else {
													$ponto1 = '<span class="text-success">' . $leitura['ponto_1'] . '</span>';
												}
											} else {
												$ponto1 = '';
											}

											if ($leitura['ponto_2'] > 0) {
												if ($leitura['ponto_2'] < ($inspecao['espessura'] - $parametro['tolerancia_minima'])) {
													$ponto2 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} elseif ($leitura['ponto_2'] > ($inspecao['espessura'] + $parametro['tolerancia_maxima'])) {
													$ponto2 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} else {
													$ponto2 = '<span class="text-success">' . $leitura['ponto_2'] . '</span>';
												}
											} else {
												$ponto2 = '';
											}

											if ($leitura['ponto_3'] > 0) {
												if ($leitura['ponto_3'] < ($inspecao['espessura'] - $parametro['tolerancia_minima'])) {
													$ponto3 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} elseif ($leitura['ponto_3'] > ($inspecao['espessura'] + $parametro['tolerancia_maxima'])) {
													$ponto3 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} else {
													$ponto3 = '<span class="text-success">' . $leitura['ponto_3'] . '</span>';
												}
											} else {
												$ponto3 = '';
											}
										}

										if ($parametro['descricao'] == 'LARGURA' && $leitura['descricao'] == $parametro['descricao']) {
											if ($leitura['ponto_1'] > 0) {
												if ($leitura['ponto_1'] < ($inspecao['largura'] - $parametro['tolerancia_minima'])) {
													$ponto1 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} elseif ($leitura['ponto_1'] > ($inspecao['largura'] + $parametro['tolerancia_maxima'])) {
													$ponto1 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} else {
													$ponto1 = '<span class="text-success">' . $leitura['ponto_1'] . '</span>';
												}
											} else {
												$ponto1 = '';
											}

											if ($leitura['ponto_2'] > 0) {
												if ($leitura['ponto_2'] < ($inspecao['largura'] - $parametro['tolerancia_minima'])) {
													$ponto2 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} elseif ($leitura['ponto_2'] > ($inspecao['largura'] + $parametro['tolerancia_maxima'])) {
													$ponto2 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} else {
													$ponto2 = '<span class="text-success">' . $leitura['ponto_2'] . '</span>';
												}
											} else {
												$ponto2 = '';
											}

											if ($leitura['ponto_3'] > 0) {
												if ($leitura['ponto_3'] < ($inspecao['largura'] - $parametro['tolerancia_minima'])) {
													$ponto3 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} elseif ($leitura['ponto_3'] > ($inspecao['largura'] + $parametro['tolerancia_maxima'])) {
													$ponto3 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} else {
													$ponto3 = '<span class="text-success">' . $leitura['ponto_3'] . '</span>';
												}
											} else {
												$ponto3 = '';
											}
										}

										if ($parametro['descricao'] == 'COMPRIMENTO' && $leitura['descricao'] == $parametro['descricao']) {
											if ($leitura['ponto_1'] > 0) {
												if ($leitura['ponto_1'] < ($inspecao['comprimento'] - $parametro['tolerancia_minima'])) {
													$ponto1 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} elseif ($leitura['ponto_1'] > ($inspecao['comprimento'] + $parametro['tolerancia_maxima'])) {
													$ponto1 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} else {
													$ponto1 = '<span class="text-success">' . $leitura['ponto_1'] . '</span>';
												}
											} else {
												$ponto1 = '';
											}

											if ($leitura['ponto_2'] > 0) {
												if ($leitura['ponto_2'] < ($inspecao['comprimento'] - $parametro['tolerancia_minima'])) {
													$ponto2 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} elseif ($leitura['ponto_2'] > ($inspecao['comprimento'] + $parametro['tolerancia_maxima'])) {
													$ponto2 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} else {
													$ponto2 = '<span class="text-success">' . $leitura['ponto_2'] . '</span>';
												}
											} else {
												$ponto2 = '';
											}

											if ($leitura['ponto_3'] > 0) {
												if ($leitura['ponto_3'] < ($inspecao['comprimento'] - $parametro['tolerancia_minima'])) {
													$ponto3 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} elseif ($leitura['ponto_3'] > ($inspecao['comprimento'] + $parametro['tolerancia_maxima'])) {
													$ponto3 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} else {
													$ponto3 = '<span class="text-success">' . $leitura['ponto_3'] . '</span>';
												}
											} else {
												$ponto3 = '';
											}
										}

										if ($parametro['descricao'] == 'UMIDADE' && $leitura['descricao'] == $parametro['descricao']) {
											if ($leitura['ponto_1'] > 0) {
												if ($leitura['ponto_1'] < $parametro['tolerancia_minima']) {
													$ponto1 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} elseif ($leitura['ponto_1'] > $parametro['tolerancia_maxima']) {
													$ponto1 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_1'] . '</span>';
												} else {
													$ponto1 = '<span class="text-success">' . $leitura['ponto_1'] . '</span>';
												}
											} else {
												$ponto1 = '';
											}

											if ($leitura['ponto_2'] > 0) {
												if ($leitura['ponto_2'] < $parametro['tolerancia_minima']) {
													$ponto2 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} elseif ($leitura['ponto_2'] > $parametro['tolerancia_maxima']) {
													$ponto2 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_2'] . '</span>';
												} else {
													$ponto2 = '<span class="text-success">' . $leitura['ponto_2'] . '</span>';
												}
											} else {
												$ponto2 = '';
											}

											if ($leitura['ponto_3'] > 0) {
												if ($leitura['ponto_3'] < $parametro['tolerancia_minima']) {
													$ponto3 = '<span class="text-danger font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} elseif ($leitura['ponto_3'] > $parametro['tolerancia_maxima']) {
													$ponto3 = '<span class="text-warning font-weight-bold">' . $leitura['ponto_3'] . '</span>';
												} else {
													$ponto3 = '<span class="text-success">' . $leitura['ponto_3'] . '</span>';
												}
											} else {
												$ponto3 = '';
											}
										}
									endforeach;
									?>

									<tr>
										<td>
											<?= $leitura['descricao'] ?>
										</td>

										<td>
											<?= $leitura['amostra'] ?>
										</td>

										<td>
											<?= $ponto1 ?>
										</td>

										<td>
											<?= $ponto2 ?>
										</td>

										<td>
											<?= $ponto3 ?>
										</td>
									</tr>

								<?php
								endforeach;
							else:
								?>

								<tr>
									<td colspan="5">Nenhuma leitura dimensional foi realizada.</td>
								</tr>

							<?php
							endif;
							?>

							</tbody>
						</table>
					</div>

					<div class="table-responsive mb-4">
						<table class="table table-sm table-striped mb-0 text-center">
							<thead class="bg-light">
							<tr>
								<th colspan="6">Visão Geral Leituras Dimensionais</th>
							</tr>

							<tr>
								<th>Parâmetro</th>
								<th>Nº Amostras</th>
								<th>Menor Leitura</th>
								<th>Maior Leitura</th>
								<th>Amplitude</th>
								<th>Média</th>
							</tr>
							</thead>

							<tbody>

							<?php
							if (count($leituras_resumo) > 0):
								foreach ($leituras_resumo as $leitura):
									?>

									<tr>
										<td>
											<?= $leitura['nome_parametro'] ?>
										</td>

										<td>
											<?= $leitura['amostras'] ?>
										</td>

										<td>
											<?= $leitura['menor_leitura'] ?>
										</td>

										<td>
											<?= $leitura['maior_leitura'] ?>
										</td>

										<td>
											<?= $leitura['amplitude'] ?>
										</td>

										<td>
											<?= $leitura['media'] ?>
										</td>
									</tr>

								<?php
								endforeach;
							else:
								?>

								<tr>
									<td colspan="6">Nenhuma leitura dimensional foi realizada.</td>
								</tr>

							<?php
							endif;
							?>

							</tbody>
						</table>
					</div>

					<div class="row">

						<?php if ($classificacao['espessura'] && count($classificacao['espessura']) > 0): ?>

							<div class="col-12 col-md-6 mb-4">
								<div class="table-responsive">
									<table class="table table-sm table-striped mb-0 text-center">
										<thead class="bg-light">
										<tr>
											<th colspan="3">Classificação Espessura</th>
										</tr>

										<tr>
											<th>Classes</th>
											<th>Quantidade</th>
											<th>%</th>
										</tr>
										</thead>

										<tbody>

										<?php
										$total = 0;

										foreach ($classificacao['espessura'] as $key => $value):
											$total += $value['valor'];
										endforeach;

										foreach ($classificacao['espessura'] as $key => $value):
											$percentual = ((empty($value['valor']) || empty($total)) ? 0 : $value['valor'] / $total) * 100;
											?>

											<tr>
												<td>
													<?= $value['coluna'] ?>
												</td>

												<td>
													<?= $value['valor'] ?>
												</td>

												<td>
													<?= number_format($percentual, 2, ',', '') ?>
												</td>
											</tr>

										<?php
										endforeach;
										?>

										</tbody>

										<tfoot class="bg-light">
										<tr>
											<th></th>

											<th>
												<?= $total ?>
											</th>

											<th>
												100
											</th>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>

						<?php
						endif;

						if ($classificacao['largura'] && count($classificacao['largura']) > 0):
							?>

							<div class="col-12 col-md-6 mb-4">
								<div class="table-responsive">
									<table class="table table-sm table-striped mb-0 text-center">
										<thead class="bg-light">
										<tr>
											<th colspan="3">Classificação Largura</th>
										</tr>

										<tr>
											<th>Classes</th>
											<th>Quantidade</th>
											<th>%</th>
										</tr>
										</thead>

										<tbody>

										<?php
										$total = 0;

										foreach ($classificacao['largura'] as $key => $value):
											$total += $value['valor'];
										endforeach;

										foreach ($classificacao['largura'] as $key => $value):
											$percentual = ((empty($value['valor']) || empty($total)) ? 0 : $value['valor'] / $total) * 100;
											?>

											<tr>
												<td>
													<?= $value['coluna'] ?>
												</td>

												<td>
													<?= $value['valor'] ?>
												</td>

												<td>
													<?= number_format($percentual, 2, ',', '') ?>
												</td>
											</tr>

										<?php
										endforeach;
										?>

										</tbody>

										<tfoot class="bg-light">
										<tr>
											<th></th>

											<th>
												<?= $total ?>
											</th>

											<th>
												100
											</th>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>

						<?php
						endif;
						?>

					</div>

					<div class="row">
						<div class="col-12">
							<div class="card mb-4">
								<div class="card-header py-1">
									<small class="d-block mb-0 text-center font-weight-bold">Gráfico Espessura</small>
								</div>

								<div class="card-body">

									<div id="grafico_espessura"
										 style="width: 100%; height: 400px; margin: 0 auto"></div>

									<script>
                                        Highcharts.chart('grafico_espessura', {
                                            chart: {
                                                type: 'column',
                                                style: {
                                                    fontFamily: "\"Nunito Sans\", sans-serif"
                                                }
                                            },
                                            title: false,
                                            legend: false,
                                            xAxis: {
                                                categories: <?= json_encode($grafico_classificacao_espessura_classes) ?>,
                                                crosshair: true
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Quantidade (un)'
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                pointFormat: '<tr><td style="color:{series.color};padding:0">Qtd.: </td>' +
                                                    '<td style="padding:0">&nbsp;<b>{point.y:.0f} un</b></td></tr>',
                                                footerFormat: '</table>',
                                                shared: true,
                                                useHTML: true
                                            },
                                            plotOptions: {
                                                column: {
                                                    pointPadding: 0.1,
                                                    borderWidth: 0
                                                }
                                            },
                                            series: [{
                                                name: 'Classes',
                                                data: <?= json_encode($grafico_classificacao_espessura_valores) ?>
                                            }]
                                        });
									</script>

									<small class="d-block mb-0 text-center font-weight-bold mb-2">Legenda</small>

									<div class="d-flex flex-column flex-md-row justify-content-center">
										<span class="badge badge-danger">Abaixo da Tolerância</span>
										<span class="badge badge-success">Dentro da Tolerância</span>
										<span class="badge badge-warning">Acima da Tolerância</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card mb-4">
								<div class="card-header py-1">
									<small class="d-block mb-0 text-center font-weight-bold">Gráfico Largura</small>
								</div>

								<div class="card-body">
									<div id="grafico_largura" style="width: 100%; height: 400px; margin: 0 auto"></div>

									<script>
                                        Highcharts.chart('grafico_largura', {
                                            chart: {
                                                type: 'column',
                                                style: {
                                                    fontFamily: "\"Nunito Sans\", sans-serif"
                                                }
                                            },
                                            title: false,
                                            legend: false,
                                            xAxis: {
                                                categories: <?= json_encode($grafico_classificacao_largura_classes) ?>,
                                                crosshair: true
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Quantidade (un)'
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                pointFormat: '<tr><td style="color:{series.color};padding:0">Qtd.: </td>' +
                                                    '<td style="padding:0">&nbsp;<b>{point.y:.0f} un</b></td></tr>',
                                                footerFormat: '</table>',
                                                shared: true,
                                                useHTML: true
                                            },
                                            plotOptions: {
                                                column: {
                                                    pointPadding: 0.1,
                                                    borderWidth: 0
                                                }
                                            },
                                            series: [{
                                                name: 'Classes',
                                                data: <?= json_encode($grafico_classificacao_largura_valores) ?>
                                            }]
                                        });
									</script>

									<small class="d-block mb-0 text-center font-weight-bold mb-2">Legenda</small>

									<div class="d-flex flex-column flex-md-row justify-content-center">
										<span class="badge badge-danger">Abaixo da Tolerância</span>
										<span class="badge badge-success">Dentro da Tolerância</span>
										<span class="badge badge-warning">Acima da Tolerância</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table id="" class="table table-sm table-striped mb-0 text-center">
							<thead class="bg-light">
							<tr>
								<th colspan="4">Leituras Visuais</th>
							</tr>
							<tr>
								<th>Parâmetro</th>
								<th>Amostras</th>
								<th>Defeitos</th>
								<th>% Defeitos</th>
							</tr>
							</thead>

							<tbody>

							<?php
							if (count($leituras['visuais']) > 0):
								foreach ($leituras['visuais'] as $leitura):
									?>

									<tr>
										<td>
											<?= $leitura['descricao'] ?>
										</td>

										<td>
											<?= $leitura['amostras'] ?>
										</td>

										<td>
											<?= $leitura['valor'] ?>
										</td>

										<td>
											<?= $leitura['porcentagem_defeitos'] ?>
										</td>
									</tr>

								<?php
								endforeach;
							else:
								?>

								<tr>
									<td colspan="4">Nenhuma leitura visual foi realizada.</td>
								</tr>

							<?php
							endif;
							?>

							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-12">
					<span class="d-block small">Observação:</span>
					<p class="small font-weight-bold mb-0"><?= nl2br($inspecao['observacao']) ?></p>
				</div>
			</div>

			<div class="row mb-4">

				<?php
				if (count($imagens) > 0):
					foreach ($imagens as $imagem):
						?>

						<div class="col-12 col-sm-4 col-md-3 col-lg-2">
							<div class="card border-0">
								<div class="card-body p-1 text-center">
									<a href="<?= base_url($imagem['imagem']) ?>" target="_blank">
										<img src="<?= base_url($imagem['imagem']) ?>" class="img-thumbnail mb-2">
									</a>
								</div>
							</div>
						</div>

					<?php
					endforeach;
				endif;
				?>

			</div>

			<?php
			if ($external):
			?>

		</div>
	</div>
</div>

<?php
endif;
?>
