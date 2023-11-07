<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear(Router $router) {
        $vendedor = new Vendedor;

        $errores = Vendedor::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            //Crear nueva instancia
            $vendedor = new Vendedor($_POST["vendedor"]);
        
            //Validar errores
            $errores = $vendedor->validar();
        
            //No hay errores 
            if(empty($errores)) {
            
                //Guarda en la base de datos
                $resultado = $vendedor->guardar();
            
            
                if($resultado) {
                    //Redireccionar al usuario con mensaje de exito
            
                    header("Location: /admin?resultado=1");
                    }   
                }
        }

        $router->render("vendedores/crear", [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);

    }

    public static function actualizar(Router $router) {
        $id = reedireccionar("/admin");
    
        $vendedor = Vendedor::find($id);
    
        //Arreglo con mensajes de error
        $errores = Vendedor::getErrores();
    
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
        //Asignar atributos
        $args = $_POST["vendedor"];

        //Sincronizar
        $vendedor->sincronizar($args);

        //Validacion 
        $errores = $vendedor->validar();

        //Revisar que el arreglo de errores este vacio
        if (empty($errores)) {
        $vendedor->guardar();
        header("Location: /admin?resultado=2");
        }
    
    }

    $router->render("vendedores/actualizar", [
        "vendedor" => $vendedor,
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
            
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
                header("Location: /admin?resultado=3");
            

}
}
}
}
}

?>