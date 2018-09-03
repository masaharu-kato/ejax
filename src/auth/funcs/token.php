<?php
namespace Auth;

	/**
	 * generate_token
	 *   generate CSRF token
	 * 
	 * @return string : generated CSRF token
	 */
	function generate_token() : string {
	    //	generate hash from session id
	    return hash('sha256', session_id());
	}

	/**
	 * validate_token
	 *   validate CSRF token
	 * 
	 * @param string $token : CSRF token for validated
	 * 
	 * @return bool :  whether given CSRF token is valid
	 */
	function validate_token($token) : bool {
	    // validate received token with generated token
	    return $token === generate_token();
	}

?>