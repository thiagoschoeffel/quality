<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="navbar navbar-expand-md navbar-light bg-white sticky-top border-bottom">
	<div class="container-fluid">
		<a href="<?= base_url('') ?>" class="navbar-brand mr-0 mr-md-4">
			<img alt="Qualitá - Gestão da Qualidade" src="<?= base_url('assets/images/logo.png') ?>" height="26">
		</a>

		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#j_app_menu">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="j_app_menu">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="<?= base_url('inspecao') ?>" class="nav-link app_btn_icon">
						<span class="app_icon app_icon_to_do_list"></span> Nova Inspeção
					</a>
				</li>
			</ul>

			<span class="navbar-text app_btn_icon mr-0 mr-md-4">
				<span class="app_icon app_icon_user"></span>
				<?= ucwords(strtolower($this->session->userdata('usuario_logado')['nome'])) ?>
			</span>

			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a href="#" id="navbarDropdown" class="nav-link dropdown-toggle app_btn_icon"
					   data-toggle="dropdown">
						<span class="app_icon app_icon_cog"></span> Opções
					</a>

					<div class="dropdown-menu dropdown-menu-right">
<!--						<a href="#" class="dropdown-item app_btn_icon">-->
<!--							<span class="app_icon app_icon_group"></span> Gerenciar Usuários-->
<!--						</a>-->
<!---->
<!--						<a href="#" class="dropdown-item app_btn_icon">-->
<!--							<span class="app_icon app_icon_help"></span> Ajuda-->
<!--						</a>-->

<!--						<div class="dropdown-divider"></div>-->

						<a href="<?= base_url('login/sair') ?>" class="dropdown-item app_btn_icon">
							<span class="app_icon app_icon_door_out"></span> Sair
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="container-fluid py-4">
