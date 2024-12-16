<?php

class Router{

    protected $routes = array();
    protected $params = array();

    public function add($route, $params) {
        $this->routes[$route] = $params;
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function getParams() {
        return $this->params;
    }

    public function matchRoute($url) {

        foreach($this->routes as $route => $params) {
            if($url['controller'] == "Pokemons") {
                if(str_contains($route, '{tipo}')) {
                    $pattern = str_replace(['{tipo}', '/'], ['(acero|agua|bicho|dragon|electrico|fantasma|fuego|hada|hielo|lucha|normal|planta|psiquico|roca|siniestro|tierra|veneno|volador)', '\/'], $route);
                    $pattern = '/^' . $pattern . '$/i';

                    if(preg_match($pattern, $url['path'])) {
                        $this->params = $params;
                        return true;
                    }

                } elseif(str_contains($route, '{gen}')) {
                    $pattern = str_replace(['{gen}', '/'], ['([0-9])', '\/'], $route);
                    $pattern = '/^' . $pattern . '$/';

                    if(preg_match($pattern, $url['path'])) {
                        $this->params = $params;
                        return true;
                    }
                }
            }
                
            $pattern = str_replace(['{id}', '/'], ['([0-9]+)', '\/'], $route);
            $pattern = '/^' . $pattern . '$/';

            if(preg_match($pattern, $url['path'])) {
                $this->params = $params;
                return true;
            }
        }

        return false;
    }
}

?>