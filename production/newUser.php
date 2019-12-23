<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';

require_once '../DAO/UsuarioDAO.php';
require_once '../class/Usuario.php';


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
                            $usuario->setPass(addslashes(filter_input(INPUT_POST, 'senha')));
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
                        echo "<br /><pre><span>";
                        var_dump($_POST);
                        echo "</span></pre>";
                    }
                  ?>
            </div>
        </div>
    </div>
    <!-- <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">@</span>
                    <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Recipient's username"
                        aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">@example.com</span>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <span class="input-group-addon">.00</span>
                </div>

                <label for="basic-url">Your vanity URL</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">https://example.com/users/</span>
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>


    </div> -->
</div>


<?php
include 'footer.php';