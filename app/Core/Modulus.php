<?php

class Modulus
{
  /**
   * Render
   * 
   * @param  string $contents
   * @param  array $data
   * @return eval
   */
  public function render($contents, $data = [])
  {
    extract($data);

    foreach ($data as $key => $value) {
      if (is_array($value) !== true) {
          $contents = preg_replace('/\%'.$key.'/', $value, $contents);
      }
    }

    // partials
    $contents = preg_replace_callback('/\{\% partials\((.*?)\) \%\}/', function($match) {
      $view = str_replace("'", "", $match[1]);
      $view = str_replace('"', '', $view);

      file_exists('../resources/views/' . $view . '.modulus.php') == true ? $view = $view . '.modulus' : $view = $view;

      if (file_exists('../resources/views/' . $view . '.php') == true) {
        if (substr($view, -8) == '.modulus') {
          return file_get_contents('../resources/views/'. $view . '.php');
        }
        
        return file_get_contents('../resources/views/'. $view . '.php');
      }
    }, $contents);

    // referred_{{variable}}
    $contents = preg_replace('/\{\% crf_(.*?) \%\}/', "{% referred(@$$1['modulus_referred']) %}", $contents);

    // token
    $contents = preg_replace('/\{\% csrf_field \%\}/', "<?php echo Modulus::csrf_field(); ?>", $contents);

    // if statement
    $contents = preg_replace('/\{\% if (.*?) \%\}/', '<?php if ($1) : ?>', $contents);
    $contents = preg_replace('/\{\% elseif (.*?) \%\}/', '<?php elseif ($1) : ?>', $contents);
    $contents = preg_replace('/\{\% else \%\}/', '<?php else : ?>', $contents);
    $contents = preg_replace('/\{\% endif \%\}/', '<?php endif ;?>', $contents);

    
    /**
     * echo
     * 
     * {{ ? variable }} = if variable is set then echo
     * {{ variable }} = echo variable. (disabled, because it might clash with vue.js)
     */
    $contents = preg_replace('/\{\{ \? (.*?) \}\}/', '<?php echo @$$1; ?>', $contents);
    $contents = preg_replace('/\{\{ \% (.*?) \}\}/', '<?php echo @$1; ?>', $contents);
    /*$contents = preg_replace('/\{\{ (.*?) \}\}/', '<?php echo $$1; ?>', $contents); */
    
    /**
     * extends
     * 
     */
    $contents = preg_replace('/\{\% extends(.*?) \%\}/', '<?php Modulus::extends$1 ?> ', $contents);

    /**
     * referred
     * 
     */
    $contents = preg_replace('/\{\% referred(.*?) \%\}/', '<?php Modulus::referred$1 ?> ', $contents);
    
    /**
     * modulus brackets
     * 
     */
    $contents = preg_replace('/\{\%(.*?)\%\}/s', '<?php $1 ?> ', $contents);
    
    eval('?> '.$contents);
  }

  /**
   * Extends
   * 
   * @param  string $view
   * @param  array $data
   * @return
   */
  public function extends($view, $data = []) 
  {
    file_exists('../resources/views/' . $view . '.modulus.php') == true ? $view = $view . '.modulus' : $view = $view;

    if (file_exists('../resources/views/' . $view . '.php') == true) {
      extract($data);

      if (substr($view, -8) == '.modulus') {
        $contents = file_get_contents('../resources/views/'. $view . '.php');
        Modulus::render($contents, $data);
      }
      else {
        require_once '../resources/views/'. $view . '.php';
      }
    }

  }

  /**
   * Current Url
   * 
   * @return string currentUrl ?
   */
  public function currentUrl()
  {
    return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  }

  /**
   * Application host
   * 
   * @return string $env_host ?
   */
  public function host()
  {
    $env_host = getenv('APP_URL');

    if ($env_host == null) {
      return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }
    
    return $env_host;
  }

  /**
   * Referred
   * 
   * @param  string $previous
   * @return string $backlink ? $previous
   */
  public function referred($previous = null)
  {
    $currentURL = Modulus::currentUrl();

    if ($previous != null) {
      echo '<input type="hidden" value="'.$previous.'" name="modulus_referred"/>';
    }
    else if (isset($_SERVER['HTTP_REFERER']) && @$_SERVER['HTTP_REFERER'] != $currentURL) {
      $backlink = $_SERVER['HTTP_REFERER'];
      echo '<input type="hidden" value="'.$backlink.'" name="modulus_referred"/>';
    }
  }

  /**
   * Still gonna implement this...
   * 
   * @return string
   */
  public function csrf_field()
  {
    // something goes here...
  }

  /**
   * Don't use this. I'm gonna remove it.
   * 
   * @param  string $location
   * @return string $location
   */
  public function resource($location)
  {
    $v = explode('/', filter_var(rtrim(substr($_SERVER['REQUEST_URI'], 1),'/'), FILTER_SANITIZE_URL));
    $int = count($v) - 1;

    substr($_SERVER['REQUEST_URI'], -1) == '/' ? $int = $int + 1 : $int = $int;
    
    for($i = 0; $i < $int; $i++) {
      $location = '../'.$location;
    }
    
    echo $location;
  }

  /**
   * Add multiple scripts
   * 
   * @param  array $scripts
   * @return string $script
   */
  public function scripts($scripts = [])
  {
      foreach($scripts as $script)
      {
          $script = '<script src="/js/'.$script.'.js"></script>';
          echo $script;
      }
  }

  /**
   * Add multiple stylesheets
   * 
   * @param  array $styles
   * @return string $style
   */
  public function styles($styles = [])
  {
    foreach($styles as $style)
    {
      $style = '<link rel="stylesheet" href="/css/'.$style.'.css">';
      echo $style;
    }
  }
}