<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.html');
    exit();
}

include("php/conexion.php");

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

$permisosUsuario = isset($_SESSION['permisos']) ? $_SESSION['permisos'] : [];

$consultaTotalUsuarios = "SELECT COUNT(*) as total FROM usuarios";
$consultaTotalRoles = "SELECT COUNT(*) as total FROM roles";
$consultaTotalPermisos = "SELECT COUNT(*) as total FROM permisos";
$consultaTotalPacientes = "SELECT COUNT(*) as total FROM pacientes";
$consultaTotalEjercicios = "SELECT COUNT(*) as total FROM ejercicios";
$consultaTotalRutinas = "SELECT COUNT(*) as total FROM rutina";

$resultadoTotalUsuarios = $conn->query($consultaTotalUsuarios);
$resultadoTotalRoles = $conn->query($consultaTotalRoles);
$resultadoTotalPermisos = $conn->query($consultaTotalPermisos);
$resultadoTotalPacientes = $conn->query($consultaTotalPacientes);
$resultadoTotalEjercicios = $conn->query($consultaTotalEjercicios);
$resultadoTotalRutinas = $conn->query($consultaTotalRutinas);

$totalUsuarios = $resultadoTotalUsuarios->fetch_assoc()['total'];
$totalRoles = $resultadoTotalRoles->fetch_assoc()['total'];
$totalPermisos = $resultadoTotalPermisos->fetch_assoc()['total'];
$totalPacientes = $resultadoTotalPacientes->fetch_assoc()['total'];
$totalEjercicios = $resultadoTotalEjercicios->fetch_assoc()['total'];
$totalRutinas = $resultadoTotalRutinas->fetch_assoc()['total'];

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
    <link rel="stylesheet" href="css/mainA2.css">
</head>
<body>

<h2>Registro en el sistema</h2>
<hr>
<div class="dashboard">
<?php if (in_array('CRUD Usuarios', $permisosUsuario)) : ?>
    <div class="card">
        <i class="fas fa-users fa-3x"></i>
        <h3>Usuarios</h3>
        <p><?php echo $totalUsuarios; ?></p>
    </div>
<?php endif; ?>

<?php if (in_array('CRUD Roles', $permisosUsuario)) : ?>
    <div class="card">
        <i class="fas fa-user-tag fa-3x"></i>
        <h3>Roles</h3>
        <p><?php echo $totalRoles; ?></p>
    </div>
<?php endif; ?>

<?php if (in_array('CRUD Permisos', $permisosUsuario)) : ?>
    <div class="card">
        <i class="fas fa-lock fa-3x"></i>
        <h3>Permisos</h3>
        <p><?php echo $totalPermisos; ?></p>
    </div>
<?php endif; ?>

<?php if (in_array('CRUD Pacientes', $permisosUsuario)) : ?>
    <div class="card">
        <i class="fas fa-user-injured fa-3x"></i>
        <h3>Pacientes</h3>
        <p><?php echo $totalPacientes; ?></p>
    </div>
<?php endif; ?>

<?php if (in_array('CRUD Ejercicios', $permisosUsuario)) : ?>
    <div class="card">
        <i class="fas fa-dumbbell fa-3x"></i>
        <h3>Ejercicios</h3>
        <p><?php echo $totalEjercicios; ?></p>
    </div>
<?php endif; ?>

<?php if (in_array('CRUD Rutinas', $permisosUsuario)) : ?>
    <div class="card">
        <i class="fas fa-calendar-alt fa-3x"></i>
        <h3>Rutinas</h3>
        <p><?php echo $totalRutinas; ?></p>
    </div>
<?php endif; ?>
</div>
</body>
</html>
