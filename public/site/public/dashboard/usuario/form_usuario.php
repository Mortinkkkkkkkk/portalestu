<?php
    include_once($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
    $caso = $_REQUEST['caso'];
    switch ($caso) {
        case 'insert':
            $titulo = "Cadastro";
            $nome = '';
            $senha = '';
            $email = '';
            $certificado = '';
            $tipo = '';
            $modo = 'userinsert';
            $id = '';
            break;
        case 'update':
            $titulo ="Update";
            $id = $_REQUEST['id'];
            $sql = "SELECT * FROM tb_usuario WHERE id_usuario = ?";
            $result = executaSql($sql,'i',[$id]);
            foreach ($result[1] as $row) { 
                $nome = $row['nome_usuario'];
                $senha = $row['senha_usuario'];
                $email = $row['email_usuario'];
                $certificado = $row['certificado'];
                $tipo = $row['tipo'];
            }
            $modo = 'update';
            break;

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
    <h1><?= $titulo;?>  do Usuario</h1>
    <div>
        <form action="/controle/controle_usuario.php?case=<?= $modo;?>&id=<?= $id;?>" enctype="multipart/form-data" method="post">
            <label for="nome">Nome:</label>
            <input value="<?= $nome;?>" type="text" name="nome"> <br>
            <label for="senha">Senha:</label>
            <input value="<?= $senha;?>" type="password" name="senha" id=""> <br>
            <label for="email">Email:</label>
            <input value="<?= $email;?>" type="email" name="email"> <br>
            <label for="certificado">Certificado:</label>
            <input value="<?= $certificado;?>" type="text" name="certificado"> <br>
            <select name="tipo" id="de">
                <option value="A">Aluno</option>
                <option value="P">Professor</option>
            </select>
            <br>
            <label for="img">Foto de perfil</label><br>
            <input type="file" name="img" id="img">
            <br>
            <input type="submit" value="enviar">
        </form>
    </div>
</body>
</html>