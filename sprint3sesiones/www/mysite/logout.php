<?php
session_start();  // Inicia la sesión

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario al login
header('Location: login.html');  // O login.php si tu página de login está escrita en PHP
exit();  // Asegura que no se ejecute más código
?>


