 			
	  				<div class="col-md-9">
	  					<div class="content-box-large">
						  <div class="panel-heading">
							<div class="col-md-7">
							  <a href="?action=usuario"><-- Voltar</a>
							</div>
						  </div>
						  <?php
								$edit = false;
								if ( isset( $_GET['edit'] ) ){
									$act = 'atualiza';
								}
								if ( isset( $_GET['novo'] ) ){
									$act = 'incluir';
								}
								echo '<input id="act" name="act" type="hidden" value="'.$act.'">';
							?>
						  
			  				<div class="panel-heading">
					            <center><h4>Dados do Usuário</h4>
								<div class="panel-title"><?php echo (isset($key))?getNomeUsuario($key):'Novo Usuário'; ?></div></center>
					        </div>					
			  				<form method="post" class="form-horizontal" role="form" data-toggle="validator" id="form_dados_usuario" name="form_dados_usuario" action="">
						  			
			  				<div class="panel-body">
						  
							<?php
								$edit = false;
								global $db;
								if ( isset( $_GET['edit'] ) ){
									$db=new ConnectionMysql();								
									$sql = " 
										SELECT
											*
										FROM usuarios WHERE usr_cod = $key "; 
									$query = $db->query($sql);
									$objUsuario = $query->fetch(PDO::FETCH_OBJ);
									if ( $db->rowCount() >= 1 )
									{	
										$edit = true;
										$user_id = $objUsuario->usr_cod;
										echo '<input id="id" name="id" type="hidden" value="'.$user_id.'">';
										
									}
								}
                            ?>
								  <div class="form-group">
								    <label for="user_nome" class="col-md-2 control-label">Nome</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" id="user_nome" name="user_nome" placeholder="Nome" value="<?php echo ($edit)?$objUsuario->usr_nome:''; ?>" 
											 data-error="Campo não pode ser vazio." required>
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <div class="form-group">
								    <label for="user_email" class="col-md-2 control-label">E-Mail</label>
								    <div class="col-md-10">
								      <input type="email" class="form-control" name="user_email" id="user_email" placeholder="E-Mail" value="<?php echo ($edit)?$objUsuario->usr_email:''; ?>"  autocomplete="off" required>
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <div class="form-group">
								    <label for="user_login" class="col-md-2 control-label">Login</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" name="user_login" id="user_login" placeholder="Login" value="<?php echo ($edit)?$objUsuario->usr_login:''; ?>"  autocomplete="off" required>
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <div class="form-group">
								    <label for="user_password" class="col-md-2 control-label">Senha</label>
								    <div class="col-md-2">
								      <input 
										type="password" 
										class="form-control" 
										id="user_password" 
										name="user_password" 
										value="<?php echo ($edit)?$objUsuario->usr_password:'';?>"  
										data-minlength="5"
										data-minlength-error="Mínimo de seis (5) digitos."  
										required
									  >
									  <span class="help-block with-errors">Mínimo de seis (5) digitos</span>
									  <input id="senha_antiga" name="senha_antiga" type="hidden" value="<?php echo ($edit)?$objUsuario->usr_password:'';?>">
								    </div>
								    <div class="col-md-2">
								      <input 
										type="password" 
										class="form-control" 
										id="user_senha_2" 
										name="user_senha_2" 
										value="<?php echo ($edit)?$objUsuario->usr_password:'';?>"
										data-match="#user_password"
										data-minlength="5"
										data-match-error="Atenção! As senhas não estão iguais."
										data-minlength-error="Mínimo de seis (5) digitos." 
										required
									  >
									  <div class="help-block with-errors"></div>
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="user_nivel" class="col-md-2 control-label">Nível</label>
								    <div class="col-md-10">
								      <select id="user_nivel" class="form-control" name="user_nivel" required>
														<?php
															global $NomeNivel;
															unset($NomeNivel[	NIVEL_VISITANTE		]);
															unset($NomeNivel[	NIVEL_EMPRESA		]);
															foreach($NomeNivel as $k => $nivel) {
																echo "<option value='{$k}'>{$nivel}</option>";
															}
														?>
													</select>
													<script type="text/javascript">
														objNivel = document.getElementById('user_nivel');
														for (i=0; i < objNivel.options.length; i++) {
															if (objNivel.options[i].value == '<?php echo isset($objUsuario->usr_nivel)?$objUsuario->usr_nivel:'2';?>') {
																objNivel.options[i].selected = true;
																break;
															}		            
														}
													</script>
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  
								  <?php if($edit) {?>
								  <div class="form-group">
								    <label for="user_ativo" class="col-md-2 control-label">Ativo</label>
								    <div class="col-md-2">
								      <input class="form-control"
													id="user_ativo" 
													name="user_ativo"
													type="checkbox"
													value='<?php echo isset($objUsuario->usr_ativo)?$objUsuario->usr_ativo:"";?>'
													<?php echo isset($objUsuario->usr_ativo)?($objUsuario->usr_ativo==1)?"checked='checked'":"":"";?>
													style="color:#377C19;" />
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <?php }?>
			  				</div>	
							
			  				<div class="panel-heading">
								  <div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">
								      <button type="submit" class="btn btn-primary">Gravar</button>
								    </div>
								  </div>
							</div>
							</form>
			  			</div>
	  				</div>