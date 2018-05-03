<?php


class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $queries = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
        $this->makeQueries();
    }

    /**
     * Permettra de capturer l'url avec les paramètre
     * get('/posts/:slug-:id') par exemple
     **/
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        return true;
    }

    public function call(){
        if(is_string($this->callable)){
            $params = explode('#', $this->callable);
            $controller = $params[0] . "Controller";
            $reflection = new ReflectionClass($controller);
            if (null != $reflection->getConstructor()) {
                $cparams = $reflection->getConstructor()->getParameters();
                if (0 !== $cparams) {
                    $controller = new $controller($this->queries);
                } else {
                    $controller = new $controller();
                }
            }
            else {
                $controller = new $controller();
            }
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this; // On retourne tjrs l'objet pour enchainer les arguments
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    public function makeQueries()
    {
        foreach ($_REQUEST as $one => $value) {
            if ("url" !== $one) {
                $this->queries[$one] = $value;
            }

        }
    }

    public function getQueries(){
        return ($this->queries);
    }



}