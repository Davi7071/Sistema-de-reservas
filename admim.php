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
                <h2>Reservas Atuais</h2>
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="">Reservas Atuais</a></li>
                </ul>
            </nav>
            <div class="clear"></div>
        </div>
    </header>
    <section class="agendamento">
    <div class="center">
    <?php
				if(isset($_GET['excluir'])){
					$id = (int)$_GET['excluir'];
					$pdo->exec("DELETE FROM `tb_agenda` WHERE id = $id");
					echo '<div class="sucesso">O agendamento foi deletado com sucesso!</div>';
				}
				$info = $pdo->prepare("SELECT * FROM `tb_agenda`");
				$info->execute();
				$info = $info->fetchAll();
				foreach ($info as $key => $value) {
			?>
			<div class="box-single-horario">
				<div class="box-single-wraper">
					Nome: <?php echo $value['nome'] ?><br />
					Data e Horário: <?php echo date('d/m/Y H:i:s',strtotime($value['horario'])); ?>
					<br />
					<a href="?excluir=<?php echo $value['id']; ?>">Excluir!</a>
				</div>
			</div>
			<?php } ?>
			<div class="clear"></div>
    </section>
 
</body>
</html>
