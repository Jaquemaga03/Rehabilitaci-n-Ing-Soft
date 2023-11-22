<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.html');
    exit();
}

include("php/conexion.php");

$consultaUsuario = "SELECT r.nombre_rol, u.nombre, u.apellido 
                    FROM usuarios u
                    JOIN roles r ON u.id_usuario = r.id_usuario
                    WHERE u.id_usuario = " . $_SESSION['id_usuario'];

$resultadoUsuario = $conn->query($consultaUsuario);

if ($resultadoUsuario->num_rows > 0) {
    $datosUsuario = $resultadoUsuario->fetch_assoc();
    $nombreRol = $datosUsuario['nombre_rol'];
    $nombreUsuario = $datosUsuario['nombre'];
    $apellidoUsuario = $datosUsuario['apellido'];
} else {
    $nombreRol = "Sin Rol Asignado";
    $nombreUsuario = "";
    $apellidoUsuario = "";
}

$consulta = "SELECT p.id_permisos, p.nombre_permiso, p.descripcion_permiso
FROM usuarios u
JOIN roles r ON u.id_usuario = r.id_usuario
JOIN per_rol pr ON r.id_roles = pr.id_roles
JOIN permisos p ON pr.id_permisos = p.id_permisos
WHERE u.id_usuario = " . $_SESSION['id_usuario'];

$resultado = $conn->query($consulta);

if ($resultado->num_rows > 0) {
    $_SESSION['permisos'] = [];
    while ($fila = $resultado->fetch_assoc()) {
        $_SESSION['permisos'][] = $fila['nombre_permiso'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-..."
        crossorigin="anonymous">
    <link rel="stylesheet" href="css/mainA.css">
</head>
<body>

<div class="admin-container">
    <nav>
        <div class="user-profile">
            <img src="img/user.PNG" alt="Foto de usuario">
        </div>

        <?php
        if ($_SESSION['permisos']) {
            echo '<h2 id="welcomeMessage">Bienvenido, ' . $nombreRol . ' ' . $nombreUsuario . ' ' . $apellidoUsuario . '</h2>';
            echo '<br>';
            echo '<br>';
            echo '<h2><a onclick="cargarContenido(\'mainAdmin2.php\')">Panel de Administración</a></h2>';
            echo '<ul>';

            if (in_array('CRUD Usuarios', $_SESSION['permisos'])) {
                echo '<li><a onclick="cargarContenido(\'usuarios.php\')"><i class="fas fa-users"></i> Usuarios</a></li>';
            }

            if (in_array('CRUD Roles', $_SESSION['permisos'])) {
                echo '<li><a onclick="cargarContenido(\'roles.php\')"><i class="fas fa-user-tag"></i> Roles</a></li>';
            }

            if (in_array('CRUD Permisos', $_SESSION['permisos'])) {
                echo '<li><a onclick="cargarContenido(\'permisos.php\')"><i class="fas fa-lock"></i> Permisos</a></li>';
            }

            if (in_array('CRUD Pacientes', $_SESSION['permisos'])) {
                echo '<li><a onclick="cargarContenido(\'pacientes.php\')"><i class="fas fa-user-injured"></i> Pacientes</a></li>';
            }

            if (in_array('CRUD Ejercicios', $_SESSION['permisos'])) {
                echo '<li><a onclick="cargarContenido(\'ejercicios.php\')"><i class="fas fa-dumbbell"></i> Ejercicios</a></li>';
            }

            if (in_array('CRUD Rutinas', $_SESSION['permisos'])) {
                echo '<li><a onclick="cargarContenido(\'rutinas.php\')"><i class="fas fa-calendar-alt"></i> Rutinas</a></li>';
            }

            echo '<li><a href="php/cerrarSesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<p><b>@AjustaTec.</b></p>';
            echo '<p>Todos los derechos reservados.</p>';
            echo '</ul>';
        } else {
            echo '<h2 id="welcomeMessage">Sin rol asignado</h2>';
        }
        ?>
    </nav>
    <div id="contenido-derecho">
        
    </div>
</div>

<script src="js/cargarCont.js"></script>
<script src="js/busqueda.js"></script>
<script src="js/modal.js"></script>

</body>
</html>
