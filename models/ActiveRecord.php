<?php

namespace Model;

class ActiveRecord {

        //Base de datos
        protected static $db;
        protected static $columnasDB = [];
        protected static $tabla = "";   
    
        //Errores
        protected static $errores = [];
    
        //Definir la conexion a la base de datos
        public static function setDB($database) {
            self::$db = $database;
        }
    
        public function guardar() {
            $resultado = "";
            if( !is_null($this->id) ) {
                //Actualizar
                $this->actualizar();
    
            } else {
                //Creando un nuevo registro
                $resultado = $this->crear();
            }  
    
            return $resultado;
    
        }
    
        public function crear() {
    
            //Sanitizar la entrada de los datos
            $atributos = $this->sanitizarDatos();
    
            $string = join(', ', array_values($atributos));
    
                    //Insertar en la base de datos
                $columnas = join(', ',array_keys($atributos));
                $fila = join("', '",array_values($atributos));
                // debuguear($columnas);
                // debuguear($filas);
                     
                //*  Consulta para insertar datos
                $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ('$fila')";
                // debuguear($query);
    
        $resultado = self::$db->query($query);
    
        return $resultado;
    
        }
    
        public function actualizar() {
            //Sanitizar la entrada de los datos
            $atributos = $this->sanitizarDatos();
    
            $valores = [];
    
            foreach($atributos as $key => $value) {
                $valores[] = "{$key} = '$value'";
            }
    
            $query = " UPDATE " . static::$tabla . " SET ";
            $query .= join(", ", $valores );
            $query .= " WHERE id =  '" . self::$db->escape_string($this->id) . "' ";
            $query .= " LIMIT 1 ";
    
            $resultado = self::$db->query($query);
        
            if($resultado) {
                //Redireccionar al usuario
                header("Location: /bienesraices/admin/index.php?resultado=2");
            }
    
    
        }
    
        //Eliminar
        public function eliminar() {
            //Eliminar el registro
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . 
            self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);
    
            if($resultado) {
                $this->borrarImagen();
                header("Location: /bienesraices/admin/index.php?resultado=3");
            }
            
        }
    
        //Identificar y unir los atributos de la BD
        public function atributos() {
            $atributos = [];
            foreach(static::$columnasDB as $columna) {
                if($columna === "id") continue;
                $atributos[$columna] = $this->$columna; 
            }
            return $atributos;   
        }
    
        public function sanitizarDatos() {
            $atributos = $this->atributos();
            $sanitizado = [];
    
            foreach($atributos as $key => $value) {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
    
            return $sanitizado;
        }
    
        //Subida de archivos
        public function setImagen($imagen) {
            //Elimina la imagen previa
    
            if( !is_null($this->id) ) {
                $this->borrarImagen();
            }
    
    
            if($imagen) {
                //Asignar el atributo de imagen el nombre de la imagen
                $this->imagen = $imagen;
            }
        }
    
        //Eliminar el archivo
        public function borrarImagen() {
             //Comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
                 if($existeArchivo) {
                    unlink(CARPETA_IMAGENES . $this->imagen);
                    }
        }
    
        //Validacion
        public static function getErrores() {
            
            return static::$errores;
        }
    
        public function validar() {

            static::$errores = [];
            return static::$errores;
        }
    
        //Lista todos los registros
       public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
    
        $resultado = self::consultarSQL($query);
    
        return $resultado;
    
       }

       //Obtiene determinado numero de registros
       public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
    
        $resultado = self::consultarSQL($query);
    
        return $resultado;
    
       }
    
       //Busca una propiedad/registro por su id
       public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id ";
    
        $resultado = self::consultarSQL($query);
    
        return array_shift($resultado);
    
       }
    
    
       public static function consultarSQL($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query);
    
        //Iterar la base de datos
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
    
        //Liberar la memoria
        $resultado->free();
    
        //Retornar la base de datos
        return $array;
    
       }
    
       protected static function crearObjeto($registro) {
            $objeto = new static;
    
            foreach($registro as $key => $value) {
                if(property_exists( $objeto, $key )) {
                    $objeto->$key = $value;
                }
            }
    
        return $objeto;
       }
    
       // Sincronizar el objeto en memoria con los cambios realizados con el usuario
       public function sincronizar($args = []) {
            foreach($args as $key => $value) {
                if(property_exists($this, $key ) && !is_null($value) ) {
                    $this->$key = $value;
                }
            }
       }

}

