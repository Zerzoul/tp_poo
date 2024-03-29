<?php
namespace OCFram;
abstract class Application{
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $user;
    protected $config;

    public function __construct(){
        $this->httpRequest = new HTTPRequest;
        $this->httpResponse = new HTTPResponse;
        $this->user = new User;
        $this->config = new Config;
        $this->name = '';
    }
    public function getController(){
        $router = new Router;
        $xml =  new \DOMDocument;
        $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');
        $routes = $xml->getElementByTagName('route');

        foreach($routes as $route){
            $vars = [];
            if( $route->hasAttribute('vars')){
                $vars = explode(',', $route->getAttribute('vars'));
            }
            
            $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
        }
        try {
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        } catch(\RuntimeException $e){
            if($e->getCode() == Router::NO_ROUTE){
                $this->httpResponse->redirect404();
            }
        }
        $_GET = array_merge($_GET, $matchedRoute->vars());

        $controlerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }


    abstract public function run();
    public function httpRequest(){
        return $this->httpRequest;
    }
    public function httpResponse(){
        return $this->httpResponse;
    }
    public function name(){
        return $this->name;
    }
}