<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Selecione 3 filtros</h1>
    <form action="/controle/controle_usuario.php?caso=filterinsert" method="post">
        <label for="flt1">Filtro 1</label>
        <select name="flt1" id="filtro">
            <option value="linguagem">Linguagem</option>
            <option value="matematica">Matematica</option>
            <option value="ciencia humanas">Ciencias Humanas</option>
            <option value="ciencias naturais">Ciencias da Natureza</option>
            <option value="redacao">Redação</option>
        </select> <br>
        <label for="flt2">Filtro 2</label>
        <select name="flt2" id="filtro">
            <option value="linguagem">Linguagem</option>
            <option value="matematica">Matematica</option>
            <option value="ciencia humanas">Ciencias Humanas</option>
            <option value="ciencias naturais">Ciencias da Natureza</option>
            <option value="redacao">Redação</option>
        </select> <br>
        <label for="flt3">Filtro 3</label>
        <select name="flt3" id="filtro">
            <option value="linguagem">Linguagem</option>
            <option value="matematica">Matematica</option>
            <option value="ciencia humanas">Ciencias Humanas</option>
            <option value="ciencias naturais">Ciencias da Natureza</option>
            <option value="redacao">Redação</option>
        </select> <br>
        <input type="hidden" name="id" value="<?= $_REQUEST['id']?>">
        <input type="submit" name="gg" value="Enviar">
    </form>
</body>
</html>