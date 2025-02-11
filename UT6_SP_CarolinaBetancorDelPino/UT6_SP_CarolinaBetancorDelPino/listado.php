<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$query = $pdo->prepare('SELECT * FROM libros');
$query->execute();
$libros = $query->fetchAll(PDO::FETCH_ASSOC);


function obtenerValoracion($IDLibro) {
    global $pdo;
    $query = $pdo->prepare('SELECT AVG(valoracion) AS media, COUNT(*) AS total_votos 
                            FROM votos WHERE id_libro = :id_libro');
    $query->execute(['id_libro' => $IDLibro]);
    return $query->fetch();
}

function obtenerVotoUsuario($IDLibro) {
    global $pdo;
    $query = $pdo->prepare('SELECT valoracion FROM votos WHERE id_libro = :id_libro AND id_usuario = :id_usuario');
    $query->execute([
        'id_libro' => $IDLibro, 
        'id_usuario' => $_SESSION['id_usuario']
    ]);
    return $query->fetchColumn();
}

function generarHtmlEstrellas($valoracionMedia) {
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $valoracionMedia) {
            $html .= '<i class="fas fa-star"></i>';
        } elseif ($i - $valoracionMedia < 1) {
            $html .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $html .= '<i class="far fa-star"></i>';
        }
    }
    return $html;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="listado.css">
</head>
<body>
    <div class="user-info">
        <button>Usuario: <?php echo $_SESSION['usuario']?><br><br><a href="logout.php">Cerrar Sesión</a></button>
    </div>
    <h1>Libros</h1>

    <div id="libros">
        <?php foreach ($libros as $libro): 
            $valoracion = obtenerValoracion($libro['id_libro']);
            $valoracionMedia = $valoracion['media'] ? round($valoracion['media'], 1) : 0;
            $totalVotos = $valoracion['total_votos'] ?: 0;
            $votoUsuario = obtenerVotoUsuario($libro['id_libro']);
        ?>
            <div class="libro" id="libro-<?php echo $libro['id_libro']; ?>">
                <h2><?php echo htmlspecialchars($libro['nombre']); ?></h2>
                <div id="estrellas-<?php echo $libro['id_libro']; ?>">
                    <?php echo generarHtmlEstrellas($valoracionMedia); ?> 
                    <span> (<?php echo $totalVotos; ?> votos)</span>
                </div>

                <div>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <button class="votar-btn" onclick="votarLibro(<?php echo $libro['id_libro']; ?>, <?php echo $i; ?>)">
                            <?php echo $i; ?> estrella<?php echo ($i > 1) ? 's' : ''; ?>
                        </button>
                    <?php endfor; ?>

                    <div id="borrarBoton-<?php echo $libro['id_libro']; ?>">
                        <?php if ($votoUsuario): ?>
                            <button class="borrar-voto-btn" id="borrar-voto-btn-<?php echo $libro['id_libro']; ?>" onclick="borrarVoto(<?php echo $libro['id_libro']; ?>)">
                                Eliminar voto
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<script src="app.js"></script>
</body>
</html>
