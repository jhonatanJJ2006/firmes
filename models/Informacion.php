<?php

namespace Model;

class Informacion extends ActiveRecord {
    protected static $tabla = 'informacion';
    protected static $columnasDB = ['id', 'nombre', 'imagen', 'sinopsis', 'genero', 'token', 'actores', 'clasificacion', 'fecha'];

    public $id;
    public $nombre;
    public $imagen;
    public $sinopsis;
    public $genero;
    public $token;
    public $actores;
    public $clasificacion;
    public $fecha;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->sinopsis = $args['sinopsis'] ?? '';
        $this->genero = $args['genero'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->actores = $args['actores'] ?? '';
        $this->clasificacion = $args['clasificacion'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }    
}