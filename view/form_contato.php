 			
	  				<div class="col-md-9">
	  					<div class="content-box-large">
						  <div class="panel-heading">
							<div class="col-md-7">
							  <a href="?action=contato"><-- Voltar</a>
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
					            <center><h4>Dados do Contato</h4>
								<div class="panel-title"><?php echo (isset($key))?getNomeContato($key):'Novo Contato'; ?></div></center>
					        </div>					
			  				<form method="post" class="form-horizontal" role="form" data-toggle="validator" id="form_dados_contato" name="form_dados_contato" action="">
						  			
			  				<div class="panel-body">
						  
							<?php
								$edit = false;
								global $db;
								if ( isset( $_GET['edit'] ) ){
									$db=new ConnectionMysql();								
									$sql = " 
										SELECT
											*,
											DATE_FORMAT( con_data_nascimento , '%d/%c/%Y' ) as con_data_nascimento
										FROM contatos WHERE con_cod = $key "; 
									$query = $db->query($sql);
									$objContato = $query->fetch(PDO::FETCH_OBJ);
									if ( $db->rowCount() >= 1 )
									{	
										$edit = true;
										$con_cod = $objContato->con_cod;
										echo '<input id="id" name="id" type="hidden" value="'.$con_cod.'">';
										
									}
								}
                            ?>	
							<fieldset>
								<legend>Dados Pessoais</legend>
								  <div class="form-group">
								    <label for="con_nome" class="col-md-2 control-label">Nome</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="80" id="con_nome" name="con_nome" placeholder="Nome" value="<?php echo ($edit)?$objContato->con_nome:''; ?>" 
											 data-error="Campo não pode ser vazio." required>
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <div class="form-group">
								    <label for="con_apelido" class="col-md-2 control-label">Apelido</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="100" id="con_apelido" name="con_apelido" placeholder="Apelido" value="<?php echo ($edit)?$objContato->con_apelido:''; ?>" 
											 >
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="con_email" class="col-md-2 control-label">E-Mail</label>
								    <div class="col-md-10">
								      <input type="email" class="form-control" maxlength="100" name="con_email" id="con_email" placeholder="E-Mail" value="<?php echo ($edit)?$objContato->con_email:''; ?>"  autocomplete="off" required>
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <div class="form-group">
								    <label for="con_data_nascimento" class="col-md-2 control-label">Data de Nascimento</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" id="con_data_nascimento" name="con_data_nascimento" value="<?php echo ($edit)?$objContato->con_data_nascimento:''; ?>">
								    </div>
								  </div>
							</fieldset>
							
							<fieldset>
								<legend>Endereço</legend>
								  <div class="form-group">
								    <label for="con_end_cep" class="col-md-2 control-label">Cep</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="9" name="con_end_cep" id="con_end_cep" placeholder="CEP" value="<?php echo ($edit)?$objContato->con_end_cep:''; ?>"  autocomplete="off">
								    </div>
									<div class="help-block with-errors"></div>
								  </div>
								  <div class="form-group">
								    <label for="con_end_rua" class="col-md-2 control-label">Rua</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="100" name="con_end_rua" id="con_end_rua" placeholder="Rua" value="<?php echo ($edit)?$objContato->con_end_rua:''; ?>"  autocomplete="off">
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="con_end_complemento" class="col-md-2 control-label">Complemento</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="100" name="con_end_complemento" id="con_end_complemento" placeholder="Complemento" value="<?php echo ($edit)?$objContato->con_end_complemento:''; ?>"  autocomplete="off">
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="con_end_bairro" class="col-md-2 control-label">Bairro</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="80" name="con_end_bairro" id="con_end_bairro" placeholder="Bairro" value="<?php echo ($edit)?$objContato->con_end_bairro:''; ?>"  autocomplete="off">
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="con_end_cidade" class="col-md-2 control-label">Cidade</label>
								    <div class="col-md-10">
								      <input type="text" class="form-control" maxlength="50" name="con_end_cidade" id="con_end_cidade" placeholder="Cidade" value="<?php echo ($edit)?$objContato->con_end_cidade:''; ?>"  autocomplete="off">
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="con_end_estado" class="col-md-2 control-label">Estado</label>
								    <div class="col-md-10">
								      <select class="form-control"
										name="con_end_estado" id="con_end_estado">
											<option value=""> </option>
											<option value="AC">AC </option>
											<option value="AL">AL </option> 
											<option value="AP">AP </option> 
											<option value="AM">AM </option> 
											<option value="BA">BA </option> 
											<option value="CE">CE </option> 
											<option value="DF">DF </option> 
											<option value="ES">ES </option> 
											<option value="GO">GO </option> 
											<option value="MA">MA </option> 
											<option value="MT">MT </option> 
											<option value="MS">MS </option> 
											<option value="MG">MG </option> 
											<option value="PR">PR </option> 
											<option value="PB">PB </option> 
											<option value="PA">PA </option> 
											<option value="PE">PE </option> 
											<option value="PI">PI </option> 
											<option value="RN">RN </option> 
											<option value="RS">RS </option> 
											<option value="RJ">RJ </option> 
											<option value="RO">RO </option> 
											<option value="RR">RR </option> 
											<option value="SC">SC </option>
											<option value="SE">SE </option> 
											<option value="SP">SP </option> 
											<option value="TO">TO </option>
										</select>
										
										<script type="text/javascript">
											objUF = document.getElementById('con_end_estado');
											var uf = '<?php echo isset($objContato->con_end_estado)?$objContato->con_end_estado:'';?>';
											for (i=0; i < objUF.options.length; i++) {
												if (objUF.options[i].value == uf) {
													objUF.options[i].selected = true;
													break;
												}		            
											}
										</script>
								    </div>
								  </div>
							</fieldset>
							
							<fieldset>
								<legend>Telefones</legend>
								<div class="col-md-12" id="package">
									<div class="row">
									 <div class="col-md-2"></div>
									 <label class="col-md-3 text-md-left">Tipo</label>
									 <label class="col-md-4 text-md-left">Telefone</label>
									</div>
								<?php 
									if($edit){
										$db=new ConnectionMysql();								
										$sql = " 
											SELECT
												t.tel_cod,
												t.tel_tipo,
												t.tel_ddd,
												t.tel_numero
											FROM
												telefones t
											WHERE 
												t.con_cod = $key "; 
										$query = $db->query($sql);
										if ( $db->rowCount() >= 1 )
										{
											$indexs="";
											$first = true;
											while($ObjTable = $query->fetch(PDO::FETCH_OBJ)){
												
												$indexs.=$ObjTable->tel_cod.",";
								?>
									
									<div class="row <?php echo ($first)?'telefone':'';?>">
										<div class="clone">
											<div class="col-md-2"></div>
											<div class="col-md-3">
												<select class="form-control" id="tipo_<?php echo $ObjTable->tel_cod;?>" name="tel_tipo[<?php echo $ObjTable->tel_cod;?>]">
													<option value=""> </option>
													<option value="1">Fixo</option>
													<option value="2">Celular</option>
													<option value="3">Fax</option>
												</select>
											</div>
											<div class="col-md-4">
												<input class="form-control"  type="text" id="tel_<?php echo $ObjTable->tel_cod;?>" name="tel_numero[<?php echo $ObjTable->tel_cod;?>]" value="<?php echo $ObjTable->tel_ddd." ".$ObjTable->tel_numero;?>" size="24" maxlength="15" placeholder="* telefone">
											</div>
											<button for="<?php echo ($first)?'first':'';?>" class="btn btn-danger btn-xs remove" type="button" id="btn_<?php echo $ObjTable->tel_cod;?>">Remover</button>
										</div>
									</div>	
									<script type="text/javascript">
										objTipo = document.getElementById('tipo_<?php echo $ObjTable->tel_cod;?>');
										var tel_tipo = '<?php echo $ObjTable->tel_tipo;?>';
										for (i=0; i < objTipo.options.length; i++) {
											if (objTipo.options[i].value == tel_tipo) {
												objTipo.options[i].selected = true;
												break;
											}		            
										}
										setMask('tel_<?php echo $ObjTable->tel_cod;?>', <?php echo $ObjTable->tel_tipo;?>, '<?php echo $ObjTable->tel_ddd." ".$ObjTable->tel_numero;?>');
									</script>
											
								
									<?php 
												$first = false;
											}
											echo '<input name="indexs" type="hidden" value="'.$indexs.'">';
										}
									
									}else{ ?>
									
									<div class="row telefone">
										<div class="clone">
											<div class="col-md-2"></div>
											<div class="col-md-3">
												<select class="form-control" name="tel_tipo[]">
													<option value=""> </option>
													<option value="1">Fixo</option>
													<option value="2">Celular</option>
													<option value="3">Fax</option>
												</select>
											</div>
											<div class="col-md-4">
												<input class="form-control"  type="text" name="tel_numero[]" value="" size="24" maxlength="15" placeholder="* telefone">
											</div>
										</div>
									</div>									

									<?php									
									}
									
									?>
							</div>
								  <div class="form-group">
								    <div class="col-md-6">
										<input type="button" class="btn btn-success" href="#" id="addtel" value="Adicionar Telefone ->">
									</div>
								  </div>
								
								
							</fieldset>
							
							<fieldset>
								<legend>Observações</legend>
								  <div class="form-group">
								    <div class="col-md-10">
								      <textarea class="form-control" id="con_observacao" name="con_observacao" placeholder=""><?php echo ($edit)?$objContato->con_observacao:''; ?></textarea>
								    </div>
								  </div>
								  
								  <?php if($edit) {?>
								  <div class="form-group">
								    <label for="con_ativo" class="col-md-2 control-label">Ativo</label>
								    <div class="col-md-2">
								      <input class="form-control"
													id="con_ativo" 
													name="con_ativo"
													type="checkbox"
													value='<?php echo isset($objContato->con_ativo)?$objContato->con_ativo:"";?>'
													<?php echo isset($objContato->con_ativo)?($objContato->con_ativo==1)?"checked='checked'":"":"";?>
													style="color:#377C19;" />
								    </div>
								  </div>
								  <?php }?>
							</fieldset>
							
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

					
<script type="text/javascript">
	$(document).ready(function(){
		
		//mascaras 
		$("#con_data_nascimento").mask("99/99/9999").val('<?php echo (isset($objContato->con_data_nascimento))?$objContato->con_data_nascimento:'';?>');
		
		
	});
</script>
	