<link rel="shortcut icon" href="../../assets/img/jjw.ico" type="image/x-icon">
<?php
session_start();
$pageTitle = 'Painel';

include '../connect.php'; 
include 'Includes/functions/functions.php';  
include 'Includes/templates/header.php';
include 'Includes/templates/navbar.php';
?> 

<script type="text/javascript">
    var vertical_menu = document.getElementById("vertical-menu");
    var current = vertical_menu.getElementsByClassName("active_link");

    if(current.length > 0) {
        current[0].classList.remove("active_link");   
    }
    
    vertical_menu.getElementsByClassName('dashboard_link')[0].className += " active_link";
</script>

<?php
include("../connection.php");
$id = $_SESSION['id'];

$users_count = 0;
$reserva_count = 0;
$toldos_count = 0;
$foodbe_count = 0;

try {
    $users_query = $pdo->query("SELECT COUNT(username) as users FROM users");
    $users_result = $users_query->fetch(PDO::FETCH_ASSOC);
    $users_count = $users_result['users'];

    $reserva_query = $pdo->query("SELECT COUNT(id_reserva) as reserva FROM reserva");
    $reserva_result = $reserva_query->fetch(PDO::FETCH_ASSOC);
    $reserva_count = $reserva_result['reserva'];

    $toldos_query = $pdo->query("SELECT COUNT(num_seat) as toldos FROM toldos");
    $toldos_result = $toldos_query->fetch(PDO::FETCH_ASSOC);
    $toldos_count = $toldos_result['toldos'];

    $foodbe_query = $pdo->query("SELECT COUNT(id_fb) as food_beverage FROM food_beverage");
    $foodbe_result = $foodbe_query->fetch(PDO::FETCH_ASSOC);
    $foodbe_count = $foodbe_result['food_beverage'];
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>

<div class="row" style="margin-top:10px;">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="fas fa-solid fa-umbrella-beach fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span><?php echo $toldos_count; ?></span></div>
                        <div>Toldos</div>
                    </div>
                </div>
            </div>
            <a href="toldo.php">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalhes</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="far fa-calendar-alt fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span><?php echo $reserva_count; ?></span></div>
                        <div>Reservas</div>
                    </div>
                </div>
            </div>
            <a href="reserva.php">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalhes</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div> 
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="far fa-calendar-alt fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span> </span></div>
                        <div>Log</div>
                    </div>
                </div>
            </div>
            <a href="log.php">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalhes</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div> 
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="far fa-calendar-alt fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span><?php echo $users_count; ?></span></div>
                        <div>Staff</div>
                    </div>
                </div>
            </div>
            <a href="empregado.php">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalhes</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div> 
    </div>

</div>

<?php
include 'Includes/templates/footer.php';
?> 

<script type="text/javascript">
    function openTab(evt, tabName, tabContentClass, tabLinksClass) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName(tabContentClass);
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName(tabLinksClass);
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "table";
    evt.currentTarget.className += " active";
    }
</script>