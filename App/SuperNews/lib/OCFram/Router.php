<?php
namespace OCFram;
class Router{
    protected $routes = [];
    const NO_ROUTE = 1;

    public function addRoute(Route $route){
        if(!in_array($route, $this->routes)){
            $this->routes[] = $route;
        }
    }
    public function getRoute($url){
        foreach($this->routes as $route){
            if(($varsValues = $route->match($url)) !== false ){
                if($route->hasVars()){
                    $varNames =  $route->varNames();
                    $listVars = [];

                    foreach($varValues as $key => $match){
                        if ($key !== 0){
                            $listVars[$varNames[$key - 1]] = $match;
                        }
                    }

                    $route->setVars($listVars);
                }
                return $route;
            }
        }
        throw new \RuntimeException('Aucune route ne correspond à l\'url ', self::NO_ROUTE);
    }
}