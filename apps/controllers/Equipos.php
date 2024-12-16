<?php

$path = __DIR__."\..\data\Equipos.json";

class Equipos{

    public function _construct() {

    }

    public function jsonToArray() {
        global $path;
        $jsonFich = file_get_contents($path);
        $json = json_decode($jsonFich, true);
        return $json;
    }

    //Muestra todos los equipos
    public function getAllTeams() {
            
        $resultado = array(
            'status' => 200,
            'descripcion' => 'Todos tus equipos',
            'equipos' => $this -> jsonToArray()
        );

        echo json_encode($resultado, http_response_code($resultado["status"]));
    }

    //Muestra todos los equipos seleccionados por el id
    public function getTeamById($id) {
        
        $equiposArray = $this -> jsonToArray();
        $equipoId;

        for($i = 0; $i < count($equiposArray); $i++) {
            if($i == $id) {
                $equipoId = $equiposArray[$i];
            }
        }

        $resultado = array(
            'status' => 200,
            'descripcion' => 'Equipo con id '. $id,
            'equipo' => $equipoId
        );

        echo json_encode($resultado, http_response_code($resultado["status"]));
    }

    //Crea un nuevo equipo
    public function createTeam() {
        
        global $path;
        $equiposArray = $this -> jsonToArray();
        $equipoNew = json_decode(file_get_contents('php://input'), true);
        array_push($equiposArray, $equipoNew);
        $equiposJson = json_encode($equiposArray);
        file_put_contents($path, $equiposJson);

        $resultado = array(
            'status' => 200,
            'descripcion' => 'Equipo nuevo creado'
        );

        echo json_encode($resultado, http_response_code($resultado["status"]));
    }

    //Modifica el equipo con el id especificado
    public function updateTeam($id) {

        global $path;
        $equiposArray = $this -> jsonToArray();

        for($i = 0; $i < count($equiposArray); $i++) {
            if($i == $id) {
                $equiposArray[$i] = json_decode(file_get_contents('php://input'), true);
            }
        }

        $equiposJson = json_encode($equiposArray);
        file_put_contents($path, $equiposJson);

        $resultado = array(
            'status' => 200,
            'descripcion' => "Equipo con id $id modificado" 
        );

        echo json_encode($resultado, http_response_code($resultado["status"]));
    }

    //Elimina el equipo con el id especificado
    public function deleteTeam($id){
        
        global $path;
        $equiposArray = $this -> jsonToArray();

        for($i = 0; $i < count($equiposArray); $i++) {
            if($i == $id) {
                array_splice($equiposArray, $i, 1);
            }
        }

        $equiposJson = json_encode($equiposArray);
        file_put_contents($path, $equiposJson);

        $resultado = array(
            'status' => 200,
            'descripcion' => "Equipo con id $id borrado" 
        );

        echo json_encode($resultado, http_response_code($resultado["status"]));
    }
}

?>