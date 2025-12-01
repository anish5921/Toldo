<?php
include("security.php");
include("connection.php");

$toldoId = isset($_GET['toldoId']) ? $_GET['toldoId'] : null;

$sql_select_reserva = "SELECT * FROM reserva WHERE toldo_id = $toldoId";
$result_reserva = mysqli_query($conn, $sql_select_reserva);

$id_reserva = null;

if ($toldoId) {
    $result_id_reserva = mysqli_query($conn, "SELECT id_reserva FROM reserva WHERE toldo_id = $toldoId");
    $id_reserva_sql = mysqli_fetch_object($result_id_reserva);
    $id_reserva = $id_reserva_sql->id_reserva;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        $id = $_POST['toldo_id'];
        $status = $_POST['status'];
        $id_reserva = isset($_POST['id_reserva']) ? $_POST['id_reserva'] : null;

        $sql_update = "UPDATE toldos SET status = '$status' WHERE id = '$id'";
        $result_update = mysqli_query($conn, $sql_update);

        if ($status == 'disponivel') {
            date_default_timezone_set('Europe/Lisbon');
            $horaSaida = date('H:i:s');
            $sql_update = "UPDATE reserva SET antigo = 'sim', horasaida = '$horaSaida' WHERE toldo_id = '$id' order by id_reserva DESC LIMIT 1";
            $result_update = mysqli_query($conn, $sql_update); 
        }

        $food_beverage = $_POST['food_beverage'];

        if ($food_beverage) {
            if ($food_beverage == 'nenhum') {
                $sql_beverage = "INSERT INTO food_beverage (food, beverage, toldo_id, id_reserva, user_c) VALUES (NULL, NULL, '$id', '$id_reserva', '" . $_SESSION['username'] . "')";
                $result_beverage = mysqli_query($conn, $sql_beverage);
            } else if ($food_beverage == 'comida') {
                $sql_beverage = "INSERT INTO food_beverage (food, toldo_id, id_reserva, user_c) VALUES ('food', '$id', '$id_reserva', '" . $_SESSION['username'] . "')";
                $result_beverage = mysqli_query($conn, $sql_beverage);
            } else if ($food_beverage == 'bebida') {
                $sql_beverage = "INSERT INTO food_beverage (beverage, toldo_id, id_reserva, user_c) VALUES ('beverage', '$id', '$id_reserva', '" . $_SESSION['username'] . "')";
                $result_beverage = mysqli_query($conn, $sql_beverage);
            } else if ($food_beverage == 'cb') {
                $sql_beverage = "INSERT INTO food_beverage (food, beverage, toldo_id, id_reserva, user_c) VALUES ('food', 'beverage', '$id', '$id_reserva', '" . $_SESSION['username'] . "')";
                $result_beverage = mysqli_query($conn, $sql_beverage);
            }
        }

        $log_action = $_SESSION['username'] . " clicou save em ocupado toldo $id";
        $log_user = $_SESSION['username'];
        $log_query = "INSERT INTO log (id_reserva, action, user_c) VALUES ('$id_reserva', '$log_action', '" . $_SESSION['username'] . "')";
        mysqli_query($conn, $log_query);

        header("Location: toldo.php");
        exit();
    } elseif (isset($_POST['cancel'])) {
        $id_reserva = isset($_POST['id_reserva']) ? $_POST['id_reserva'] : null;
        $id = $_POST['toldo_id'];
        $log_action = $_SESSION['username'] . " clicou cancel no ocupado toldo $id";
        $log_user = $_SESSION['username'];
        $log_query = "INSERT INTO log (id_reserva, action, user_c) VALUES ('$id_reserva', '$log_action', '" . $_SESSION['username'] . "')";
        mysqli_query($conn, $log_query);

        header("Location: toldo.php");
        exit();
    }
}

if ($toldoId) {
    $result_status = mysqli_query($conn, "SELECT status FROM toldos WHERE id = '$toldoId'");
    $status_sql = mysqli_fetch_object($result_status);
    $currentStatus = $status_sql->status;
}
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Reserva Toldos</title>
</head>
<body style="background-color: #222222;">
<br><br><br><br><br><br>
<h2 style="color: white; text-align: center;">Toldo Número: <?php echo $toldoId; ?></h2>
<section class="column" style="color: white; background-color: #222222; padding: 20px; display: flex; justify-content: center; align-items: center;">
    <?php if ($toldoId && isset($currentStatus)): ?>
        <form action="toldoocupado.php" method="POST">
            <input type="hidden" name="toldo_id" value="<?php echo $toldoId; ?>">
            <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">

            <div class="form-group">
                <label for="status" style="font-size: 18px;">Status:</label>
                <select name="status" id="status" style="width: 250px; padding: 10px; font-size: 16px; margin-bottom: 10px;" onchange="toggleAdditionalField()">
                    <option value="reservado" <?php echo $currentStatus === 'reservado' ? 'selected' : ''; ?>>Reservado</option>
                    <option value="disponivel" <?php echo $currentStatus === 'disponivel' ? 'selected' : ''; ?>>Disponível</option>
                </select>
            </div>

            <div id="additionalField" class="form-group" style="display: <?php echo $currentStatus === 'reservado' ? 'block' : 'none'; ?>">
                <label for="food_beverage" style="font-size: 18px;">Comida/Bebida:</label>
                <select name="food_beverage" id="food_beverage" style="width: 250px; padding: 10px; font-size: 16px; margin-bottom: 10px;">
                    <option value="nenhum">Nenhum</option>
                    <option value="comida">Comida</option>
                    <option value="bebida">Bebida</option>
                    <option value="cb">Comida e Bebida</option>
                </select>
            </div>

            <div class="button-container">
                <button type="submit" name="save" class="button" style="background-color: #4CAF50; color: white;">Salvar</button>
                <button type="submit" name="cancel" class="button" style="background-color: #f44336; color: white;">Cancelar</button>
            </div>
        </form>
    <?php endif; ?>
</section>
<script>
    function toggleAdditionalField() {
        var statusSelect = document.getElementById('status');
        var additionalField = document.getElementById('additionalField');

        if (statusSelect.value === 'reservado') {
            additionalField.style.display = 'block';
        } else {
            additionalField.style.display = 'none';
        }
    }
</script>
</body>
</html>