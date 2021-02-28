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
    public function add($slug, $params){

        
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

        // even if user adds '/' it will found the route
        if($slug[-1] == '/'){
            $slug = rtrim($slug, '/');
        }

        if( array_key_exists($slug, $this->routes) ){
            $this->params = $this->routes[$slug];
            return true;
        }

        /**
         * we are gonna support controller/action way also
         * so if slug is not found, we are gonna looking for controller/action in our routem
         */

        $regExp = '/^(?P<controller>[a-zA-Z -]+)\/(?P<action>[a-zA-Z -]+)$/';
        if(preg_match($regExp, $slug, $matches)){

            $this->params = $matches;
            return true;
        }

        // no route found
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