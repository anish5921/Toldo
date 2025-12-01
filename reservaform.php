<?php
include('connection.php');
include('security.php');
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

if (isset($_POST['selected_seat'])) {
    $selectedSeat = $_POST['selected_seat'];

    $reservationCheckSql = "SELECT COUNT(*) FROM reserva WHERE toldo_id = :toldo_id";
    $reservationCheckStmt = $pdo->prepare($reservationCheckSql);
    $reservationCheckStmt->bindParam(':toldo_id', $selectedSeat);
    $reservationCheckStmt->execute();
    $isReserved = $reservationCheckStmt->fetchColumn();

    if ($isReserved) {
        echo "Seat is already reserved.";
    } else {
        $pdo->beginTransaction();

        try {
            $updateStatusSql = "UPDATE toldos SET status = 'reservado' WHERE id = :toldo_id";
            $updateStatusStmt = $pdo->prepare($updateStatusSql);
            $updateStatusStmt->bindParam(':toldo_id', $selectedSeat);
            $updateStatusStmt->execute();

            $reservationSql = "INSERT INTO reserva (user_id, toldo_id, date, time, reservation_type)
                                VALUES (:user_id, :toldo_id, CURDATE(), CURTIME(), 'passante')";

            $reservationStmt = $pdo->prepare($reservationSql);
            $reservationStmt->bindParam(':user_id', $user_id);
            $reservationStmt->bindParam(':toldo_id', $selectedSeat);

            if ($reservationStmt->execute()) {
                $pdo->commit();
                header("Location: toldo.php");
                exit();
            } else {
                $pdo->rollBack();
                echo "Error: Unable to save the seat reservation.";
            }
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Database error: " . $e->getMessage();
        }
    }
} else {
    echo "No seat selected.";
}
?>
