<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no">

	<link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
	<link rel="stylesheet" href="<?= base_url('node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

	<title>Qualitá - Gestão da Qualidade</title>

	<meta name="robots" content="noindex, nofollow">

	<link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

	<script src="<?= base_url('node_modules/jquery/dist/jquery.min.js') ?>"></script>
	<script src="<?= base_url('node_modules/popper.js/dist/umd/popper.min.js') ?>"></script>
	<script src="<?= base_url('node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('node_modules/jquery-mask-plugin/dist/jquery.mask.min.js') ?>"></script>
	<script src="<?= base_url('node_modules/moment/moment.js') ?>"></script>
	<script src="<?= base_url('node_modules/highcharts/highcharts.js') ?>"></script>

	<script>
        var base_url = "<?= base_url(); ?>";
	</script>

	<script src="<?= base_url('assets/js/script.js') ?>"></script>
</head>

<body>

<div class="app_carregamento j_app_carregamento">
	<div
		class="app_carregamento_conteudo d-flex flex-column justify-content-center align-items-center rounded-sm shadow-sm">
		<div class="app_carregamento_conteudo_icone">
			<div></div>
			<div></div>
		</div>

		<h5 class="mb-0">Processando</h5>
	</div>
</div>

<div class="app_mensagem j_app_mensagem"></div>
