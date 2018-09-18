   <body>
	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
                    <form method="post" class="form" action="<?php echo $SITE_PATH;?>/index.php">
			        <div class="box">
			            <div class="content-wrap">
			                <input class="form-control" type="text" name="user_login" placeholder="E-mail">
			                <input class="form-control" type="password" name="user_password" placeholder="Senha">
			                <div class="action">
							<button class="btn btn-primary signup">Entrar</button>
			                </div>                
			            </div>
			        </div>
                    </form>	

			        <div class="already">
			            <p>Acesso para administradores do sistema</p>
			        </div>
			    </div>
			</div>
		</div>
	</div>
    </body>
</html>