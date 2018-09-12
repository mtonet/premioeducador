<?php require_once('functions.php'); ?>
<?php get_header(); ?>

		<header class="topo">
			<h1>Login</h1>
		</header>
        <form class="form-horizontal" id="login">
            <fieldset>
                <div class="control-group">
                	<label class="control-label" for="input-email">Login</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="input-email">    
					</div>
                </div>
                <div class="control-group">
                	<label class="control-label" for="input-senha">Senha</label>
					<div class="controls">
						<input type="password" class="input-xlarge" id="input-senha">    
					</div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-left: 215px">Entrar</button>
            </fieldset>    
        </form>

<?php get_footer(); ?>