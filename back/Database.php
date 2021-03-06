<?php
include "./Controlador.php";
include_once "./IDataBase.php";
class Database implements IDataBase
{
    private $conexion;
    private $controlador;

    private const SERVIDOR_BD = "localhost";
    private const NOMBRE_BD = "healthylife";
    private const USUARIO_BD = "GameMaster";
    private const CONTRASENA_BD = "gamemaster2022DWES";

    public function conectar()
    {
        try {
            $this->conexion = new PDO("mysql:host=". self::SERVIDOR_BD . ";dbname=" . self::NOMBRE_BD, self::USUARIO_BD, self::CONTRASENA_BD);
            $this->conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conexion->exec("set names utf8mb4");
            return $this->conexion;
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
            exit();
        }
    }

    public function desconectar()
    {
        $this->conexion = null;
    }

    /**
     * ejecutarSql()
     * 
     * @param String $sql
     * 
     * @return Array $resultado
     */
    public function ejecutarSql($valor)
    {
        $resultado = "";
            $this->conexion = $this->conectar();
            try {
                $resultado = $this->conexion->query($valor);
            } catch (PDOException $e) {
                var_dump("Error en la consulta: ".$e->getMessage());
            } 
            return $resultado;
    }

    public function devolverObjeto()
    {
        $this->controlador = new Controlador();
        $solicitud = $this->controlador->getSolicitud();
        return $solicitud;
    }

    public function ejecutarSqlActualizacion($sql, $args)
        {
            $this->conexion = $this->conectar();
            try {
                $resultado = $this->conexion->prepare($sql);
                $resultado->execute($args);
            } catch (PDOException $e) {
                var_dump("Error en la consulta: ".$e->getMessage());
            } 
        }
}
