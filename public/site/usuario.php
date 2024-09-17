<?php 
include_once ($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
session_start();
if (isset($_SESSION['id_usuario'])){
    $iduser = $_SESSION['id_usuario'];
    $tipo = $_SESSION['tipo'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Usuario</h1>
    <h3>Cadastrar usuario <a href="form_usuario.php?caso=insert">+</a></h3>
    
    <h3>Lista de usuario</h3>
    <?php 
        $sql_list_user = "SELECT * FROM tb_usuario WHERE tipo != 'U'";
        $result_list_user = SelectallSql($sql_list_user);
        if (sizeof($result_list_user) > 0) {
                ?>
                <table>
                    <tbody>
                        <tr>
                            <td>Nome</td>
                            <td>Email</td>
                            <td>Certificado</td>
                            <td>Tipo</td>
                            <td>Editar</td>
                        </tr>
                        <?php
            foreach ($result_list_user as $list_user){
                ?>
                        <td><?= $list_user['nome_usuario']?></td>
                        <td><?= $list_user['email_usuario']?></td>
                        <td><?php 
                            if ($list_user['certificado'] == null) {
                                echo "Nao possui";
                            } else {
                                echo $list_user['certificado'];
                            }
                            ?></td>
                        <td><?php
                            $tipo = $list_user["tipo"];
                            if ($tipo == "A") {
                                    echo "Aluno";
                            } else if ($tipo == "P") {
                                echo "Professor";
                            }
                        ?></td>
                        <?php
                            $editar = $list_user["id_usuario"];
                            if (isset($iduser)) {
                                if ($iduser == $editar || $tipo == "X"){
                                        ?>
                                            <td><a href="form_usuario.php?caso=update&id=<?= $iduser?>">Editar</a></td>
                                            <td><a href="/controle/controle_usuario.php?case=delete&id=<?= $iduser?>">Deletar</a></td>
                                        <?php                                   
                                }
                            }
                        ?>
                    </tr>
                <?php
            }
        }
        
        
    ?>
</tbody>
</table>

</body>
</html>