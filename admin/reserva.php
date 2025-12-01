<meta charset="utf-8">
<link rel="shortcut icon" href="../../assets/img/jjw.ico" type="image/x-icon">
<?php
ob_start();
session_start();

$pageTitle = 'Reservas';
include '../connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';
include 'Includes/templates/navbar.php';
?>
<style>
    .container {
        margin-top: 100px;
    }

    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    .popup-content {
        display: inline-block;
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
    }

    .popup-content .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .card-header {
        display: flex;
        justify-content: left;
        align-items: center;
    }

    .button-form {
        display: inline;
        padding: 1px 10px;
    }
</style>

<script type="text/javascript">
    var vertical_menu = document.getElementById("vertical-menu");
    var current = vertical_menu.getElementsByClassName("active_link");
    if (current.length > 0) {
        current[0].classList.remove("active_link");
    }
    vertical_menu.getElementsByClassName('reserva_link')[0].className += " active_link";
</script>

<?php
$do = 'Manage';

$food_count = 0;
$beverage_query = 0;

if ($do == "Manage") {
    // Check if the sorting button is clicked
    $sortOrder = 'ASC'; // Default sorting order

    if (isset($_GET['sort']) && $_GET['sort'] == 'desc') {
        $sortOrder = 'DESC';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_field']) && $_POST['search_field'] === 'reservation_type') {
        $searchValue = $_POST['search'];

        $stmt = $con->prepare("SELECT * FROM reserva WHERE reservation_type LIKE ?");
        $stmt->execute(["%" . $searchValue . "%"]);
        $reserva = $stmt->fetchAll();
    } else {
        $stmt = $con->prepare("SELECT * FROM reserva ORDER BY date $sortOrder");
        $stmt->execute();
        $reserva = $stmt->fetchAll();
    }

    $stmt2 = $con->prepare("SELECT * FROM food_beverage");
    $stmt2->execute();
    $foodBeverage = $stmt2->fetchAll();
    ?>

    <div class="card-header" style="height: 55px;">
        <form method="post" action="pdf.php" class="button-form" style="margin-top: 15px;">
            <button class="btn btn-success" type="submit" name="today" value="today">Hoje</button>
        </form>
        <div class="button-form" style="margin-top: -1px;">
            <button class="btn btn-success" onclick="openDatePicker()">Seleciona a data</button>
            <div id="datePickerPopup" class="popup">
                <div class="popup-content">
                    <span class="close-btn" onclick="closeDatePicker()">&times;</span>
                    <h3>Seleciona a data</h3>
                    <form id="dateForm" method="post" action="pdf.php">
                        <input type="date" name="date" id="selectedDatePopup">
                        <br><br>
                        <button type="button" onclick="submitForm()">OK</button>
                    </form>
                </div>
            </div>
        </div>
        <form method="post" action="pdf.php" class="button-form" style="margin-top: 15px;">
        <button type="submit" name="all" value="Download All Reservations" class="btn btn-success">Todos</button>
    </form>
        <form method="post" action="" class="button-form" style="margin-top: 15px;">
            <input type="hidden" name="search_field" value="reservation_type">
            <input type="text" name="search" placeholder="Pesquisar por status">
            <button type="submit" class="btn btn-success">Pesquisar</button>
        </form>
        <?php if (isset($_POST['search_field']) && $_POST['search_field'] === 'reservation_type') { ?>
            <form method="post" action="" class="button-form" style="margin-top: 15px;">
                <button type="submit" name="show_all" value="show_all" class="btn btn-success">Mostrar Todos</button>
            </form>
        <?php } ?>
    </div>

    <div class="card-body">
        <table class="table table-bordered clientes-table">
            <thead>
                <tr>
                    <th scope="col">Nº Toldo</th>
                    <th scope="col"><a href="?sort=asc">Data ▲</a> / <a href="?sort=desc"> ▼</a></th>
                    <th scope="col">Hora Entrada</th>
                    <th scope="col">Hora Saida</th>
                    <th scope="col">Tipo De Cliente</th>
                    <th scope="col">Nº Quarto</th>
                    <th scope="col">User C</th>
                    <th scope="col">Comida</th>
                    <th scope="col">Bebida</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($reserva as $reservas) {
                    echo "<tr>";
                    echo "<td>";
                    echo $reservas['toldo_id'];
                    echo "</td>";
                    echo "<td>";
                    echo $reservas['date'];
                    echo "</td>";
                    echo "<td>";
                    echo $reservas['hora'];
                    echo "</td>";
                    echo "<td>";
                    echo $reservas['horasaida'];
                    echo "</td>";
                    echo "<td>";
                    echo $reservas['reservation_type'];
                    echo "</td>";
                    echo "<td>";
                    echo $reservas['hotel_number'];
                    echo "</td>";
                    echo "<td>";
                    echo $reservas['user_c'];
                    echo "</td>";
                    echo "<td>";
                    $food_query = $pdo->prepare("SELECT COUNT(food) as food FROM food_beverage WHERE id_reserva = ?");
                    $food_query->execute([$reservas['id_reserva']]);
                    $food_result = $food_query->fetch(PDO::FETCH_ASSOC);
                    $food_count = $food_result['food'];
                    echo $food_count;
                    echo "</td>";
                    echo "<td>";
                    $beverage_query = $pdo->prepare("SELECT COUNT(beverage) as beverage FROM food_beverage WHERE id_reserva = ?");
                    $beverage_query->execute([$reservas['id_reserva']]);
                    $beverage_result = $beverage_query->fetch(PDO::FETCH_ASSOC);
                    $beverage_count = $beverage_result['beverage'];
                    echo $beverage_count;
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
<?php include 'Includes/templates/footer.php'; ?>
<script>
    function openDatePicker() {
        document.getElementById("datePickerPopup").style.display = "block";
    }

    function closeDatePicker() {
        document.getElementById("datePickerPopup").style.display = "none";
    }

    function submitForm() {
        document.getElementById("dateForm").submit();
    }
</script>
<?php
ob_end_flush();
?>
