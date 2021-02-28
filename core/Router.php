<?php
namespace Zarten\Core;

/**
 * Manages routing of system.
 */
class Router{
    
    /**
     * @var array
     * holds all routes (routing table)
     */
    protected $routes = [];

    /**
     * @var array
     * holds parameters of current matching route
     */
    protected $params = [];

    /**
     * Add a route to routing table
     * 
     * @param string $slug the slug of url
     * 
     * @param array parameters of that url like controller, action and other vars
     * 
     * @return void
     */
    public function add($slug, $params = []){

        // convert route to regular expression
        $slug = preg_replace('/\//', '\\/', $slug);
        // convert variables
        $slug = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z- ]+)', $slug);
        // convert variables with custom variable expressions
        $slug = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2+)', $slug);
        // start and end delimeters
        $slug = '/^' . $slug . '$/i';
        $this->routes[$slug] = $params;
    }

    /**
     * Get all routes from the routing table
     * @return array
     */
    public function getRoutes(){

        return $this->routes;
    }

    /**
     * Match route from routing table
     */
    public function match($slug){

        /**
         * we are gonna do controller/action way 
         * we are gonna looking for controller/action in our routem
         */

        foreach($this->routes as $route => $params){
            if(preg_match($route, $slug, $match)){
                // if matching route founds
                // get named capture group values
                foreach($match as $key => $value){
                    if(is_string($key)){
                        $params[$key] = $value;
                    }
                }
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * get params of currently matched route
     * 
     * @return array
     */
    public function getParams(){
        return $this->params;
    }
}