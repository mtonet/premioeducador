<?php 
require_once('dao/dao.class.php');
require_once("business/facadeInscrito.php");
include("header.php");
?>

            <div id="title">
                <h1>Cadastro de Login e Senha</h1>
            </div>
            Algumas instruções para realizar a sua inscrição:
            <ul id="txt-index">
              <li>Consulte o <a href="http://www.fvc.org.br/premio-victor-civita/inscricoes/regulamento.shtml" target="_blank">regulamento.</a></li>
              <li>Atente-se às instruções para a redação do seu trabalho: extensão do arquivo, fonte e tamanho do arquivo. Para facilitar use o formulário abaixo:<br>
Professores: <a href="http://premioeducador2015.web2165.uni5.net/upload/modelo_redacao_professores.doc">Clique aqui para fazer o download do formulário</a><br>
Gestores: <a href="http://premioeducador2015.web2165.uni5.net/upload/modelo_redacao_gestores.doc">Clique aqui para fazer o download do formulário</a></li>
              <li>A partir da próxima tela, o processo de inscrição será feito em 5 (cinco) etapas. No final, caso necessário, você poderá revisar cada etapa. Depois de finalizar a sua inscrição, você receberá um e-mail de confirmação de inscrição e seus dados não poderão mais ser alterados.</li>
              <li>Anote e guarde seu login, senha e seu número de inscrição.</li>
              <li>O CPF informado deverá ser o do responsável pelo trabalho inscrito.</li>
              <li>Se você já iniciou a sua inscrição e está retornando para finalizá-la, utilize os mesmos login e senha cadastrados anteriormente.</li>
              <li>Para prosseguir com a sua inscrição, clique no botão "Li e concordo com o regulamento".</li>
              <li>Os campos com ( * ) são de preenchimento obrigatório.</li>
            </ul>
            <hr />
            
            <form class="form-horizontal" id="login-signup" style="display: none" action="pass1.php" method="post">
              <fieldset>
                <div class="control-group basic-options">
                    <div class="controls">
                        <label class="radio inline">
                          <input type="radio" id="radio-signup" name="login-signup" value="option1" checked="checked"> Nova inscrição
                        </label>
                        <label class="radio inline">
                          <input type="radio" id="radio-login" name="login-signup" value="option2"> Já sou cadastrado / Quero finalizar minha inscrição
                        </label>
                        <label class="radio inline">
                          <input type="radio" id="radio-forget" name="login-signup" value="option3"> Esqueci a senha
                        </label>
                    </div>
                </div>
				
                <div id="box-existent" style="display: none; color: red">O e-mail e/ou o CPF informados já foram cadastrados. Considere fazer login.</div>
                <div id="box-invalid" style="display: none; color: red">O CPF informado não é válido.</div>

                <div class="control-group signup-group login-group">
                  <label class="control-label" for="input-email">Email (*)</label>
                  <div class="controls">
                    <input type="email" class="input-xlarge" id="input-email" name="email" maxlength="40">
                  </div>
                </div>

                <div class="control-group signup-group forget-group">
                  <label class="control-label" for="input-cpf">CPF (*)</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" id="input-cpf" name="cpf">
                      <span style="font-size:10px">(inserir somente números)</span>
                  </div>
                </div>

                <div class="control-group signup-group login-group">
                  <label class="control-label" for="input-senha">Senha (*)</label>
                  <div class="controls">
                    <input type="password" class="input-xlarge" id="input-senha" name="senha" maxlength="10">
                  </div>
                </div>

                <div class="control-group signup-group">
                  <label class="control-label" for="input-confirmar-senha">Confirmar Senha (*)</label>
                  <div class="controls">
                    <input type="password" class="input-xlarge" id="input-confirmar-senha">
                  </div>
                </div>

                <div class="control-group signup-group">
                    <div class="controls">
                        <label class="checkbox inline">
                        <input type="checkbox" id="checkbox-regulamento" value="option1">Li e concordo com o <a href="http://www.fvc.org.br/premio-victor-civita/inscricoes/regulamento.shtml" target="_blank">regulamento.</a>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="next-pass" disabled>Avançar</button>
                </div>
    
              </fieldset>
            </form>

<?php include("footer.php"); ?>