<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    
    
    
        <link rel="stylesheet" href="css/tabla.css">
        <link rel="stylesheet" href="css/mainA2.css">
        
</head>
<body>
<header>
<h2>Registro de usuarios en el sistema</h2>
</header>
<hr>

<div class="usuarios-container">
 <div class="search-container">
         <label for="search">Buscar usuarios:</label>
         <input type="text" id="search" onkeyup="filtrarUsuarios()" placeholder="Ingrese nombre o apellido">
         <a href="#" class="btn-link" onclick="openRegistroUsuariosModal()">Registrar Nuevo Usuario</a> 
 </div>

<?php
include("php/conexion.php");

$consulta = "SELECT u.id_usuario, u.nombre, u.apellido, u.fechaNac, u.direccion, u.correo, u.telefono, u.estado, r.nombre_rol
FROM usuarios u
LEFT JOIN roles r ON u.id_usuario = r.id_usuario";
$resultado = $conn->query($consulta);

 $resultado = $conn->query($consulta);
 
 if (isset($resultado) && $resultado->num_rows > 0) {
echo '
    
        <table id="myTable">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>';

            while ($fila = $resultado->fetch_assoc()) {
                $idUsuario = $fila["id_usuario"];
                $estadoUsuario = $fila["estado"];
                $nombreRol = $fila["nombre_rol"];
    echo '<tr>
            <td>' . $fila["id_usuario"] . '</td>
            <td>' . $fila["nombre"] . '</td>
            <td>' . $fila["apellido"] . '</td>
            <td>' . $fila["fechaNac"] . '</td>
            <td>' . $fila["direccion"] . '</td>
            <td>' . $fila["correo"] . '</td>
            <td>' . $fila["telefono"] . '</td>
            <td>' . $fila["estado"] . '</td>
            <td>' . ($nombreRol ? $nombreRol : '<button onclick="openAsignarRolesModal(' . $idUsuario . ')">Asignar Rol</button>') . '</td>
            <td>';
            if ($estadoUsuario == 'habilitado') {
                echo '<button onclick="openDetallesUsuariosModal(' . $idUsuario . ')">Detalles</button>
                      <button onclick="openModificarUsuariosModal(' . $idUsuario . ')">Modificar</button>
                      <button onclick="openEliminarUsuariosModal(' . $idUsuario . ')">Eliminar</button>
                      <button onclick="openBajaUsuariosModal(' . $idUsuario . ')">Inhabilitar</button>';
            } else {
                echo '<button onclick="openDetallesUsuariosModal(' . $idUsuario . ')">Detalles</button>
                      <button onclick="openAltaUsuariosModal(' . $idUsuario . ')">Habilitar</button>';
            }
    
            echo '</td></tr>';
        }
    
        echo '</table>';
    } else {
        echo '<h2 style="text-align=center">No hay usuarios registrados</h2>';
    }
    
 $conn->close();
?>
</div>

</body>
</html>
