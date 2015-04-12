<?php
namespace Session;
class SessionHandler{

  private $flashSessions = array();

   /**
   * Start a new session
   *
   * @return void
   */
   public function start()
   {
     $this->protectSession();
     if(!session_id())
     {
       session_start();
       session_regenerate_id();
     }
   }
  /**
  * destroy the whole session
  *
  * @return void
  */
  public function destroy()
  {
    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies"))
    {
      $params = session_get_cookie_params();

      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
    }
    // Finally, destroy the session.
    session_destroy();
  }
  /**
  * protect sessions from hijacking
  *
  * @return void
  */
  private function protectSession()
  {
    // set the path of the session for current scrip
    ini_set('session.cookie_path' , '/');  // => it will be edited again

    // only sessions will be stored in cookies
    ini_set('session.use_only_cookies' , 1);

    // use ssl mode => https if available
    ini_set('session.cookie_secure' , false); // it will be edited by SECURE constant

    // prevent javascript codes
    ini_set('session.cookie_httponly' , 1);

    // hash sessions by sha1
    ini_set('session.hash_function' ,  1);
  }
  
  /**
  * get all sessions
  * @return array
  */
  public function all()
  {
    return $_SESSION;
  }

  /**
  * Set Session
  * @param String $key
  * @param String or Array $value
  */
  public function set($key,$value){
      $_SESSION[$key] = $value;
  }
  /**
  * Set Session for one time only
  * @param String $key
  * @param String or Array $value
  * @return Void
  */
  public function flash($key,$value){
    array_push($this->flashSessions, $key);
    $this->set($key, $value);
  }

  /**
  * Retrieve Session Data 
  * Session Type (Flash , Regular)
  * @param String $key
  * @return Array or Int or String 
  */
  public function get($key){
    $session_key = array_search($key,$this->flashSessions);
    if(is_int($session_key)){
        $session = $_SESSION[$key];
        unset($_SESSION[$key]);
        unset($this->flashSessions[$session_key]);
    } else {
        if(isset($_SESSION[$key]))
          $session = $_SESSION[$key];
    }
    return isset($session) ? $session : false;
  }

  /**
  * Check if Session Exsist
  * @param String $key
  * @return boolean [ True or False ]
  */
  public function has($key)
  {
      return isset($_SESSION[$key]) ? true : false ;
  }

  /**
  * Remove Session Data
  * @param String $key
  */
  public function forget($key){
    if(isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
        return True;
    } else {
      return Null;
    }
  }

  /**
  * Remove All Flash Sessions
  * @return Void
  */
  public function reflash(){
      foreach ($this->flashSessions as $key => $value) {
        unset($_SESSION[$value]);
        unset($this->flashSessions[$key]);
      }
  }
  /**
  * Add Data To Session
  * @param String $key
  * @param String or Array $value
  * @return Void 
  */
  public function push($key,$value){
    if(!$this->has($key))
      return false;

    if(!is_array($_SESSION[$key]))
      $_SESSION[$key] = array($_SESSION[$key]);

      array_push($_SESSION[$key], $value);
  }

  /**
  * Remove Specific Value From Session 
  * @param String $key
  * @param String $value
  */
  public function pull($key,$value){
    if(!$this->has($key))
      return false;

    if(is_array($_SESSION[$key]))
      unset($_SESSION[$key][$value]);
  }
  /**
  * clean all Sessions
  * @return Void 
  */
  public function flush(){
      $this->destroy();
  }

}

