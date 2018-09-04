<?php
namespace Auth;

    function isAuthed() : bool {
        return isset($_SESSION['.ejax_authed']);
    }

?>