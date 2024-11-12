<?php 
    function redirect($local,$mensagem,) {
        switch ($local){
            case 'comentario':
                ?>
                <script>
                    window.location.href='/helpers/comentarios.php';
                </script>
                <?
            case 'pagina_inicial':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/index.php';
                </script>";
                break;
            case 'session':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/index.php';
                </script>";
                break;
            case 'usuario':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/dashboard/usuario/index.php';
                </script>";
                break;
            case 'perfil':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/dashboard/usuario/perfil.php';
                </script>";
                break;
            case 'pin':
                echo "<script>
                    window.location.href='/public/dashboard/usuario/perfil.php';
                </script>";
                break;
            case 'login_err':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/index.html';
                </script>";
                break;


        }
    }

?>
