<link rel="shortcut icon" href="../../assets/img/jjw.ico" type="image/x-icon">
<?php
    ob_start();
	session_start();

	$pageTitle = 'Users';
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
                
                vertical_menu.getElementsByClassName('clientes_link')[0].className += " active_link";

            </script>

        <?php

            
            $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM users");
                $stmt->execute();
                $user = $stmt->fetchAll();

            ?> 
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered clients-table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Userame</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Eliminar</th>
                                    <th scope="col">Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($user as $users)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                 echo $users['id'];
                                            echo "</td>";

                                            echo "<td>";
                                                echo $users['username'];
                                            echo "</td>";

                                            echo "<td>";
                                                echo $users['password'];
                                            echo "</td>";                                   

                                        ?>
                                            <td>
                                                <form action="eemp.php" method="post">
                                                    <input type="hidden" name="edit_id" value="<?php echo $users["id"];?>">
                                                    <button  type="submit" name="edit_btn" class="btn btn-success" value="<?php echo $users["id"];?>"> EDITAR</button>
                                                </form>  
                                            </td>

                                            <td>
                                                <form action="empregadocode.php" method="post">
                                                <input type="hidden" name="delete_id" value="<?php echo $users["id"];?>">
                                                <button type="submit" name="delete_clientes" class="btn btn-danger"> APAGAR</button>
                                                </form>
                                            </td>

                                            <td>
                                                <form action="empregadocode.php" method="post">
                                                    <input type="hidden" name="edit_admin" value="<?php echo $users["id"];?>">
                                                    <button  type="submit" name="admin_btn" class="btn btn-success" value="<?php echo $users["id"];?>"> Admin</button>
                                                </form>  
                                            </td> 
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