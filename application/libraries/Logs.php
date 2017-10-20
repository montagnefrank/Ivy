<?php if ( ! defined('BASEPATH')) exit('No esta permitido el acceso'); 
//La primera línea impide el acceso directo a este script
class logs {
    
    public function log($text)
    {
        if(!file_exists('././public/logs/'.date('Y-m-d').".txt"))
        {
            $file = fopen('././public/logs/'.date('Y-m-d').".txt", "w");
            fwrite($file,'USUARIO  ACCION  TABLA  ID'. PHP_EOL);
            fwrite($file, $text . PHP_EOL);
            fclose($file);
        }else
        {
                        
           $file = fopen('././public/logs/'.date('Y-m-d').".txt", "a");
           fwrite($file, $text . PHP_EOL);
           fclose($file);
        }
    }

}
?>