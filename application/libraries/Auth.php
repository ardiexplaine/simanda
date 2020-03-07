<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| PortFolio Ardie xpLaiNe CodeIgniter Version 2.1.3                 |
| -------------------------------------------------------------------
| Development by : Wahyu Ardie                                      |
| Start in       : 19 Januari 2013							        |
| -------------------------------------------------------------------
*/

class Auth {
	
    var $CI;

    function __construct() {
        $this->CI =& get_instance();
    }

    function no_cache()
    {
        $this->CI->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT+7');
        $this->CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->CI->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->CI->output->set_header('Pragma: no-cache');
    }

    function isLogin() {
        if ($this->CI->session->userdata('login') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	function isUser() {
        if ($this->CI->session->userdata('level') == 'N') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function isAdmin() {
        if ($this->CI->session->userdata('user_type') == 'KEM') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	function checkLogin() {
        $this->no_cache();
		// Jika Auth Login dan berlevel user atau admin
        if (($this->isLogin() AND $this->isUser() || $this->isAdmin()) != TRUE) {
            redirect('login');
        }
    }

    function checkAdmin() {
        $this->no_cache();
		// Jika Auth Login dan berlevel admin
        if (($this->isLogin() && $this->isAdmin()) != TRUE) {
            redirect('login');
        }
    }

}


          

