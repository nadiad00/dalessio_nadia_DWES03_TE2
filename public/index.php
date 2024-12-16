<?php 

require '../apps/core/Router.php';
require '../apps/controllers/Pokemons.php';
require '../apps/models/PokemonsModel.php';
require '../apps/controllers/Equipos.php';


$url = $_SERVER['QUERY_STRING'];
echo 'URL = ' .$url. '<br>';



$router = new Router();

$router->add('/public/pokemons/', array(
    'controller' => 'Pokemons',
    'action' => 'getAllPokemon'
));

$router->add('/public/pokemons/get/', array(
    'controller' => 'Pokemons',
    'action' => 'getAllPokemon'
));

$router->add('/public/pokemons/get/{tipo}/', array(
    'controller' => 'Pokemons',
    'action' => 'getPokemonByType'
));

$router->add('/public/pokemons/get/{gen}/', array(
    'controller' => 'Pokemons',
    'action' => 'getPokemonByGen'
));

$router->add('/public/equipos/', array(
    'controller' => 'Equipos',
    'action' => 'getAllTeams'
));

$router->add('/public/equipos/get/', array(
    'controller' => 'Equipos',
    'action' => 'getAllTeams'
));

$router->add('/public/equipos/get/{id}/', array(
    'controller' => 'Equipos',
    'action' => 'getTeamById'
));

$router->add('/public/equipos/post/', array(
    'controller' => 'Equipos',
    'action' => 'createTeam'
));

$router->add('/public/equipos/put/{id}/', array(
    'controller' => 'Equipos',
    'action' => 'updateTeam'
));

$router->add('/public/equipos/delete/{id}/', array(
    'controller' => 'Equipos',
    'action' => 'deleteTeam'
));

$urlParams = explode('/', $url);

$urlArray = array(
    'HTTP' => $_SERVER['REQUEST_METHOD'],
    'path' => $url,
    'controller' => '',
    'action' => '',
    'params' => ''

);

if(!empty($urlParams[2])){
    
    $urlArray['controller'] = ucwords($urlParams[2]);

    if(!empty($urlParams[3])) {
        $urlArray['action'] = $urlParams[3];
        if(!empty($urlParams[4])) {
            $urlArray['params'] = $urlParams[4];
        }
    } else {
        $urlArray['action'] = 'get';
    }
} else {
    $urlArray['controller'] = 'Pokemons';
    $urlArray['action'] = 'getAllPokemon';
}

if($router->matchRoute($urlArray)) {

        $params = [];
        $params[] = $urlArray['params'] ?? null;

        $controller = $router->getParams()['controller'];
        $action = $router->getParams()['action'];
        $controller = new $controller();

        if(method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            $resultado = array (
                'status' => 400,
                'error' => 'El metodo no existe'
            );
        
            echo json_encode($resultado, http_response_code($resultado["status"]));
        }

} else {
    $resultado = array (
        'status' => 404,
        'error' => 'Ruta no encontrada'
    );

    echo json_encode($resultado, http_response_code($resultado["status"]));
}

?>