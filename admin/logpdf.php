<?php
require_once('tcpdf_6_2_13/tcpdf/tcpdf.php');
require_once('../connection.php');

function getReservations($timestamp = null)
{
    global $pdo;

    try {
        $query = "SELECT * FROM log";
        $params = [];

        if ($timestamp !== null) {
            $query .= " WHERE DATE(timestamp) = :timestamp";
            $params[':timestamp'] = $timestamp;
        }

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
    $selectedDate = $_POST['date'];
    $reservations = getReservations($selectedDate);
    generatePDF($reservations, 'Pedidos da data (' . $selectedDate . ')');
} elseif (isset($_POST['today'])) {
    $currentDate = date('Y-m-d');
    $reservations = getReservations($currentDate);
    generatePDF($reservations, "Pedidos de hoje ($currentDate)");
} elseif (isset($_POST['all'])) {
    $reservations = getReservations();
    generatePDF($reservations, 'Todos os Pedidos Feitos');
}

function generatePDF($reservations, $title)
{
    $pdf = new TCPDF('P', 'mm', 'A3', true, 'UTF-8');
    $pdf->SetHeaderData('', 0, $title, '');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();

    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(30, 10, 'Nº Reserva', 1, 0, 'C', 1);
    $pdf->Cell(135, 10, 'Action', 1, 0, 'C', 1);
    $pdf->Cell(59, 10, 'Hora', 1, 0, 'C', 1);
    $pdf->Cell(55, 10, 'User', 1, 1, 'C', 1); // Changed to include end of line

    $pdf->SetFillColor(255);
    $pdf->SetFont('helvetica', '', 12);

    foreach ($reservations as $reservation) {
        $pdf->Cell(30, 10, $reservation['id_reserva'], 1, 0, 'C');
        $pdf->Cell(135, 10, $reservation['action'], 1, 0, 'L');
        $pdf->Cell(59, 10, $reservation['timestamp'], 1, 0, 'C');
        $pdf->Cell(55, 10, $reservation['user_c'], 1, 1, 'C'); // Changed to include end of line
    }

    $pdf->Output('reservations.pdf', 'D');
}
?>
