<?php
require_once('tcpdf_6_2_13/tcpdf/tcpdf.php');
require_once('../connection.php');

function getReservations($date = null)
{
    global $pdo;
    try {
        $query = "SELECT r.*, COUNT(fb.food) AS food_count, COUNT(fb.beverage) AS beverage_count
        FROM reserva r
        LEFT JOIN food_beverage fb ON r.id_reserva = fb.id_reserva
        INNER JOIN toldos t ON t.id = r.toldo_id";
        $params = [];

        if ($date !== null) {
            $query .= " WHERE DATE(r.date) = :date";
            $params[':date'] = $date->format('Y-m-d');
        }

        $query .= " GROUP BY r.id_reserva";

        $statement = $pdo->prepare($query);

        foreach ($params as $param => $value) {
            $statement->bindValue($param, $value);
        }

        $statement->execute();
        $reservations = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $reservations;
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
}

if (isset($_POST['date'])) {
    $selectedDate = new DateTime($_POST['date']);
    $reservations = getReservations($selectedDate);
    generatePDF($reservations, 'Pedidos da data (' . $selectedDate->format('Y-m-d') . ')');
}

if (isset($_POST['today'])) {
    $currentDate = new DateTime();
    $reservations = getReservations($currentDate);
    generatePDF($reservations, "Pedidos de hoje (" . $currentDate->format('Y-m-d') . ")");
} elseif (isset($_POST['all'])) {
    $reservations = getReservations();
    generatePDF($reservations, 'Todos os Pedidos Feitos');
}

function generatePDF($reservations, $title)
{
    ob_end_clean(); 

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetHeaderData('', 0, $title, '');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();

    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(13, 7, 'Toldo', 1, 0, 'C', 1);
    $pdf->Cell(22, 7, 'Data', 1, 0, 'C', 1);
    $pdf->Cell(22, 7, 'Hora Reserva', 1, 0, 'C', 1);
    $pdf->Cell(19, 7, 'Hora Saida', 1, 0, 'C', 1);
    $pdf->Cell(26, 7, 'Tipo de Cliente', 1, 0, 'C', 1);
    $pdf->Cell(20, 7, 'Nº Quarto', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'Pedido Comida', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'Pedido Bebida', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'User C', 1, 1, 'C', 1);
    $pdf->SetFillColor(255);

    $pdf->SetFont('helvetica', '', 9);

    foreach ($reservations as $reservation) {
        $pdf->Cell(13, 7, $reservation['toldo_id'], 1, 0, 'C');
        $pdf->Cell(22, 7, $reservation['date'], 1, 0, 'C');
        $pdf->Cell(22, 7, $reservation['hora'], 1, 0, 'C');
        $pdf->Cell(19, 7, $reservation['horasaida'], 1, 0, 'C');
        $pdf->Cell(26, 7, $reservation['reservation_type'], 1, 0, 'C');
        $pdf->Cell(20, 7, $reservation['hotel_number'], 1, 0, 'C');
        $pdf->Cell(25, 7, $reservation['food_count'], 1, 0, 'C');
        $pdf->Cell(25, 7, $reservation['beverage_count'], 1, 0, 'C');
        $pdf->Cell(25, 7, $reservation['user_c'], 1, 1, 'C');
    }


    $pdf->Output('reservations.pdf', 'D');
    exit; 
}

?>
