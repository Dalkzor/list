<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth
{
    function isLoggedIn()
    {
        $ci = & get_instance();
        return $ci->session->userdata('id');
    }

    function goToLogin()
    {
        redirect(base_url() .'login');
    }

    function goToIndex()
    {
        redirect(base_url());
    }
}