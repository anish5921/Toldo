<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Please enter both username and password.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $username, $password);
            $stmt->fetch();

            if ($password === $password) {
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;

                $sql = "SELECT admin FROM users WHERE id = '$id'";
                $result = mysqli_query($conn, $sql);
                
                $row = mysqli_fetch_assoc($result);
                
                if($row['admin'] == '1'){
                    header("location: toldoAdmin.php");
                    exit;
                }
                if($row['admin'] == '0'){
                    header("location: toldo.php");
                    exit;
                }
            }
        $stmt->close();
        $conn->close();
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">    
  <title>Login</title>
  <meta charset="UTF-8">

  <link rel="shortcut icon" href="login/img/login.ico" type="image/x-icon">

  <link href="login/css/font-awesome.css" rel="stylesheet">
  <link href="login/css/bootstrap.css" rel="stylesheet">   
  <link rel="stylesheet" type="text/css" href="login/css/slick.css">    
  <link rel="stylesheet" type="text/css" href="login/css/bootstrap-datepicker.css">   
  <link href="login/css/magnific-popup.css" rel="stylesheet"> 
  <link id="switcher" href="login/css/theme-color/default-theme.css" rel="stylesheet">     

  <link href="login/css/styles.css" rel="stylesheet">   
  <link href="login/css/login.css" rel="stylesheet">  

  <link href='https://fonts.googleapis.com/css?family=Prata' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Tangerine' rel='stylesheet' type='text/css'>   
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  
  <style>
    body {
      display: cover;
      overflow: hidden;
      align-items: center;
      height: 100%;
      width: 100%;
      padding-top: 80px;
      
    }

    .mu-reservation-form {
      text-align: center;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
    }

    .mu-readmore-btn {
      margin-top: 20px;
    }

  </style>
</head>
<body class="reservation-background" class="no-scrollbar" style="color: black;">
  <header id="mu-header">  
    <nav class="navbar navbar-default mu-main-navbar" role="navigation">  
      <div class="">
        <div class="navbar-header">  
          <a class="navbar-brand">
            <img src="login/img/logojjw.png" alt="Logo img" style="width: 100px;">
          </a>
        </div>
             
      </div>          
    </nav> 
  </header>


  <section id="mu-reservation">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="mu-reservation-area"
            style="margin-top: 15px;">

            <div class="mu-title">
              <br></br>
              <span class="mu-subtitle">Faça o seu Login</span>
              <br></br>
            </div>

            <form method="POST" action="" class="mu-reservation-form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Número de Utilizador" name="username" style="color: black; font-size: 18px; font-family: 'Open San', sans-serif;" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="password" class="form-control" placeholder="Palavra-passe" name="password" style="color: black; font-size: 18px; font-family: 'Open San', sans-serif;" required>
                  </div>
                </div>
              </div>
              <button type="submit" value="Login" class="mu-readmore-btn">Entrar</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="login/js/jquery.min.js"></script>  
  <script src="login/js/bootstrap.js"></script>   
  <script type="text/javascript" src="login/js/slick.js"></script>
  <script type="text/javascript" src="login/js/bootstrap-datepicker.js"></script> 
  <script type="text/javascript" src="login/js/jquery.magnific-popup.min.js"></script> 
  <script type="text/javascript" src="login/js/app.js"></script>
  <script type="text/javascript" src="login/js/custom.js"></script> 
</body>
</html>
