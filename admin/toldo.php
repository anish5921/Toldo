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
    vertical_menu.getElementsByClassName('toldo_link')[0].className += " active_link";
</script>

<?php
$do = 'Manage';

if ($do == "Manage") {
  
    $sortOrder = 'ASC'; 

    if (isset($_GET['sort']) && $_GET['sort'] == 'desc') {
        $sortOrder = 'DESC'; 
    }

    $stmt = $con->prepare("SELECT *
        FROM toldos
        ORDER BY CAST(num_seat AS UNSIGNED) $sortOrder"); 
    $stmt->execute();
    $toldo = $stmt->fetchAll();
    ?>
    <div class="card">
        <div class="card-header">
            <?php echo $pageTitle; ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered clientes-table">
                <thead>
                    <tr>
                        <th scope="col">Row</th>
                        <th scope="col"><a href="?sort=asc">Toldo ▲</a> / <a href="?sort=desc"> ▼</a></th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($toldo as $toldos) {
                        echo "<tr>";
                        echo "<td>";
                        echo $toldos['row'];
                        echo "</td>";
                        echo "<td>";
                        echo $toldos['num_seat'];
                        echo "</td>";
                        echo "<td>";
                        echo $toldos['status'];
                        echo "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}

include 'Includes/templates/footer.php';
?>
