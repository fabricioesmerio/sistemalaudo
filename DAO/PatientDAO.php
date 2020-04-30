<?php

require_once '../Config/functions.php';
require_once '../class/Patient.php';


class PatientDAO {

    public function getById($id) {
        $pdo = connectdb();
        try {
            $stmt = $pdo->prepare('SELECT * FROM patient WHERE pk = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount()) {
                $obj = new Patient();
                while($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $obj->setPk($rs->pk);
                    $obj->setPat_nome($rs->pat_name);
                    $obj->setPat_birthdate($rs->pat_birthdate);
                    $obj->setPat_sex($rs->pat_sex);
                    $return = clone $obj;
                }
                return $return;
            }
        } catch (PDOException $e) {
            echo 'Erro ao buscar. <br /> Mensagem: '. $e->getMessage();
            die();
        }
    }

    public function auth($login, $senha) {
        $pdo = connectdb();
        try {
            $stmt = $pdo->prepare('SELECT * FROM patient WHERE registro = :login AND password_web = :senha');
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':senha', $senha);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $obj = new Patient();
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $obj->setPk($rs->pk);
                    $obj->setPat_nome($rs->pat_name);
                    $return = clone $obj;
                }
                return $return;
            }
            return NULL;
        } catch(PDOException $e) {
            echo 'Ocorreu um erro =>'. $e->getMessage();
        }
    }

}