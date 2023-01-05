
<?php
ini_set('display_errors', 1);
if (isset($_POST)) {
    //$data = json_decode(file_get_contents('php://input'));
    $path = '/var/www/html';
    // echo $path;
    if (file_exists($path)) {
        $command = '/usr/bin/git pull';
        echo getcwd() . "\n";
        chdir($path);
        echo getcwd() . "\n";
        $output = system($command, $out);
        echo "<pre>$output</pre>";
    } else {
        echo $path . 'não existe!';
    }
}

  function pre($array)
  {
      echo '<pre>';
      print_r($array);
      exit;
  }


