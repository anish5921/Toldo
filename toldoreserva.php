<?php
include('security.php');
include("connection.php");

$user_id = $_SESSION['id'];
$reservationId = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        $toldo_id = $_POST['toldo_id'];
        $reservation_type = $_POST['reservation_type'];
        $hotel_number = $_POST['hotel_number'];

        $currentDate = date('Y-m-d');

        $hotel_number = ($reservation_type === 'passante') ? null : $_POST['hotel_number'];

        $food = '';
        $beverage = '';
        $foodBeverageOption = $_POST['foodBeverage'];

        $food = null;
        $beverage = null;

        if ($foodBeverageOption !== 'nao') {
            switch ($foodBeverageOption) {
                case 'food':
                    $food = 'food';
                    break;
                case 'beverage':
                    $beverage = 'beverage';
                    break;
                case 'food&beverage':
                    $food = 'food';
                    $beverage = 'beverage';
                    break;
            }
        }
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO reserva (toldo_id, reservation_type, hotel_number, date, hora, user_c, user_id) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP(), ?, ?)");
            $stmt->execute([$toldo_id, $reservation_type, $hotel_number, $currentDate, $_SESSION['username'], $_SESSION['id']]);

            $reservationId = $pdo->lastInsertId();

            $updateStmt = $pdo->prepare("UPDATE toldos SET status = 'reservado' WHERE id = ?");
            $updateStmt->execute([$toldo_id]);

            $fbStmt = $pdo->prepare("INSERT INTO food_beverage (toldo_id, id_reserva, food, beverage, user_c) VALUES (?, ?, ?, ?, ?)");
            $fbStmt->execute([$toldo_id, $reservationId, $food, $beverage, $_SESSION['username']]);
            
            if ($stmt->rowCount() > 0 && $updateStmt->rowCount() > 0 && $fbStmt->rowCount() > 0) {
                $user_c = $_SESSION['username'];
                if ($reservation_type === 'passante') {
                    $action = $_SESSION['username'] . " reservou cliente passante em Toldo $toldo_id";
                } else {
                    $action = $_SESSION['username'] . " reservou cliente do hotel em Toldo $toldo_id";
                } 

                $logStmt = $pdo->prepare("INSERT INTO log (`id_reserva`,`action`, `user_c`) VALUES (?, ?, ?)");
                $logStmt->execute([$reservationId,$action, $user_c]);

                header("Location: toldo.php");
                exit();
            } else {
                echo "Failed to save reservation.";
            }
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
    }
    if (isset($_POST['cancel'])) {
        $toldo_id = $_POST['toldo_id'];
        echo "Reservation cancelled.";

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $log_action = $_SESSION['username'] . " cancelou reserva em toldo $toldo_id";
                $log_user = $_SESSION['username'];
                $log_query = "INSERT INTO log (id_reserva, action, user_c) VALUES ('$id_reserva', '$log_action', '" . $_SESSION['username'] . "')";
                mysqli_query($conn, $log_query);

            header("Location: toldo.php");
            exit();
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
    }
}

$toldoId = isset($_GET['toldoId']) ? $_GET['toldoId'] : null;
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Reserva Tolos</title>
</head>
<body style="background-color: #222222;">
    <br><br><br><br><br><br>
    <?php
    if($toldoId == '78'){ ?>
        <h2 style="color: white; text-align: center;">Toldo Número: B1</h2>
    <?php }else if($toldoId == '79'){ ?>
        <h2 style="color: white; text-align: center;">Toldo Número: B2</h2>
    <?php }else{ ?>
        <h2 style="color: white; text-align: center;">Toldo Número: <?php echo $toldoId?></h2>
    <?php } ?>
    <section class="column" style="color: white; background-color: #222222; padding: 20px; display: flex; justify-content: center; align-items: center;">
        <form style="display: flex; flex-direction: column;" action="toldoreserva.php" method="POST">
            <input type="hidden" name="toldo_id" id="toldo_id" value="<?php echo $toldoId; ?>">

            <div class="form-group">
                <label for="reservation_type" style="font-size: 18px;">Tipo de Cliente:</label>
                <select name="reservation_type" id="reservation_type" onchange="showAdditionalField()" style="width: 250px; padding: 10px; font-size: 16px; margin-bottom: 10px;">
                    <option value="passante">Cliente Passante</option>
                    <option value="hotel">Cliente Hotel</option>
                </select>
            </div>

            <div id="additionalField" style="display: none;">
                <div class="form-group">
                    <label for="hotel" style="font-size: 18px;">Númeo de Quarto:</label>
                    <input type="text" id="hotel" name="hotel_number" style="width: 250px; padding: 10px; font-size: 16px;" >
                </div>
            </div>

            <div class="form-group">
                <label for="foodBeverage" style="font-size: 18px;">Comida ou bebida:</label>
                <select name="foodBeverage" id="foodBeverage" style="width: 250px; padding: 10px; font-size: 16px; margin-bottom: 10px;">
                    <option value="nao">Nenhum</option>
                    <option value="food">Comida</option>
                    <option value="beverage">Bebida</option>
                    <option value="food&beverage">Comida e bebida</option>
                </select>
            </div>
            <div class="button-container">
                <button class="button" type="submit" name="save" value="Save" style="background-color: #4CAF50; color: white;">Save</button>
                <button class="button" type="submit" name="cancel" value="Cancel" style="background-color:  #f44336; color: white;" >Cancel</button>
            </div>
        </form>
    </section>
</body>
<script>
function showAdditionalField() {
    var reservation_type = document.getElementById("reservation_type").value;
    var additionalField = document.getElementById("additionalField");
    var hotelField = document.getElementById("hotel");
    var cancelButton = document.querySelector('button[name="cancel"]');

    if (reservation_type === "hotel") {
        additionalField.style.display = "block";
        hotelField.required = true;
    } else {
        additionalField.style.display = "none";
        hotelField.required = false;
    }

    cancelButton.addEventListener("click", function() {
        hotelField.required = false;
    });
}
</script>
</html>