<?php

    

    class Pokemons{
        public function __construct() {

        }

        public function jsonToArray() {
            $path = __DIR__."\..\data\Pokemons.json";
            
            $jsonFich = file_get_contents($path);
            $json = json_decode($jsonFich, true);
            return $json;
        }
        

        //Muestra todos los pokémon
        public function getAllPokemon() {
            
            $resultado = array(
                'status' => 200,
                'descripcion' => 'Todos los Pokemon',
                'pokemon' => $this -> jsonToArray()
            );

            echo json_encode($resultado, http_response_code($resultado["status"]));
        }

        //Muestra todos los pokémon del tipo seleccionado
        public function getPokemonByType($tipo) {
            
            $pkmArray = $this -> jsonToArray();
            $pkmTipo = array();

            for($i = 0; $i < count($pkmArray); $i++) {
                $obj = $pkmArray[$i];
                $tipos = $obj['type'];

                foreach($tipos as $tp) {
                    if(strtoupper($tp) == strtoupper($tipo)) {
                        $pkmTipo[$i] = $obj;
                    }
                }
            }

            $resultado = array (
                'status' => 200,
                'descripcion' => "Todos los Pokemon de tipo $tipo",
                'pokemon' => $pkmTipo
            );

            echo json_encode($resultado, http_response_code($resultado["status"]));
        }

        //Muestra todos los pokémon de la generación seleccionada
        public function getPokemonByGen($gen) {

            $pkmArray = $this -> jsonToArray();
            $pkmGen = array();

                for($i = 0; $i < count($pkmArray); $i++) {
                    $obj = $pkmArray[$i];

                    if($gen == $obj['generation']) {
                        $pkmGen[$i] = $obj;
                    }
                }

                $resultado = array (
                    'status' => 200,
                    'descripcion' => 'Todos los Pokemon de generacion '. $gen,
                    'pokemon' => $pkmGen
                );

            echo json_encode($resultado, http_response_code($resultado["status"]));
        }
    }

?>