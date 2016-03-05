<?php
/* Control de Sesiones
    @autor: Pedro Parra (edyjen@hotmail.com)
    @ver 1.00 
*/

$GLOBALS['USE_SESSION'] = true;

session_start();

class Session {
    public function registerArray($values) {
        foreach ($values as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function registerValue($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function getVar($var) {
        return (array_key_exists($var, $_SESSION)) ? $_SESSION[$var] : null;
    }

    public function destroy() {
        session_destroy();
    }

    public function clearVar($var) {
        $_SESSION[$key] = null;
    }

    public function loginFailed() {
        $myValue = $this->getVar("loginFailed");
        if ($myValue == null) {
            $myValue = 1;
        }
        else {
           $myValue++; 
        }
        
        if ($myValue >= 5) {
            $this->registerValue("PRIV", -1);
        }
        else {
            $this->registerValue("loginFailed", $myValue);
        }
    }
}
?>