<?php
namespace Auth;

	// generate CSRF token
	function generate_token(){
	    //	generate hash from session id
	    return hash('sha256', session_id());
	}

	// validate CSRF token
	function validate_token($token){
	    // validate received token with generated token
	    return $token === generate_token();
	}

?>