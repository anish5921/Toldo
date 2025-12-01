<meta charset="utf-8">
<link rel="shortcut icon" href="../../assets/img/jjw.ico" type="image/x-icon">
<?php
ob_start();
session_start();

$pageTitle = 'Toldos';
include '../connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';
include 'Includes/templates/navbar.php';
?>

<script type="text/javascript">
    var vertical_menu = document.getElementById("vertical-menu");
    var current = vertical_menu.getElementsByClassName("active_link");
    if (current.length > 0) {
        current[0].classList.remove("active_link");
    }
    vertical_menu.getElementsByClassName('pedidos_link')[0].className += " active_link";
</script>
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

<?php
$do = 'Manage';

if ($do == "Manage") {
    $sortOrder = 'DESC'; 

    if (isset($_GET['sort']) && $_GET['sort'] == 'asc') {
        $sortOrder = 'ASC'; 
    } elseif (isset($_GET['sort']) && $_GET['sort'] == 'desc') {
        $sortOrder = 'DESC'; 
    }

    $stmt = $con->prepare("SELECT * FROM log ORDER BY id $sortOrder");
    $stmt->execute();
    $foodBeverages  = $stmt->fetchAll();
    ?>
    <div class="card-header" style="height: 55px;">
    <form method="post" action="logpdf.php" class="button-form" style="margin-top: 15px;">
    <button class="btn btn-success"  type="submit" name="today" value="Download Today's Reservations">Hoje</button>
    </form>
    <div class="button-form" style="margin-top: -1px;">
        <button class="btn btn-success" onclick="openDatePicker()">Seleciona a data</button>
        <div id="datePickerPopup" class="popup">
            <div class="popup-content">
                <span class="close-btn" onclick="closeDatePicker()">&times;</span>
                <h3>Seleciona a data</h3>
                <form method="post" action="logpdf.php">
                    <input type="date" name="date" id="selectedDatePopup">
                    <br><br>
                    <button type="submit">OK</button>
                </form>
            </div>
        </div>
    </div>
    <form method="post" action="logpdf.php" class="button-form" style="margin-top: 15px;">
        <button type="submit" name="all" value="Download All Reservations" class="btn btn-success">Todos</button>
    </form>
    <div class="button-form" style="margin-top: 15px;">
    </div>
</div>
        <div class="card-body">

            <table class="table table-bordered clientes-table">
                <thead>
                    <tr>
                        <th scope="col"><a href="?sort=asc">Id Log ▲</a> / <a href="?sort=desc">▼</a></th>
                       
                        <th scope="col"> <a href="?sort=asc">Date ▲</a> / <a href="?sort=desc">▼</a></th>
                        <th scope="col">Action</th>
                        <th scope="col">User_c</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($foodBeverages as $toldos) {
                        echo "<tr>";
                        echo "<td>";
                        echo $toldos['id'];
                        echo "</td>";
                        echo "<td>";
                        echo $toldos['timestamp'];
                        echo "</td>";
                        echo "<td>";
                        echo $toldos['action'];
                        echo "</td>";
                        echo "<td>";
                        echo $toldos['user_c'];
                        echo "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
        <script>
        function openDatePicker() {
            var datePickerPopup = document.getElementById("datePickerPopup");
            datePickerPopup.style.display = "block";
        }
        function closeDatePicker() {
        var datePickerPopup = document.getElementById("datePickerPopup");
        datePickerPopup.style.display = "none";
    }
    </script>
<?php
}


include 'Includes/templates/footer.php';
?>
