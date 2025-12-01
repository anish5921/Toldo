<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Reserva Toldos</title>
</head>
<script>
            function updateTime() {
            var date = new Date();
            var time = date.toLocaleTimeString();
            document.getElementById('clock').innerHTML = time;
        }

        setInterval(updateTime, 1000);

</script>
<body style="background-color: #222222;">
    <div class="container">
    <section class="column1" style="color: white;">
            <div>
                <br><br>

                <h1>Data de Hoje:</h1>
                <p><?php
                $dia = date('d');
                $meses = array(
                    1 => 'Janeiro',
                    2 => 'Fevereiro',
                    3 => 'Março',
                    4 => 'Abril',
                    5 => 'Maio',
                    6 => 'Junho',
                    7 => 'Julho',
                    8 => 'Agosto',
                    9 => 'Setembro',
                    10 => 'Outubro',
                    11 => 'Novembro',
                    12 => 'Dezembro'
                );
                $mes = $meses[date('n')];
                $ano = date('Y');
                $data = $dia . ' de ' . $mes . ' de ' . $ano;
                echo $data;
                ?></p>

                <h1>Horas:</h1>
                <p id="clock"><?php echo date('H:i:s'); ?></p>

                <h1>Dia de Hoje:</h1>
                <p><?php 
                $weekdays = array(
                    'Sunday' => 'Domingo',
                    'Monday' => 'Segunda-feira',
                    'Tuesday' => 'Terça-feira',
                    'Wednesday' => 'Quarta-feira',
                    'Thursday' => 'Quinta-feira',
                    'Friday' => 'Sexta-feira',
                    'Saturday' => 'Sábado'
                );
                $dayOfWeek = date('l');
                $dayOfWeekTranslated = $weekdays[$dayOfWeek];
                echo $dayOfWeekTranslated;
                ?></p>
            </div>
        </section>
        <section class="column2">
  <div class="movie-container" id="movie">
    <ul class="showcase" style="color: white; width: 650px; margin-left: auto; margin-right: auto;">
      <li style="margin-right: 0px; text-align: left;">
        <div class="white"></div>
        <small>Disponível</small>
      </li>
      <li style="text-align: center;">
        <div class="red"></div>
        <small>Passante</small>
      </li>
      <li style="margin-right: 60px; text-align: right;">
        <div class="blue" style="background-color: #0000FF;"></div>
        <small>Quarto</small>
      </li>
    </ul>
    <br>
                <div class="toldo-row" id="toldoRow"></div>
<?php
include("security.php");
include("connection.php");

echo "<div class='row' style='display: flex; flex-wrap: wrap;'>";

