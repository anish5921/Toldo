<header class="headerMenu сlearfix sb-page-header">
        <div class="nav-header">
            <a class="navbar-brand">
                Área do Empregado
                 <?php
                 if (session_status() === PHP_SESSION_ACTIVE) {
                            echo " logado com Nº : " . $_SESSION['id'];
                        } else {
                            echo "No active session.";
                        } 
                ?>
            </a>
        </div>

        <div class="nav-controls top-nav">
            <ul class="nav top-menu">
                <li id="user-btn" class="main-li dropdown" style="background:none;">
                    <a class="nav-item-button" href="../sair.php" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-power-off"></i>
                        <span class="username">&nbsp;Deslogar</span>
                        <b class="caret"></b>
                    </a>
                </li>
                <li class="main-li webpage-btn">
                    <a class="nav-item-button" href="../toldoAdmin.php">
                        <i class="fa fa-arrow-left"></i>
                        <span class="username">&nbsp;Voltar para a reserva.</span>
                        <b class="caret"></b>
                    </a>
                </li>
            </ul>
        </div>

    </header>
 
    <aside class="vertical-menu" id="vertical-menu">
        <div>
            <ul class="menu-bar">
                <div class="sidenav-menu-heading">
                 
                </div>

                <li>
                    <a href="index.php" class="a-verMenu dashboard_link">
                        <i class="fas fa-tachometer-alt icon-ver"></i>
                        <span style="padding-left:6px;">Painel</span>
                    </a>
                </li>

                <div class="sidenav-menu-heading">
                    Minha área
                </div>

                <li>
                <a href="toldo.php" class="a-verMenu toldo_link">
                        <i class="fas fa-solid fa-umbrella-beach icon-ver"></i>
                        <span style="padding-left:6px;">Toldo</span>
                    </a>
                </li>

                <li> 
                <a href="reserva.php" class="a-verMenu reserva_link">
                        <i class="fas fa-calendar-alt icon-ver"></i>
                        <span style="padding-left:6px;">Reservas</span>
                    </a>
                </li>

                <li>
                <a href="log.php" class="a-verMenu pedidos_link">
                        <i class="fas fa-regular fa-newspaper icon-ver"></i>
                        <span style="padding-left:6px;">Log</span>
                    </a>
                </li>

                <div class="sidenav-menu-heading">
                    Staff e Admin
                </div>

                <li> 
                <a href="empregado.php" class="a-verMenu clientes_link">
                        <i class="fas fa-solid fa-users icon-ver"></i>
                        <span style="padding-left:6px;">Staff</span>
                    </a>
                </li>

                <li>
                <a href="users.php" class="a-verMenu admin_link">
                        <i class="fas fa-duotone fa-user-secret icon-ver"></i>
                        <span style="padding-left:6px;">Admin</span>
                    </a>
                </li>

    </aside>

<meta charset="utf-8">
<?php
    include '../connect.php';
    $id = $_SESSION['id'];
    $stmt = $con->prepare("SELECT username from users where id = $id;");
    $stmt->execute();
    $nome = $stmt->fetchColumn();
?>
    <div id="content" style="margin-left:240px;">
        <section class="content-wrapper" style="width: 100%;padding: 70px 0 0;">
            <div class="inside-page" style="padding:20px">
                <div class="page_title_top" style="margin-bottom: 1.5rem!important;">
                    <h1 style="color: #5a5c69!important;font-size: 1.75rem;font-weight: 400;line-height: 1.2;">
                        Bem vindo caro/a <?php echo $nome?>!
                    </h1>
                </div>