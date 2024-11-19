<?php 
include_once ($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/helpers/session.php");
session_start();
sessionPermit('admim');
if (isset($_SESSION['id_usuario'])){
    $iduser = $_SESSION['id_usuario'];
    $tipologado = $_SESSION['tipo'];
}
?>
<!-- INDEX USUARIO -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/assets/css/lista.css">
</head>
<body>
    <h5><a href="/public/index.php">index</a></h5>
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
                            <td>Filtros</td>
                            <td>Editar</td>
                        </tr>
                        <?php
            foreach ($result_list_user[1] as $list_user){
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
                        $sql_slct_filter = "SELECT * FROM tb_filtro WHERE id_usuario = ?";
                        $ideditar = $list_user["id_usuario"];
                        $result_filter = executaSql($sql_slct_filter,'i',[$ideditar]);
                        if (sizeof($result_filter[1]) > 0){
                            echo "<td>";
                            foreach ($result_filter[1] as $list_filter){
                                ?><?= $list_filter["filtro"];?><br><?php
                            }
                            echo "</td>";
                        } else {
                            echo "<td>Não possui</td>";
                        }
                            if (isset($iduser)) {
                                if ($iduser == $ideditar || $tipologado == "X"){
                                        ?>
                                            <td><a href="form_usuario.php?caso=update&id=<?=$ideditar?>">Editar</a></td>
                                            <td><a href="/controle/controle_usuario.php?case=delete&id=<?= $ideditar?>&tipo=<?=$tipo?>">Deletar</a></td>
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