<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">

	<title>Laudo Inspeção <?= $inspecao['codigo'] ?> | <?= $inspecao['nome_fornecedor'] ?></title>

	<style>
		body {
			padding: 10px;
			background-color: #fff;
			font-family: 'Arial', sans-serif;
			color: #333;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		p {
			margin: 0;
		}

		h1 {
			font-size: 30px;
		}

		h2 {
			font-size: 24px;
		}

		h3 {
			font-size: 18px;
		}

		h4 {
			font-size: 16px;
		}

		h5 {
			font-size: 14px;
		}

		h6 {
			font-size: 12px;
		}

		table {
			border-collapse: collapse;
		}

		a {
			text-decoration: none;
			color: #000;
		}

		a img {
			border: 0;
		}
	</style>
</head>

<body>

<table width="1000" border="0" align="center">
	<tr>
		<td width="250" align="left">
			<img alt="" title=""
				 src="<?= base_url('') ?>" width="180">
		</td>

		<td align="center">
			<h2 style="margin-bottom: 0;"><b>Resumo Inspeção</b></h2>
			<p style="margin-bottom: 0; font-size: 12px;">
				<?= $inspecao['tipo'] ?>
			</p>

			<br>

			<table width="400" border="0" align="center">
				<tr>
					<td align="center">
						<h5 style="margin-bottom: 0;"><b>Inspetor</b></h5>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['codigo_inspetor'] ?>
							-
							<?= $inspecao['nome_inspetor'] ?>
						</p>
					</td>

					<td align="center">
						<h5 style="margin-bottom: 0;"><b>Liberado?</b></h5>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?php
							if (!empty($inspecao['liberacao'])) :
								if ($inspecao['liberacao'] === 'S') :
									echo "S - SIM";
								elseif ($inspecao['liberacao'] === 'N') :
									echo "N - NÃO";
								else:
									echo '';
								endif;
							else:
								echo 'Inspeção não é liberação.';
							endif;
							?>
						</p>
					</td>
				</tr>
			</table>
		</td>

		<td align="right">
			<table width="250" align="right" style="border: 2px solid #ccc">
				<tr>
					<td align="center" style="border-bottom: 1px solid #ccc">
						<p style="margin-bottom: 0; font-size: 12px;">
							<b>Inspeção</b>
						</p>
					</td>
				</tr>

				<tr>
					<td align="center">
						<h1 style="margin-bottom: 0;">
							<b><?= $inspecao['codigo'] ?></b>
						</h1>
					</td>
				</tr>

				<tr>
					<td align="center">
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= date('d/m/Y H:i:s', strtotime($inspecao['datahora'])) ?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>

<table width="1000" border="0" align="center">
	<tr>
		<td>
			<table width="995" border="0" align="center" style="border: 1px solid #ddd;">
				<tr>
					<td align="center" bgcolor="#ddd" colspan="3"
						style="padding: 5px; background-color: #eee; border-bottom: 2px solid #ddd;">
						<h5 style="margin-bottom: 0;"><b>Dados Gerais</b></h5>
					</td>
				</tr>

				<tr>
					<td style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Fornecedor:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['codigo_fornecedor'] ?>
							-
							<?= $inspecao['nome_fornecedor'] ?>
						</p>
					</td>

					<td colspan="2" style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Local:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['codigo_local'] ?>
							-
							<?= $inspecao['nome_local'] ?>
						</p>
					</td>
				</tr>

				<tr>
					<td style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Produto:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['produto'] ?>
						</p>
					</td>

					<td style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Medidas:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['espessura'] ?>
							x
							<?= $inspecao['largura'] ?>
							x
							<?= $inspecao['comprimento'] ?>
						</p>
					</td>

					<td style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Derivação:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['codigo_derivacao'] ?>
							-
							<?= $inspecao['nome_derivacao'] ?>
						</p>
					</td>
				</tr>

				<tr>
					<td style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Nota Fiscal:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= (empty($inspecao['nota_fiscal'])) ? 'NÃO INFORMADO' : $inspecao['nota_fiscal'] ?>
						</p>
					</td>

					<td colspan="2" style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Pedido:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= (empty($inspecao['pedido'])) ? 'NÃO INFORMADO' : $inspecao['pedido'] ?>
						</p>
					</td>
				</tr>

				<tr>
					<td colspan="3" style="padding: 5px;">
						<h6 style="margin-bottom: 0;"><b>Observação:</b></h6>
						<p style="margin-bottom: 0; font-size: 12px;">
							<?= $inspecao['observacao'] ?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>

