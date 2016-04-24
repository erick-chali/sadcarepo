<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase de php encargada de manejar la conexion a la base de datos y la ejecucion
 * de las sentencias a la base de datos para las operaciones del repositorio
 *
 * @author Pablo Sao
 * @version 1.0.0
 * @Date 19 de abril de 2016
 */
class mysqlDB {
    
    private $connection;
    
    public function __construct() {

        $this->connection = mysqli_connect("198.71.225.58", "prepo", "Ty~vj773", "repositorio");
    }
    
    public function close(){
        mysqli_close($this->connection);
    }
            
    public function getAllUsuarios(){
        
        $query = 'select `u`.`codigo_usuario`,`p`.`descripcion` as pais ,`e`.`nombre` as empresa,`u`.`nombre` '.
                    ',`u`.`e_mail`,`u`.`usuario` ,`u`.`crea_contenido` ,`u`.`activo` from `usuario` as `u`'.
                    'inner join `empresas` as `e` on `u`.`codigo_empresa` = `e`.`codigo_empresa`'.
                    'inner join `paises` as `p` on `e`.`pais` = `p`.`codigo_pais`;';
        
        $result = mysqli_query($this->connection, $query) or die ('No se pudo seleccionar los usuarios. '. mysqli_error($this->connection));

        return $result;
    }
    
    
    public function getUsuario($usrID){
        $query = 'SELECT `codigo_usuario`, `codigo_empresa`,`nombre`,`e_mail`,`usuario`,`crea_contenido`,'.
		'`activo` FROM `usuario` WHERE `codigo_usuario` = '.$usrID.';';
        
        $result = mysqli_query($this->connection, $query) or die ('No se pudo seleccionar los usuarios. '. mysqli_error($this->connection));
        
        return json_encode($result);   
    }
}

?>