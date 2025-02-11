<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json');
function checkAuthentication() {
    if (!isset($_SESSION['id_usuario'])) {
        echo json_encode(['success' => false, 'message' => 'No estás autenticado.']);
        http_response_code(401);
        exit;
    }
}
function checkRequestMethod() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        http_response_code(405);
        exit;
    }
}
function validateInput($input) {
    if (!isset($input['id_libro'], $input['calificacion']) || !is_numeric($input['id_libro']) || !is_numeric($input['calificacion']) || $input['calificacion'] < 1 || $input['calificacion'] > 5) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
        http_response_code(400);
        exit;
    }
}
function hasUserVoted($pdo, $IDLibro, $usuarioId) {
    $query = $pdo->prepare('SELECT 1 FROM votos WHERE id_libro = :id_libro AND id_usuario = :usuario_id');
    $query->execute(['id_libro' => $IDLibro, 'usuario_id' => $usuarioId]);
    return $query->rowCount() > 0;
}
function insertVote($pdo, $IDLibro, $usuarioId, $calificacion) {
    $insert = $pdo->prepare('INSERT INTO votos (id_libro, id_usuario, valoracion) VALUES (:id_libro, :usuario_id, :calificacion)');
    $insert->execute([
        'id_libro' => $IDLibro,
        'usuario_id' => $usuarioId,
        'calificacion' => $calificacion
    ]);
}
function getProductRating($pdo, $IDLibro) {
    $mediaQuery = $pdo->prepare('SELECT AVG(valoracion) AS media, COUNT(*) AS total FROM votos WHERE id_libro = :id_libro');
    $mediaQuery->execute(['id_libro' => $IDLibro]);
    return $mediaQuery->fetch();
}
function handleVote() {
    global $pdo;
    checkAuthentication();
    checkRequestMethod();
    
    $input = json_decode(file_get_contents('php://input'), true);
    validateInput($input);
    $IDLibro = $input['id_libro'];
    $calificacion = $input['calificacion'];
    $usuarioId = $_SESSION['id_usuario'];
    
    if (hasUserVoted($pdo, $IDLibro, $usuarioId)) {
        echo json_encode(['success' => false, 'message' => 'Ya has votado este libro.']);
        exit;
    }
    
    insertVote($pdo, $IDLibro, $usuarioId, $calificacion);
    
    $media = getProductRating($pdo, $IDLibro);
    
    echo json_encode([
        'success' => true,
        'valoracion_media' => round($media['media'], 1),
        'total_votos' => (int)$media['total']
    ]);
}
try {
    handleVote();
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos.', 'error' => $e->getMessage()]);
    http_response_code(500);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ocurrió un error inesperado.', 'error' => $e->getMessage()]);
    http_response_code(500);
}
?>
