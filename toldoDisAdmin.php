<?php
include("security.php");
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        $sql_update = "UPDATE toldos SET status = 'disponivel'";
        $result_update = mysqli_query($conn, $sql_update);
        
        if ($result_update) {
            $log_action = $_SESSION['username'] . " disponibilizou todos os toldos.";
            $log_query = "INSERT INTO log (action, user_c) VALUES ('$log_action', '" . $_SESSION['username'] . "')";
            mysqli_query($conn, $log_query);
            
            date_default_timezone_set('Europe/Lisbon');
            $horaSaida = date('H:i:s');
            
            $reserva_update = "UPDATE reserva SET antigo = 'sim', horasaida = '$horaSaida' WHERE antigo <> 'sim'";
            $result_reserva = mysqli_query($conn, $reserva_update);
            
            if ($result_reserva) {
                header("Location: toldoadmin.php");
                exit();
            } else {
                echo "Error updating reserva: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating toldos: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['cancel'])) {
        $log_action = $_SESSION['username'] . " clicou no cancel para não disponibilizar todos os toldos ";
        $log_query = "INSERT INTO log (action, user_c) VALUES ('$log_action', '" . $_SESSION['username'] . "')";
        mysqli_query($conn, $log_query);

        header("Location: toldoadmin.php");
        exit();
    }
}
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Disponível Toldos</title>
</head>
<body style="background-color: #222222;">
<br><br><br><br><br><br>
<h2 style="color: white; text-align: center;">Você quer disponibilizar todos os toldo? </h2>
<section class="column" style="color: white; background-color: #222222; padding: 20px; display: flex; justify-content: center; align-items: center;">
    <form action="toldoDisAdmin.php" method="POST">     
        <div class="button-container">
            <button type="submit" name="save" class="button" style="background-color: #4CAF50; color: white;">Sim</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" name="cancel" class="button" style="background-color: #f44336; color: white;">Cancelar</button>
        </div>
    </form>
</section>
</body>
</html>
