<?php 

define("TEMPLATES_URL", __DIR__ . "/templates");
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMAGENES", $_SERVER["DOCUMENT_ROOT"] . "/imagenes/");


function incluirTemplates( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php"; 
}

function estaAutenticado() {
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if(!$_SESSION["login"]) {
        header("Location: /bienesraices/index.php");
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapar/sanitizar el HTML
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ["vendedor", "propiedad"];

    return in_array($tipo, $tipos);
}

//Muestra los mensajes
function mostrarNotificaciones($codigo) {
    $mensaje = "";

    switch($codigo) {
        case 1:
            $mensaje = "Creado Correctamente";
            break;
        case 2:
            $mensaje = "Actualizado Correctamente";
            break;
        case 3:
            $mensaje = "Eliminado Correctamente";
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function reedireccionar(string $url) {
    //Validar la URL por ID válida
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
    header("Location: {$url}");
    }

    return $id;
}