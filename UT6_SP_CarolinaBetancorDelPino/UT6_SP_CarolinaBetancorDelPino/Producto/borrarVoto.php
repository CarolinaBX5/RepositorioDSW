<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No estás autenticado.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        $input = json_decode(file_get_contents('php://input'), true);
        $IDLibro = $input['id_libro'];
        $usuarioId = $_SESSION['id_usuario'];

        
        $deleteQuery = $pdo->prepare('DELETE FROM votos WHERE id_libro = :id_libro AND id_usuario = :id_usuario');
        $deleteQuery->execute(['id_libro' => $IDLibro, 'id_usuario' => $usuarioId]);

        
        $mediaQuery = $pdo->prepare('SELECT AVG(valoracion) AS media, COUNT(*) AS total_votos FROM votos WHERE id_libro = :id_libro');
        $mediaQuery->execute(['id_libro' => $IDLibro]);
        $media = $mediaQuery->fetch();

        if($media['media']==null){
            $media['media']=0;
        }

        echo json_encode([
            'success' => true,
            'valoracion_media' => round($media['media'], 1),
            'total_votos' => $media['total_votos']
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos.', 'error' => $e->getMessage()]);
    }
}
?>
