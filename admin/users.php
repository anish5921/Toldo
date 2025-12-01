<link rel="shortcut icon" href="../../assets/img/jjw.ico" type="image/x-icon">
<?php
    ob_start();
	session_start();

	$pageTitle = 'Admin';
        include '../connect.php';
        include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';
 
        ?>
            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('admin_link')[0].className += " active_link";

            </script>

        <?php

            
            $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM users where admin = '1'"); 
                $stmt->execute();
                $users = $stmt->fetchAll();

            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                   foreach($users as $user)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $user['id'];
                                            echo "</td>";

                                            echo "<td>";
                                                echo $user['username'];
                                            echo "</td>";


                                            echo "<td>";
                                            if ($user['admin'] == 1) {
                                                echo "Sim";
                                            } else {
                                                echo "Não";
                                            }
                                            echo "</td>";

                                        ?>
                                        <?php

                                        echo "</td>";
                                        echo "</tr>";
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