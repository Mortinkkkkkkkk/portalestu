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
    <link rel="stylesheet" href="/public/assets/css/form.css">
    <link rel="stylesheet" href="/public/assets/css/inputs.css">
    <style>
        body{
            background-color: rgb(244, 249, 255);
        }
    </style>
</head>
<body>
    <div class="container-form">
    <h1><?= $titulo;?>  do Usuario</h1>
        <form action="/controle/controle_usuario.php?case=<?= $modo;?>&id=<?= $id;?>" enctype="multipart/form-data" method="post">
        <div class="div-input">
            <label for="nome">Nome:</label>
            <input class="input-ui" value="<?= $nome;?>" type="text" name="nome">
            <span class="input-border"></span>
        </div>
        <div class="div-input">
            <label for="senha">Senha:</label>
            <input class="input-ui" value="<?= $senha;?>" type="password" name="senha" id="">
            <span class="input-border"></span>
        </div>
        <div class="div-input">
            <label for="email">Email:</label>
            <input class="input-ui" value="<?= $email;?>" type="email" name="email">
            <span class="input-border"></span>
        <div class="div-input">
            <label for="certificado">Certificado:</label>
            <input class="input-ui" value="<?= $certificado;?>" type="text" name="certificado">
            <span class="input-border"></span>
        </div>
            <select name="tipo" id="de">
                <option value="A">Aluno</option>
                <option value="P">Professor</option>
            </select>
            <br>
            <label for="img">Foto de perfil</label><br>
            <input type="file" name="img" id="img">
            <br>
            <input  type="submit" value="enviar">
        </form>
    </div>
</body>
</html>