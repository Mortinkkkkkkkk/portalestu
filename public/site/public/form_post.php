<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/helpers/session.php");
sessionPermit('professor');
$case = $_REQUEST['case'];
switch ($case) {
    case 'insert':
        $titulo = 'Cadastre';
        $legenda = '';
        $img = '';
        $filtro = '';
        $idpost = '';
        $modo = 'cadastro';
        break;
    case 'update':
        $titulo = "Atualize";
        $idpost = $_REQUEST['id'];
        $sql = "SELECT * FROM tb_post WHERE id_post= ?";
        $result = executaSql($sql,'i',[$idpost]);
        foreach ($result[1] as $row) {
            $legenda = $row['legenda'];
            $filtro = $row['filtro'];
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
    <!-- chama o jquery -->
    <script src="/public/assets/js/jquery-3.7.1.min.js"></script>
    <!-- chama o ion icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Chama o css do form e inputs -->
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
    <h1><?= $titulo ?> um post</h1>
    <form action="/controle/controle_post.php?case=<?= $modo?>" enctype="multipart/form-data" method="post">
       <?php 
        // Caso seja uma criação de um novo post, permite o usuario enviar imagens
            if ($case == 'insert') {        
        ?>
        <label for="imagem">Imagens:</label>
        <!-- Div onde fica as imagens -->
        <div id="campos-img">
            <input type="file" name="img_post0" id="img_post0">
            <ion-icon name="add-circle-outline" id="add-img"></ion-icon><br>        
        </div>
        <?}?>
        <div class="div-input">
            <label for="legenda">Legenda:</label>
            <input class="input-ui" type="text" name="legenda" value="<?= $legenda ?>">
            <span class="input-border"></span>
        </div><br><br>
        <select value="<?= $filtro?>" name="filtro" id="filtro">
            <option value="linguagem">Linguagem</option>
            <option value="matematica">Matematica</option>
            <option value="ciencias naturais">Ciencias da Natureza</option>
            <option value="ciencia humanas">Ciencia Humanas</option>
            <option value="redacao">Redação</option>
            <option value="resultadovestibular">Resultado de vestibular</option>
            <option value="dicasdeestudo">Dicas de Estudo</option>
        </select>
        <input type="hidden" name="id" value="<?= $idpost?>">
        <input class="btn-envia" type="submit" value="enviar">
    </form>
    </div>
</body>
<script>
    $('document').ready(
        // função que adiciona mais campos de imgens
        function(){
            let id = 0
            $('#add-img').click(
                 // função que adiciona mais campos de imgens
                function(){
                    id++;
                    $('#campos-img').append("<input type='file' name='img_post"+id+"' id='img_post"+id+"'><br>")
                }
            );
            $('.btn-envia').click(
                 // função que adiciona um campo com o valor da quantidade de campos de imagens
                function(){
                    $('form').append("<input type='hidden' name='count' value='"+id+"'>")
                }
            )
        }
    );
</script>
</html>