<table width="1000" border="0" align="center">
	<tr>
		<?php
		if ($classificacao['espessura'] && count($classificacao['espessura']) > 0):
			?>

			<td align="left" width="300">
				<table width="290" border="0" align="left" style="border: 1px solid #ddd">
					<tr>
						<td align="center" bgcolor="#ddd" colspan="3"
							style="padding: 5px; background-color: #eee; border-bottom: 2px solid #ddd;">
							<h5 style="margin-bottom: 0;"><b>Classes Espessura</b></h5>
						</td>
					</tr>

					<tr>
						<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;"><b>Classe</b></h6>
						</td>

						<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;"><b>Qtd.</b></h6>
						</td>

						<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;"><b>%</b></h6>
						</td>
					</tr>

					<?php
					$total = 0;

					foreach ($classificacao['espessura'] as $key => $value):
						$total += $value['valor'];
					endforeach;

					foreach ($classificacao['espessura'] as $key => $value):
						$percentual = ((empty($value['valor']) || empty($total)) ? 0 : $value['valor'] / $total) * 100;
						?>

						<tr>
							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $value['coluna'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $value['valor'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= number_format($percentual, 2, ',', '') ?>
								</p>
							</td>
						</tr>

					<?php
					endforeach;
					?>

					<tr>
						<td align="center" style="padding: 5px; border-top: 1px solid #ddd;"></td>

						<td align="center" style="padding: 5px; border-top: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;">
								<b><?= $total ?></b>
							</h6>
						</td>

						<td align="center" style="padding: 5px; border-top: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;">
								<b>100</b>
							</h6>
						</td>
					</tr>
				</table>
			</td>

		<?php
		endif;
		?>

		<?php
		if ($classificacao['largura'] && count($classificacao['largura']) > 0):
			?>

			<td align="center" width="300">
				<table width="290" border="0" align="center" style="border: 1px solid #ddd">
					<tr>
						<td align="center" bgcolor="#ddd" colspan="3"
							style="padding: 5px; background-color: #eee; border-bottom: 2px solid #ddd;">
							<h5 style="margin-bottom: 0;"><b>Classes Largura</b></h5>
						</td>
					</tr>

					<tr>
						<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;"><b>Classe</b></h6>
						</td>

						<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;"><b>Qtd.</b></h6>
						</td>

						<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;"><b>%</b></h6>
						</td>
					</tr>

					<?php
					$total = 0;

					foreach ($classificacao['largura'] as $key => $value):
						$total += $value['valor'];
					endforeach;

					foreach ($classificacao['largura'] as $key => $value):
						$percentual = ((empty($value['valor']) || empty($total)) ? 0 : $value['valor'] / $total) * 100;
						?>

						<tr>
							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $value['coluna'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $value['valor'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= number_format($percentual, 2, ',', '') ?>
								</p>
							</td>
						</tr>

					<?php
					endforeach;
					?>

					<tr style="border-top: 1px solid #ddd">
						<td align="center" style="padding: 5px; border-top: 1px solid #ddd;"></td>

						<td align="center" style="padding: 5px; border-top: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;">
								<b><?= $total ?></b>
							</h6>
						</td>

						<td align="center" style="padding: 5px; border-top: 1px solid #ddd;">
							<h6 style="margin-bottom: 0;">
								<b>100</b>
							</h6>
						</td>
					</tr>
				</table>
			</td>

		<?php
		endif;
		?>

		<td align="right" width="400" style="vertical-align: top;">
			<table width="390" border="0" align="right" style="border: 1px solid #ddd">
				<tr>
					<td align="center" bgcolor="#ddd" colspan="4"
						style="padding: 5px; background-color: #eee; border-bottom: 2px solid #ddd;">
						<h5 style="margin-bottom: 0;"><b>Resumo Leituras Visuais</b></h5>
					</td>
				</tr>

				<tr>
					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Parâmetro</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Nº Amo.</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Nº Def.</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>%</b></h6>
					</td>
				</tr>

				<?php
				if (count($leituras['visuais']) > 0) :
					foreach ($leituras['visuais'] as $leitura) :
						?>

						<tr>
							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['descricao'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['amostras'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['valor'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['porcentagem_defeitos'] ?>
								</p>
							</td>
						</tr>

					<?php
					endforeach;
				else:
					?>

					<tr>
						<td align="center" colspan="4" style="padding: 5px;">
							<p style="margin-bottom: 0; font-size: 12px;">
								Nenhuma leitura visual foi realizada.
							</p>
						</td>
					</tr>

				<?php
				endif;
				?>
			</table>

			<br>

			<table width="390" border="0" align="right" style="border: 1px solid #ddd">
				<tr>
					<td align="center" bgcolor="#ddd"
						style="padding: 5px; background-color: #eee; border-bottom: 2px solid #ddd;">
						<h5 style="margin-bottom: 0;"><b>Imagens</b></h5>
					</td>
				</tr>

				<tr>
					<td align="center" style="padding: 5px;">
						<?php
						if (count($imagens) > 0) :
							$i = 1;
							foreach ($imagens as $imagem) :
								?>

								<a href="<?= base_url($imagem['imagem']) ?>">
									&nbsp;<img src="<?= base_url($imagem['imagem']) ?>" width="65"
											   style="padding: 5px;">
								</a>

								<?php
								if (($i % 4) == 0) :
									echo "<br>";
								else :
									echo "&nbsp;";
								endif;
								$i++;
							endforeach;
						endif;
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>

<table width="1000" border="0" align="center">
	<tr>
		<td>
			<table width="995" border="0" align="center" style="border: 1px solid #ddd;">
				<tr>
					<td align="center" bgcolor="#ddd" colspan="6"
						style="padding: 5px; background-color: #eee; border-bottom: 2px solid #ddd;">
						<h5 style="margin-bottom: 0;"><b>Resumo Leituras Dimensionais</b></h5>
					</td>
				</tr>

				<tr>
					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Parâmetro</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Nº Amostras</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Menor Leitura</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Maior Leitura</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Amplitude</b></h6>
					</td>

					<td align="center" style="padding: 5px; border-bottom: 1px solid #ddd;">
						<h6 style="margin-bottom: 0;"><b>Média</b></h6>
					</td>
				</tr>

				<?php
				if (count($leituras_resumo) > 0) :
					foreach ($leituras_resumo as $leitura) :
						?>

						<tr>
							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['nome_parametro'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['amostras'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['menor_leitura'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['maior_leitura'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['amplitude'] ?>
								</p>
							</td>

							<td align="center" style="padding: 5px;">
								<p style="margin-bottom: 0; font-size: 12px;">
									<?= $leitura['media'] ?>
								</p>
							</td>
						</tr>

					<?php
					endforeach;
				else:
					?>

					<tr>
						<td align="center" colspan="6" style="padding: 5px;">
							<p style="margin-bottom: 0; font-size: 12px;">
								Nenhuma leitura dimensional foi realizada.
							</p>
						</td>
					</tr>

				<?php
				endif;
				?>
			</table>
		</td>
	</tr>
</table>

<br>

<table width="1000" border="0" align="center">
	<tr>
		<td>
			<table width="995" border="0" align="center">
				<tr>
					<td style="padding: 5px;">
						<p style="text-align: center;"> Para visualizar mais detalhes desta insepção você pode
							<a href="<?= base_url('laudo/' . $inspecao['codigo']) ?>" style="color: #000">
								<b>Clicar Aqui!</b>
							</a>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>

</html>
