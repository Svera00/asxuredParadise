<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "Asparadise";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $usuario, $clave);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
    $id_habitacion = $_POST['id_habitacion'] ?? null;
    $nombre = $_POST['name'] ?? null;
    $correo = $_POST['email'] ?? null;
    $fecha_entrada = $_POST['checkin'] ?? null;
    $fecha_salida = $_POST['checkout'] ?? null;
    $solicitudes = $_POST['requests'] ?? null;

    if (!$id_habitacion || !$nombre || !$correo || !$fecha_entrada || !$fecha_salida) {
        die("Por favor, completa todos los campos requeridos.");
    }

    try {
        $sql = "INSERT INTO reservaciones (id_habitacion, id_usuario, fecha_inicio, fecha_fin, estado, solicitudes) 
                VALUES (:id_habitacion, NULL, :fecha_entrada, :fecha_salida, 'Pendiente', :solicitudes)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_habitacion', $id_habitacion);
        $stmt->bindParam(':fecha_entrada', $fecha_entrada);
        $stmt->bindParam(':fecha_salida', $fecha_salida);
        $stmt->bindParam(':solicitudes', $solicitudes);
        $stmt->execute();
        header("Location: reserva_exitosa.html");
        exit();
    } catch (PDOException $e) {
        die("Error al guardar la reserva: " . $e->getMessage());
    }
}
?>