$sql_toldos = "SELECT * FROM toldos ORDER BY id ASC";
$resultado_toldos = $pdo->query($sql_toldos);
if ($resultado_toldos->rowCount() > 0) {
    while ($row_toldos = $resultado_toldos->fetch(PDO::FETCH_ASSOC)) {
        $id_toldo = $row_toldos['id'];
        $query_type = "SELECT * FROM reserva WHERE toldo_id ='$id_toldo' and antigo != 'sim'";
        $query_type_run = $pdo->query($query_type);
        if($query_type_run->rowCount() > 0){
            foreach ($query_type_run as $row_type) {
                $toldoNumber = $id_toldo;
                if($toldoNumber == '78'){
                    $toldoNumber = 'B1';
                }else if($toldoNumber == '79'){
                    $toldoNumber = 'B2';
                }
                if ($row_type['reservation_type'] == 'passante') {
                    if ($toldoNumber == '18' || $toldoNumber == '35' || $toldoNumber == '49' || $toldoNumber == '63' || $toldoNumber == '77'){
                        echo "<a href='toldoocupadoAdmin.php?toldoId=".$id_toldo."' style='text-decoration:none;color:black;'><div class='toldo' style='background-color:red;'>".$id_toldo."</div></a></div><div class='row' style='display: flex; flex-wrap: wrap;'>";
                    }else{
                    echo "<a href='toldoocupadoAdmin.php?toldoId=".$id_toldo."' style='text-decoration:none;color:black;'><div class='toldo' style='background-color:red;'>".$id_toldo."</div></a>";
                    }    
                } elseif ($row_type['reservation_type'] == 'hotel') {
                    if ($toldoNumber == '18' || $toldoNumber == '35' || $toldoNumber == '49' || $toldoNumber == '63' || $toldoNumber == '77'){
                        echo "<a href='toldoocupadoAdmin.php?toldoId=".$id_toldo."' style='text-decoration:none;color:black;'><div class='toldo $id_toldo' onclick='handleToldoClick(event)' style='background-color:blue;'>".$id_toldo."</div></a></div><div class='row' style='display: flex; flex-wrap: wrap;'>";
                    }else{
                    echo "<a href='toldoocupadoAdmin.php?toldoId=".$id_toldo."' style='text-decoration:none;color:black;'><div class='toldo $id_toldo' onclick='handleToldoClick(event)' style='background-color:blue;'>".$id_toldo."</div></a>";
                    }    
                } 
            }
        }else { 
            $toldoNumber = $id_toldo;
            if($id_toldo == '78'){
                $id_toldo = 'B1';
            }else if($id_toldo == '79'){
                $id_toldo = 'B2';
            }
            if ($toldoNumber == '18' || $toldoNumber == '35' || $toldoNumber == '49' || $toldoNumber == '63' || $toldoNumber == '77'){
                echo "<a href='toldoreservaAdmin.php?toldoId=".$id_toldo."' style='text-decoration:none;color:black;'><div class='toldo $id_toldo' onclick='handleToldoClick(event)'>".$id_toldo."</div></a></div><div class='row' style='display: flex; flex-wrap: wrap;'>";
            }else{
            echo "<a href='toldoreservaAdmin.php?toldoId=".$id_toldo."' style='text-decoration:none;color:black;'><div class='toldo $id_toldo' onclick='handleToldoClick(event)'>".$id_toldo."</div></a>";
            }
        }
    }
}
echo "</div>";
?>
                <br><br>
                <div class="button-container" style="display: flex; justify-content: right; margin-right: 110px;">
                    <a class="button" style="text-decoration: none; color: #222222; margin-right: 20px;" href="toldoDisAdmin.php">Disponível</a>
                    <a class="button" style="text-decoration: none; color: #222222; margin-right: 20px;" href="admin/index.php">Painel</a>
                    <a class="button" style="text-decoration: none; color: #222222;" href="sair.php">Logout</a>
                </div>
            </div>
        </section>
    </div>

    <script>
        var occupiedToldosJSON = <?php echo $occupiedToldosJSON; ?>;
        var toldoRow = document.getElementById("toldoRow");

        function getSelectedToldoId() {
            var selectedToldo = document.querySelector('.selected');
            if (selectedToldo) {
                return selectedToldo.id;
            }
            return null;
        }
     

        function handleToldoClick(event) {
            var toldo = event.target;
            var selectedToldoId = getSelectedToldoId();
            if (selectedToldoId) {
                var selectedToldo = document.getElementById(selectedToldoId);
                selectedToldo.classList.remove('selected');
            }
            toldo.classList.add('selected');

            var toldoId = toldo.id.replace('toldo_', '');
            var isOcupado = toldo.classList.contains('ocupado');

            if (isOcupado) {
                window.location.href = 'toldoocupadoAdmin.php?toldo_id=' + toldoId;
            } else {
                window.location.href = 'toldoreservaAdmin.php?toldo_id=' + toldoId;
            }
        }

        function handleSaveButtonClick() {
            var selectedToldoId = getSelectedToldoId();
            if (selectedToldoId) {
                saveSelectedToldo(selectedToldoId);
                updateToldoStatus(selectedToldoId);
            } else {
                alert('Please select a toldo.');
            }
        }

        var toldos = document.getElementsByClassName('toldo');
        for (var i = 0; i < toldos.length; i++) {
            toldos[i].addEventListener('click', handleToldoClick);
        }

        setInterval(function () {
            updateToldoStatus();
        }, 5000);
    </script>
</body>
</html>