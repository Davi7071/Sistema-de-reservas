<?php
date_default_timezone_set('america/Sao_Paulo');
$pdo = new PDO('mysql:host=localhost;dbname=', 'root', '');
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Roboto+Slab&display=swap" rel="stylesheet">
    <title>Sistema de reserva php</title>
</head>
<body>
    <header>
        <div class="center">
            <div class="logo">
                <h2>Logo empresa</h2>
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="">Reservas</a></li>
                    <li><a href="">Sobre</a></li>
                    <li><a href="">Contato</a></li>
                </ul>
            </nav>
            <div class="clear"></div>
        </div>
    </header>
    <section class="esp">
        <div class="center">
            <div><h3>Escolha um horario e faça sua reserva</h3></div>
        </div>
    </section>
    <section class="reserva">
        <div class="center">
            <?php
            if (isset($_POST['acao'])) {
                // quer fazer uma reserva
                $nome = $_POST['nome'];
                $datahora = $_POST['datahora'];
                $date = DateTime::createFromFormat('d/m/Y H:i', $datahora);

                if ($date === false) {
                    echo '<div class="erro">Erro ao processar a data e hora!</div>';
                } else {
                    $datahora = $date->format('Y-m-d H:i:s');
                    $sql = $pdo->prepare("INSERT INTO `tb_agenda` VALUES (null, ?,?)");
                    $sql->execute(array($nome,$datahora));

                    echo '<div class="sucesso">Seu horario foi agendado com sucesso!</div>';
                }
            }
            ?>

            <form method="post">
                <input type="text" name="nome" placeholder="Seu nome...">
                <select name="datahora">
                <?php
                    for ($i = 0; $i <= 23; $i++) { 
                        $hora = $i; 
                        if ($i < 10) {
                            $hora = '0' .$hora;
                        } else {
                            $hora = (string)$hora;
                        }
                        $hora = str_pad($hora, 2, '0', STR_PAD_LEFT) . ':00';

                        $verifica = date('Y-m-d') . ' ' . $hora;
                        $sql = $pdo->prepare("SELECT * FROM `tb_agenda` WHERE horario = ?");
                        $sql->execute([$verifica]);
                        
                        if ($sql->rowCount()==0 && strtotime($verifica)>time()){
                        $datahora = date('d/m/Y').' '.$hora;
                        echo '<option value="' . $datahora . '">' . $datahora . '</option>';
                    }
                }
                    ?>

                </select>
                <input type="submit" name="acao" value="Enviar">
            </form>
        </div>
    </section>

    <sectiom class="sobre">
        <div class="info"></div>
    </sectiom>


</body>
</html>
