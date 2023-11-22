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
    <h2>Registro de roles en el sistema</h2>
</header>
<hr>

<div class="usuarios-container">
    <div class="search-container">
        <label for="search">Buscar roles:</label>
        <input type="text" id="search" onkeyup="filtrarUsuarios()" placeholder="Ingrese nombre ">
    </div>

    <?php
    include("php/conexion.php");

    $consulta = "SELECT roles.id_roles, roles.nombre_rol, roles.descripcion_rol,
    usuarios.id_usuario, usuarios.nombre, usuarios.apellido,
    GROUP_CONCAT(permisos.nombre_permiso ORDER BY permisos.nombre_permiso ASC) as permisos_asignados
    FROM roles
    JOIN usuarios ON roles.id_usuario = usuarios.id_usuario
    LEFT JOIN per_rol ON roles.id_roles = per_rol.id_roles
    LEFT JOIN permisos ON per_rol.id_permisos = permisos.id_permisos
    GROUP BY roles.id_roles;";
    $resultado = $conn->query($consulta);
    
    if (isset($resultado) && $resultado->num_rows > 0) {
        echo '
            
        <table id="myTable">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Id Usuario</th>
                <th>Usuario</th>
                <th>Permisos</th>
                <th>Acciones</th>
            </tr>';

        while ($fila = $resultado->fetch_assoc()) {
            $idRol = $fila["id_roles"];
            echo '<tr>
                    <td>' . $fila["id_roles"] . '</td>
                    <td>' . $fila["nombre_rol"] . '</td>
                    <td>' . $fila["descripcion_rol"] . '</td>
                    <td>' . $fila["id_usuario"] . '</td>
                    <td>' . $fila["nombre"] . ' ' . $fila["apellido"] . '</td>
                    <td>' . $fila["permisos_asignados"] . '</td>
                    <td>
                        <button onclick="openDetallesRolModal(' . $idRol . ')">Detalles</button>
                        <button onclick="openModificarRolModal(' . $idRol . ')">Modificar</button>
                        <button onclick="openEliminarRolModal(' . $idRol . ')">Eliminar</button>
                        <br>
                        <button onclick="openEliminarPermisosModal(' . $idRol . ')">Eliminar permisos</button>
                        <br>
                        <button onclick="openAsignarPermisosModal(' . $idRol . ')">Asignar Permisos</button>
                    </td>
                </tr>';
        }

        echo '</table>';
    } else {
        echo '<h2 style="text-align=center">No hay Pacientes registrados</h2>';
    }
    
    $conn->close();
    ?>
</div>

</body>
</html>
