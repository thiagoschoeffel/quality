<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid py-4">
	<div class="row justify-content-center align-items-center" style="height: calc(100vh - 3rem);">
		<div class="col-10 col-sm-8 col-md-6 col-lg-4">
			<div class="card py-3">
				<div class="card-body">
					<div class="row mb-4">
						<div class="col-12">
							<img alt="Qualitá - Gestão da Qualidade" src="<?= base_url('assets/images/logo.png') ?>"
								 class="d-block mx-auto mb-4" height="26">

							<p class="text-center">Esta é uma <strong>área restrita</strong>, para acessar você primeiro
								deve informar seu usuário e senha.</p>

							<hr>

							<small class="d-block mb-1 text-center">Empresa</small>

							<img alt=""
								 src="<?= base_url('') ?>" class="d-block mx-auto"
								 width="130">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-12">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<span class="app_icon app_icon_user"></span>
									</span>
								</div>

								<input type="text" name="nome_usuario" id="nome_usuario"
									   class="form-control form-control-sm j_app_input_enter" placeholder="Usuário"
									   autocomplete="off">
							</div>
						</div>

						<div class="form-group col-12">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<span class="app_icon app_icon_key"></span>
									</span>
								</div>

								<input type="password" name="senha" id="senha"
									   class="form-control form-control-sm j_app_input_enter" placeholder="Senha"
									   autocomplete="off">
							</div>
						</div>
					</div>

					<div class="d-flex flex-column justify-content-sm-end flex-sm-row">
						<button id="j_app_btn_efetua_login" class="btn btn-sm btn-light app_btn_icon j_app_input_enter">
							<span class="app_icon app_icon_door_in"></span> Entrar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
