<?php

// function userFarmacos($cli)
// {
//   include_once "includes/conexion.php";

//   //Leer de la BD y obtener los datos del usuario x farmacos
//   $consulUserFarmacos = $pdo->prepare("SELECT *
//     FROM usuarios,farmacousuarios,farmacos
//     WHERE farmacousuarios.ciUsuario=usuarios.ciUsuario AND farmacousuarios.codFarmaco=farmacos.codFarmaco
//     AND usuarios.ciUsuario=?");
//   $consulUserFarmacos->execute(array($cli));
//   $userFarmacos = $consulUserFarmacos->fetchAll();
//   return $userFarmacos;
// };
