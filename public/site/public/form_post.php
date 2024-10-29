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
</head>
<body>
    <h1><?= $titulo ?> um post</h1>
    <form action="/controle/controle_post.php?case=<?= $modo?>" enctype="multipart/form-data" method="post">
       <?php 
            if ($case == 'insert') {        
        ?>
        <label for="imagem">Imagens:</label>
        <div id="campos-img">
            <input type="file" name="img_post0" id="img_post0">
            <ion-icon name="add-circle-outline" id="add-img"></ion-icon><br>        
        </div>
        <?}?>
        <label for="legenda">Legenda:</label>
        <input type="text" name="legenda" value="<?= $legenda ?>"><br>
        <select value="<?= $filtro?>" name="filtro" id="filtro">
            <option value="linguagem">Linguagem</option>
            <option value="matematica">Matematica</option>
            <option value="ciencias naturais">Ciencias da Natureza</option>
            <option value="ciencia humanas">Ciencia Humanas</option>
            <option value="redacao">Redação</option>
            <option value="edital">Edital</option>
            <option value="dicasdeestudo">Dicas de Estudo</option>
            <option value="testesvocaional">Teste Vocaional</option>
            <option value="artigos">Artigo</option>
            <option value="entrevistas">Entrevista</option>
            <option value="inscricao">Inscrição</option>
            <option value="simulados">Simulado</option> 
        </select>
        <input type="hidden" name="id" value="<?= $idpost?>">
        <input class="btn-envia" type="submit" value="enviar">
    </form>
</body>
<script>
    $('document').ready(
        function(){
            let id = 0
            $('#add-img').click(
                function(){
                    id++;
                    $('#campos-img').append("<input type='file' name='img_post"+id+"' id='img_post"+id+"'><br>")
                }
            );
            $('.btn-envia').click(
                function(){
                    $('form').append("<input type='hidden' name='count' value='"+id+"'>")
                }
            )
        }
    );
</script>
</html>