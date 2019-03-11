<?php
/**
 * App Core Class
 * Create URL & loads core controller
 * URL FORMAT - /controller/mathod/params
 */

class Core
{
   protected $currentController = 'Pages';
   protected $currentMethod = 'index';
   protected $params = [];

   public function __construct()
   {
   //   print_r($this->getUrl());
      $url = $this->getUrl();

      // Look in controllers for first value
      if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
         $this->currentController = ucwords($url[0]);
         unset($url[0]);
      }

      require_once '../app/controllers/' . $this->currentController . '.php';

      $this->currentController = new $this->currentController;

      // Check for second part of url
      if (isset($url[1])) {
         if (method_exists($this->currentController, $url[1])) {
            $this->currentMethod = $url[1];
         }
         unset($url[1]);
      }

      // Get param
      $this->params = $url ? array_values($url) : [];

      // Call a callback with array of param
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
   }

   public function getUrl()
   {
      if (isset($_SERVER['REQUEST_URI'])) {
         $url = rtrim($_SERVER['REQUEST_URI'], '/');
         $url = ltrim($url, '/');
         $url = filter_var($url, FILTER_SANITIZE_URL);
         $url = explode('/', $url);

         return $url;
      }
   }
}
