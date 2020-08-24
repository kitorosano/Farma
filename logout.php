<?php
session_start();

$_SESSION = array(); //reinicializamos el array de todas las sesiones de la pagweb

session_destroy(); //destruid al usuario/session

header('Location: .');
