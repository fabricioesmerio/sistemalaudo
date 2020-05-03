<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';

require_once '../DAO/UsuarioDAO.php';
require_once '../class/Usuario.php';

if ($_SESSION['tipo'] != 'Med') {
	session_destroy();
	header('Status: 403 Acesso Proibido', false, 403);
	header('Location: ../index.html');
	exit();
}

?>

<div class="container">
    <div class="right_col" role="main" style="min-height: 572px;">
        <div class="row" style="display: flex;
        height: 92vh;
        flex-direction: column;
        background: #F7F7F7;
        flex: 1;
        z-index: 9999;
        align-items: center;
        justify-content: center;">
            <div class="col-md-3">
                <div class="jumbotron" style="padding: 12px; text-align: center;">
                    <h4>Cadastro de Usuário</h4>
                  </div>
                <form method="POST">
                    <div class="form-group">
                      <label for="usuario">Usuário</label>
                      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Login">
                    </div>
                    <div class="form-group">
                      <label for="senha">Senha</label>
                      <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="bloqueado"> Inativo
                      </label>
                    </div>
                    <button type="submit" name="btnSalvar" class="btn btn-default">Salvar</button>
                  </form>
                  <?php 
                    if (isset($_POST['btnSalvar'])) {
                        if (filter_input(INPUT_POST, 'usuario') !== '' || filter_input(INPUT_POST, 'senha') !== '') {
                            $usuario = new Usuario();
                            $usuario->setLogin(addslashes(filter_input(INPUT_POST, 'usuario')));
                            $usuario->setPass(md5(addslashes(filter_input(INPUT_POST, 'senha'))));
                            if (isset($_POST['bloqueado']) && filter_input(INPUT_POST, 'bloqueado') !== 'on') {
                                $usuario->setBloqueado(true);
                            } else {
                                $usuario->setBloqueado(false);
                            }

                            $usuarioDAO = new UsuarioDAO();
                            if ($usuarioDAO->insert($usuario)) {
                                echo '<div class="alert alert-success" role="alert">Registro criado com sucesso!</div>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Ocorreu um erro ao salvar.</div>';
                            }
                        }
                    }
                  ?>
            </div>
        </div>
    </div>
</div>


<?php
include 'footer.php';