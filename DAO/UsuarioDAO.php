<?php

require_once '../Config/functions.php';

class UsuarioDAO {

    public function insert(Usuario $u) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stm = $pdo->prepare("INSERT INTO usuario (nome, login, pass, nivelAcesso, statusUsuario)VALUES (:nome, :login, :pass, :nivel, :status)");
            $stm->bindValue(":nome", $u->getNome());
            $stm->bindValue(":login", $u->getLogin());
            $stm->bindValue(":pass", $u->getPass());
            $stm->bindValue(":nivel", $u->getNivelAcesso());
            $stm->bindValue(":status", $u->getStatus());
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $pdo->commit();
                return TRUE;
            } else {
                throw new Exception;
            }
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
            $pdo->rollBack();
        }
    }

    public function update(Usuario $u) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stm = $pdo->prepare('UPDATE usuario SET nome = :nome, login = :login, '
                    . 'nivelAcesso = :nivel, statusUsuario = :status WHERE id = :id');
            $stm->bindValue(":nome", $u->getNome());
            $stm->bindValue(":login", $u->getLogin());
            $stm->bindValue(":nivel", $u->getNivelAcesso());
            $stm->bindValue(":status", $u->getStatus());
            $stm->bindValue(":id", $u->getId());
            $stm->execute();
            if ($stm->rowCount()) {
                $pdo->commit();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            echo 'Erro ao atualizar: ' . $e->getMessage();
            $pdo->rollBack();
            die();
        }
    }

    public function getByID($id) {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT * FROM usuario WHERE id = :id');
            $stm->bindValue(":id", $id);
            $stm->execute();
            if ($stm->rowCount()) {
                $obj = new Usuario();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->id);
                    $obj->setNome($rs->nome);
                    $obj->setLogin($rs->login);
                    $obj->setPass($rs->pass);
                    $obj->setNivelAcesso($rs->nivelAcesso);
                    $obj->setStatus($rs->statusUsuario);
                    $return = clone $obj;
                }
                return $return;
            } else {
                return NULL;
            }
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    }
    
    public function getAll() {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT * FROM public.login');
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Usuario();
                $return = array();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->codlogin);
                    $obj->setLogin($rs->login);
                    $obj->setPass($rs->cryptsenha);
                    $obj->setCodUsuario($rs->codusuario);
                    $obj->setBloqueado($rs->bloqueado);
                    $return[] = clone $obj;
                }
                return $return;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            echo 'Erro ao selecionar os usuários. <br /><b>Mensagem:</b> ' . $e->getMessage();
            die();
        }
    }

    public function signIn($user, $pass) {
        $pdo = connectdb();
        try {
            $stmt = $pdo->prepare("SELECT * FROM public.login WHERE login = :log AND cryptsenha = :pass");
            $stmt->bindValue(':log', $user);
            $stmt->bindValue(':pass', $pass);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $obj = new Usuario();
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->codlogin);
                    $obj->setLogin($rs->login);
                    $obj->setPass($rs->cryptsenha);
                    $obj->setCodUsuario($rs->codusuario);
                    $obj->setBloqueado($rs->bloqueado);
                    $return = clone $obj;
                }
                return $return;
            } else {
                return NULL;
            }
        } catch (PDOException $e) {
            echo 'Ocorreu um erro ao tentar validar usuário e/ou senha.<br /><b>Mensagem: </b>' . $e->getMessage();
            die();
        }
    }
    
    public function validaUserName($username) {
        $pdo = connectdb();
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login");
            $stmt->bindValue(":login", $username);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Ocorreu um erro ao verificar o username no banco de dados.<br /><b>Mensagem: </b>'.$e->getMessage();
            die();
        }
    }
    
    public function alteraSenha(Usuario $user) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE usuario SET pass = :pass WHERE id = :id");
            $stmt->bindValue(":pass", $user->getPass());
            $stmt->bindValue(":id", $user->getId());
            $stmt->execute();
            if ($stmt->rowCount()){
                $pdo->commit();
                return TRUE;
            } else {
                $pdo->rollBack();
                return FALSE;
            }
        } catch (PDOException $e) {
            echo 'Erro ao alterar a senha.<br /><b>Mensagem:</b> '.$e->getMessage();
            $pdo->rollBack();
            die();
        }
    }

}
