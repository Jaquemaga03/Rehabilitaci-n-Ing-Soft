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
<h2>Registro de permisos en el sistema</h2>
</header>
<hr>

<div class="usuarios-container">
 <div class="search-container">
         <label for="search">Buscar pacientes:</label>
         <input type="text" id="search" onkeyup="filtrarUsuarios()" placeholder="Ingrese nombre ">
 </div>

<?php
include("php/conexion.php");

 $consulta = "SELECT * FROM permisos";
 $resultado = $conn->query($consulta);
 
 if (isset($resultado) && $resultado->num_rows > 0) {
echo '
    
        <table id="myTable">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
              
                <th>Acciones</th>
            </tr>';

            while ($fila = $resultado->fetch_assoc()) {
                $idPermiso = $fila["id_permisos"];
            
    echo '<tr>
            <td>' . $fila["id_permisos"] . '</td>
            <td>' . $fila["nombre_permiso"] . '</td>
            <td>' . $fila["descripcion_permiso"] . '</td>
            <td>
                      <button onclick="openDetallesPermisosModal(' . $idPermiso . ')">Detalles</button>
            
            </td></tr>';
        }
    
        echo '</table>';
    } else {
        echo '<h2 style="text-align=center">No hay permisos registrados</h2>';
    }
    
 $conn->close();
?>
</div>

</body>
</html>
