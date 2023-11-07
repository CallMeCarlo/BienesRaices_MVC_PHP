<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "inicio" => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render("paginas/nosotros");
    }

    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();

        $router->render("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = reedireccionar("/");

        $propiedad = Propiedad::find($id);

        $router->render("paginas/propiedad", [
            "propiedad" => $propiedad
        ]);
    }

    public static function blog(Router $router) {
        $router->render("paginas/blog");
    }

    public static function entrada(Router $router) {
        $router->render("paginas/entrada");
    }


    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $respuesta = $_POST["contacto"];
            
            //Crear una instancia de phpmailer
            $mail = new PHPMailer();

            //Configuramos SMTP *Protocolo de envio de emails
            $mail->isSMTP();
            $mail->Host = $_ENV["EMAIL_HOST"];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV["EMAIL_USER"];
            $mail->Password = $_ENV["EMAIL_PASS"];
            $mail->SMTPSecure = "tls"; //Emails por tunel seguro
            $mail->Port = $_ENV["EMAIL_PORT"];

            //Configurar el contenido del email
            $mail->setFrom("admin@bienesraices.com"); //Quien envia el email
            $mail->addAddress("admin@bienesraices.com", "BienesRaices.com"); //Quien recibe el email
            $mail->Subject = "Tienes un nuevo mensaje";

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";

            //Definir el contenido
            $contenido = "<html>";
            $contenido .= "<p>Tienes un nuevo mensaje!</p>";
            $contenido .= "<p>Nombre: " . $respuesta["nombre"] . "</p>";
            

            //Enviar de forma condicional emails o telefonos
            if($respuesta["contacto"] === "telefono") {
                $contenido .= "<p> Eligio ser contactado por telefono: </p>";
                $contenido .= "<p>Telefono: " . $respuesta["telefono"] . "</p>";
                $contenido .= "<p>Fecha de contacto: " . $respuesta["fecha"] . "</p>";
                $contenido .= "<p>Hora: " . $respuesta["hora"] . "</p>";

            } else { //Este es un email
                $contenido .= "<p> Eligio ser contactado por email: </p>";
                $contenido .= "<p>Email: " . $respuesta["email"] . "</p>";
            }


            $contenido .= "<p>Mensaje: " . $respuesta["mensaje"] . "</p>";
            $contenido .= "<p>¿Vende o Compra?: " . $respuesta["tipo"] . "</p>";
            $contenido .= "<p>¿Precio o Presupuesto?: $" . $respuesta["precio"] . "</p>";

            $contenido .= "</html>";

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es texto alternativo sin html";

            //Enviar el email
            if( $mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no pudo ser enviado";
            }

        }

        $router->render("paginas/contacto", [
            "mensaje" => $mensaje
        ]);
    }

}


?>