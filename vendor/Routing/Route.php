<?php
namespace Routing;
use Config\ConfigRepository as config;
use Http\Request;
use AWC\Application;
class Route Implements RouteInterFace{
  /**
  * the Application Instance
  *
  * @var AWC\Application
  */
  private $app;
   /**
   * current route
   * @var string
   */
   private $route;
   /**
   * the instance of router
   *
   * @var Routing\Router
   */
   private $router;
   /**
   * set the controller details if it is array
   *
   * @var array
   */
   private $controllerDetails;
   /**
   * if the requested method type is post and request method is get then prevent access
   *
   * @var bool
   */
   private $requestShouldBePost = false;
   /**
   * save all routes to router container
   * @var array
   */
   private $routes = array();
   /**
   * set the route key to get the proper route
   * @var string
   */
   private $routeKey;
   /**
   * the current script name
   * @var string
   */
   private $script;
   /**
   * Full list of scripts for the whole website
   * @var array
   */
   private $scripts = array();
   /**
   * set the full controller class name
   * @var string
   */
   private $controller ;
   /**
   * set the controller file path
   *
   * @var string
   */
   private $file;
   /**
   * set the method name that will be used for the route
   *
   * @var string
   */
   private $method = 'index';
   /**
   * set number of arguments that the methods expects to get
   *
   * @var int
   */
   private $expectedArgs = 0;

   /**
   * set number of arguments that we will get from the route
   *
   * @var int
   */
   private $numOfArgs = 0;
   /**
   * the args that might be used with methods
   *
   * @var array
   */
   private $args = array();
   /**
   * initialize the class and set the awc instance to awc attribute
   *
   * @param AWC\AWC $awc
   * @return void
   */
   public function __construct(Application $app)
   {
     $this->app = $app;
   }

   /**
   * initialize router and set main configuration for it
   *
   * @return void
   */
   public function initializeRouter()
   {
     $this->route = trim($this->app->request->get('route') , '/');

     $this->route = $this->route ? explode('/' , $this->route) : false;

     $this->setScript();

     $this->establishRoutes();

     $this->setRouteKey();

     $this->setRouteController();

     $this->setControllerMethod();

     $this->setControllerArguments();

   }

   /**
   * build the controller for the current route
   *
   * @return void
   */
   public function build()
   {
     $this->dispatch($this->file , $this->controller , $this->method , $this->args);
   }

   public function getCurrentScript()
   {
     return $this->script;
   }

   /**
   * set the current script of the given route
   *
   * @return void
   */
   private function setScript()
   {
     $this->scripts = $this->app->config['scripts'];

     if(!$this->route)
     {
       $this->script = $this->scripts['default'];
     }
     else
     {
       if(in_array($this->route[0] , array_keys($this->scripts)))
       {
         $this->script = $this->scripts[array_shift($this->route)];
       }
       else
       {
         $this->script = $this->scripts['default'];
       }

         $this->numOfArgs = count($this->route);
     }

     $this->app->define->set('SCRIPT' , ROOT . 'scripts' . DS . $this->script . DS);

   }

   /**
   * get the routes in the current script
   *
   * @return void
   */
   private function establishRoutes()
   {
     if(file_exists($file = SCRIPT . 'routes.php'))
     {
        $routes = require $file;

        $this->router = $router = new Router($routes);

        $this->routes = $router->getScriptRoutes();
     }
     else
     {
       die('Routes File Not found in ' . $file);
     }
   }

   /**
   * We'll now set the proper path for the current route
   *
   * @return void
   */
   private function setRouteKey()
   {
     if(!$this->route)
    {
      $this->routeKey = 'home';
    }
    else
    {
      // if the first element in the route not one of the given paths
      // then the routeKey will be home
      if(!array_key_exists($this->route[0] , $this->routes))
      {
        $this->routeKey = 'home';
      }
      else
      {
        $this->routeKey = array_shift($this->route);
        $this->numOfArgs--;
      }
    }
   }

   /**
   * set the controller and file path  for the given route
   *
   * @return void
   */
   private function setRouteController()
   {
     $this->controller = $this->routes[$this->routeKey]['controller'];
     $this->file       = SCRIPT . 'Controller' . DS . $this->controller . '.php';
   }

   /**
   * set the method for the controller of the current route
   *
   * @return void
   */
   private function setControllerMethod()
   {
     if(!$this->route) return;

     $currentRoute = $this->routes[$this->routeKey];

     $methods = isset($currentRoute['methods']) ? $currentRoute['methods'] : array();

     if(!$methods) return;

     foreach($methods AS $requestType => $requestMethods)
     {
       foreach($requestMethods AS $method)
       {
         if(is_array($method))
         {
           if($this->route[0] == $method[0])
           {
             $this->method = array_shift($this->route);

             $this->numOfArgs--;

             $this->expectedArgs = $method[1];

             if(strtoupper($requestType) == 'POST')
             {
               $this->requestShouldBePost = true;
             }
             break;
           }
         }
         else
         {
           if($this->route[0] == $method)
           {
             $this->method = array_shift($this->route);

             $this->numOfArgs--;

             if(strtoupper($requestType) == 'POST')
             {
               $this->requestShouldBePost = true;
             }
             break;
           }
         }
       }
     }
   }

   /**
   * set the arguments if it is given to current controller
   *
   * @return void
   */
   private function setControllerArguments()
   {
     if($this->method == 'index')
     {
       if(isset($this->routes[$this->routeKey]['only-args']) AND $this->routes[$this->routeKey]['only-args'] != $this->numOfArgs)
       {
         return $this->notFoundPage();
       }
     }
     else
     {
       if($this->numOfArgs != $this->expectedArgs)
       {
         return $this->notFoundPage();
       }
     }
     $this->args = $this->route;
   }

   /**
   * disatch the given controller
   *
   * @param string $file
   * @param string $controller
   * @param string $method
   * @param array $args
   * @return void
   */
   private function dispatch($file , $controller , $method , array $args)
   {
     if(file_exists($file = str_replace(array('/' , '\\')  , DS , $file)))
     {
       require $file;

       $className = ucfirst($this->script) . '\\' . $controller;

       $class = new $className($this->app);

       call_user_func_array(array($class , $method) , $args);

     }
   }




   /**
   * set not found controller for the current script
   *
   * @return void
   */
   private function notFoundPage()
   {
      $notFound = $this->router->getNotFound();

      if(!$notFound)
      {
        // if not found controller is not specified then we'll display the default not found page of the framework
        return;
      }

      if(is_array($notFound))
      {
        $this->controller = $notFound['controller'];
        $this->method     = $notFound['method'];
      }
      else
      {
        $this->controller = $notFound;
      }

      $this->file = SCRIPT . 'Controller' . DS . $this->controller . '.php';
   }
}