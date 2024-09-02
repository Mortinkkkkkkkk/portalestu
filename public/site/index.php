<?php
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>universo estudantil</h1>
    <h3>usuario:</h3>
    <p>criacao e lista de <a href="usuario.php">usuario</a></p>

    <h3>posts:</h3>
    <div class="container-posts">
        <?php
            $sql = "SELECT * FROM tb_post";
            $result = bdcompleto($conexao,$sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='post'>";
                    $idpost = $row['id_post'];
                    $sqlimg = "SELECT midia FROM tb_midia WHERE id_post = $idpost";
                    $midia = bdcompleto($conexao,$sqlimg);
                    while ($img = mysqli_fetch_array($midia)){
                        ?>
                        <img src="<?php echo $img['midia'];?>" alt="imagine uma">
                        <?php
                    }
                    $legenda = $row['legenda'];
                    $datapostagem = $row['data_postagem'];
                    $filtro = $row['filtro'];
                    ?>
                    <p><? echo $legenda; ?></p>
                    <p><? echo $datapostagem; ?></p>
                    <p><? echo $filtro; ?></p>

                    <?php

                }
            }

        
        
        ?>

        </div>
    </div>

</body>
</html>