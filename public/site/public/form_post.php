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
</head>
<body>
    <h1><?= $titulo ?> um post</h1>
    <form action="/controle/controle_post.php?case=<?= $modo?>" enctype="multipart/form-data" method="post">
       <?php 
            if ($case == 'insert') {        
        ?><label for="imagem">Imagem:</label>
        <input type="file" name="img_post" id="img_post"><br>
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
        <input type="submit" value="enviar">

    </form>
</body>
</html>