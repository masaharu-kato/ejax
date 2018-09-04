<?php
namespace Ejax\Auth;
    
    /**
     *  isAuthed
     *  return whether authorized or not
     * 
     *  @return bool : return whether authorized or not
     */
    function isAuthed() : bool {
        return isset($_SESSION['.ejax/authed']);
    }

?>