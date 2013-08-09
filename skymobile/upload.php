<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upload Sky Mobile</title>
        <style>
            body {
                width: 300px;
                margin: auto;
                font-family: Arial, sans-serif;
                font-size: 14px;
            }
            h1 {
                text-align: center;
                color: #0099dd;
            }
            button {
                border: 0;
                background: #E27102;
                color: #FFF;
                font-weight: bold;
                padding: 10px 20px;
                -webkit-border-radius: 10px;
                border-radius: 10px;
            }
            
        </style>
    </head>
    <body>
        <h1>Sky Mobile -<br> Upload</h1>
        <br>
        <br>
        <form action="" method="post" enctype="multipart/form-data">
            <span>Envie a atualização do arquivo:</span><br><br>
            <input type="file" name="arquivo"><br><br>
            <button type="submit">Enviar</button>
        </form>
        
<?php
if (isset ($_FILES['arquivo'])) {
    if ($_FILES["arquivo"]["error"] > 0) {
            echo "Erro: ".$_FILES["arquivo"]["error"]."<br>";
        }else {
            $file_name = "skymobile.apk"; //tiracento($_FILES["arquivo"]["name"]); //retira caracteres especiais do nome do arquivo
            $logo_path = "E:/Inetpub/vhosts/cpro12924.publiccloud.com.br/centralsigma/skymobile/".$file_name;
            $success = move_uploaded_file($_FILES["arquivo"]["tmp_name"], $logo_path);

            if ($success) {
                echo 'Arquivo enviado com sucesso!';
            }else {
                echo 'Erro ao enviar arquivo.';
            }
    }
}
?>
    </body>
</html>

