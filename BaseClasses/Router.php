<?php

namespace testFullStackDev\BaseClasses;

class Router
{
    /**
     * @var array
     */
    protected static $routes = [];

    /**
     * @param string $url
     * @param $callback
     * @return void
     */
    public static function get(string $url, $callback)
    {
        self::addRoute('GET', $url, $callback);
    }

    /**
     * @param string $url
     * @param $callback
     * @return void
     */
    public static function post(string $url, $callback)
    {
        self::addRoute('POST', $url, $callback);
    }

    /**
     * @param string $url
     * @param $callback
     * @return void
     */
    public static function put(string $url, $callback)
    {
        self::addRoute('PUT', $url, $callback);
    }

    /**
     * @param string $url
     * @param $callback
     * @return void
     */
    public static function delete(string $url, $callback)
    {
        self::addRoute('DELETE', $url, $callback);
    }

    /**
     * @param string $method
     * @param string $url
     * @param $callback
     * @return void
     */
    protected static function addRoute(string $method, string $url, $callback)
    {

        self::$routes[$method][$url] = [
            'callback' => $callback,
        ];
    }

    /**
     * @param string $url
     * @param $method
     * @return Response|void
     */
    public static function match(string $url, $method)
    {
        if (array_key_exists($method, self::$routes)) {
            foreach (self::$routes[$method] as $route => $routeData) {
                if (parse_url($url)['path'] === $route) {
                    $callback = $routeData['callback'];

                    if (!is_array($callback) && !is_string($callback)) {
                        return $callback();
                    } else {
                        $params = (new Request())->get_parameters();
                        if (!is_array($callback)) {
                            $callback = explode('@', 'testFullStackDev\app\controllers\\'.$callback);
                        }
                        $controller = $callback[0];
                        $action = $callback[1];
                        $controller_name = str_replace('testFullStackDev\app\controllers\\', '', $controller);

                        if(class_exists($controller)) {
                            $controller = new $controller();
                            if (method_exists($controller, $action)) {
                                $controller->$action($params);
                            } else {
                                return response()->json(['error'=>'That method '.$action.' does not exists in the '.$controller_name.'.'], 404);
                            }
                        } else {
                            return response()->json(['data'=>'That "'.$controller_name.'" does not exists.'], 404);
                        }
                    }
                    exit();
                }
            }
        }
        (new View())->render('notfoundpage/notfoundpage');
    }
}