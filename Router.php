<?php
namespace MVC;

class Router {

    // Propiedades para almacenar rutas GET y POST
    public $rutasGET = [];
    public $rutasPOST = [];

    // Método para definir una ruta GET
    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    // Método para definir una ruta POST
    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }
    
    // Método para comprobar y manejar las rutas
    public function comprobarRutas() {

        session_start();

        $auth = $_SESSION["login"] ?? null;

        //Arreglo de rutas protegidas
        $rutas_protegidas = ["/admin", "/propiedades/crear", "/vendedores/crear", "/propiedades/actualizar", "/vendedores/actualizar", "/propiedades/eliminar", "/vendedores/eliminar"];

        // Obtener la URL actual y el método de la solicitud
        $urlActual = $_SERVER["PATH_INFO"] ?? "/";
        $metodo = $_SERVER["REQUEST_METHOD"];

        if ($metodo === "GET") {
            // Buscar la función asociada a la URL actual
            $fn = $this->rutasGET[$urlActual] ?? NULL;
        } else {
            // Buscar la función asociada a la URL actual
            $fn = $this->rutasPOST[$urlActual] ?? NULL;
        }

        //Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header("Location: /");
        }

        if ($fn) {
            // Si la función existe, ejecutarla pasando la instancia actual del router
            call_user_func($fn, $this);
        } else {
            // Mostrar "Página no encontrada" si la URL no coincide con ninguna ruta
            echo "Página no encontrada";
        }
    }

    // Método para renderizar una vista
    public function render($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value; // Con el doble signo transforma la propiedad del arreglo en una variable
        }

        // Almacenar la vista en el búfer de salida
        ob_start();
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpiar el búfer

        // Incluir el diseño común y agregar la vista al diseño
        include __DIR__ . "/views/layout.php";
    }
}
?>
