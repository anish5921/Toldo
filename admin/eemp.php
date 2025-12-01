<?php
ob_start();
session_start();
include('../connection.php');
include 'Includes/functions/functions.php'; 
include 'Includes/templates/header.php';
include 'Includes/templates/navbar.php';

$sql = "SELECT * FROM users"; 
$result = $con->query($sql);

if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    $query = "SELECT * FROM users WHERE id='$id' ";
    $query_run = $con->query($query);
    if (!$query_run) {
        printf("Error: %s\n", $con->error);
        exit();
    }

    foreach ($query_run as $users) {
        ?>

        <script type="text/javascript">

            var vertical_menu = document.getElementById("vertical-menu");
            var current = vertical_menu.getElementsByClassName("active_link");

            if (current.length > 0) {
                current[0].classList.remove("active_link");   
            }

            vertical_menu.getElementsByClassName('clientes_link')[0].className += " active_link";

        </script>
        <div class="card">
            <div class="card-header">
                Editar cliente: <b><?php echo $users['username']?></b>
            </div>
            <div class="card-body">
                <table class="table table-bordered clientes-table">
                    <form action="empregadocode.php" method="POST">
                        <input type="hidden" name="edit_id" value="<?php echo $users['id'] ?>">
                        <div class="form-group">
                            <label> Nome </label>
                            <input type="text" name="edit_username" value="<?php echo $users['username']?>" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label> Password </label>
                            <input type="text" name="edit_password" value="<?php echo $users['password']?>" class="form-control" placeholder="password">
                        </div>    
                        <br>
                        <a href="empregado.php" class="btn btn-danger"> CANCEL </a>&nbsp;&nbsp;&nbsp;
                        <button type="submit" name="update_clientes" class="btn btn-primary"> Guardar </button>
                    </form> 
                <?php
            }               
        }
        ?>
        </table>  
    </div>
</div>
<?php

include 'Includes/templates/footer.php';
?>