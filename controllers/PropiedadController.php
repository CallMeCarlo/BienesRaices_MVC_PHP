<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        //Muestra mensaje condicional 
        $resultado = $_GET["resultado"] ?? null;

        //Manda la ruta del archivo de admin al método render
        $router->render("propiedades/admin", [
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        //Arreglo con mensajes de error
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
                
    //Crea una nueva instancia
    $propiedad = new Propiedad($_POST);    
    
    // Generar nombre único
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Setear la imagen
    //Realiza un resize a la imagen con intervention
    if($_FILES["imagen"]["tmp_name"]) {
        $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,600);
        $propiedad->setImagen($nombreImagen);
    }
    
    //Validar errores
    $errores = $propiedad->validar();

    //Revisar que el arreglo de errores este vacio
    if(empty($errores)) {

    //Crear la carpeta para guardar imaganes
    if(!is_dir(CARPETA_IMAGENES)) {
        mkdir(CARPETA_IMAGENES);
    }

    //Guarda la imagen en el servidor
    $image->save(CARPETA_IMAGENES . $nombreImagen);

    //Guarda en la base de datos
    $resultado = $propiedad->guardar();


    if($resultado) {
        //Redireccionar al usuario con mensaje de exito

        header("Location: /admin");
        }   
    }  else {
        $titulo = $propiedad->titulo;
        $precio = $propiedad->precio;
        $descripcion = $propiedad->descripcion;
        $habitaciones = $propiedad->habitaciones;
        $wc = $propiedad->wc;
        $estacionamiento = $propiedad->estacionamiento;
        $vendedorID = $propiedad->vendedores_id;
    }

        }

        $router->render("propiedades/crear", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router) {

        $id = reedireccionar("/admin");

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        //Arreglo con mensajes de error
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            //Asignar atributos
            $args = [];
            $args["titulo"] = $_POST["titulo"] ?? null;
            $args["precio"] = $_POST["precio"] ?? null;
            $args["descripcion"] = $_POST["descripcion"] ?? null;
            $args["habitaciones"] = $_POST["habitaciones"] ?? null;
            $args["wc"] = $_POST["wc"] ?? null;
            $args["estacionamiento"] = $_POST["estacionamiento"] ?? null;
            $args["imagen"] = $_POST["imagen"] ?? null;
            $args["vendedordes_id"] = $_POST["vendedores_id"] ?? null;
        
            $propiedad->sincronizar($args);
        
            //Validacion 
            $errores = $propiedad->validar();
        
                // Subida de archivos
            if ($_FILES["imagen"]["tmp_name"]) {
                // Si se cargó una nueva imagen
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            } else {
                // Si no se cargó una nueva imagen, mantener la imagen original
                $nombreImagen = $propiedad->imagen;
            }
        
            // Revisar que el arreglo de errores esté vacío
            if (empty($errores)) {
                // Almacenar la imagen solo si se cargó una nueva
                if ($_FILES["imagen"]["tmp_name"]) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
        
                $propiedad->guardar();
                header("Location: /admin?resultado=2");
            }
            }
            

        $router->render("/propiedades/actualizar", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            
            if($id) {

                $tipo = $_POST["tipo"];
        
                if(validarTipoContenido($tipo)) {
                
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                    header("Location: /admin?resultado=3");
                

}
}
}
    }
}


?>