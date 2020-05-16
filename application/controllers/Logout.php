<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller
{
    public function index()
    {
        try {
            if (!$logout = $this->input->post('logout')) {
                throw new Exception(ErrorCode::NO_AUTHENTICATION);
            }

            $this->session->unset_userdata(models\Operator::KEY_ID);
            $this->session->unset_userdata(models\Operator::KEY_ROLE_ID);
            $this->session->unset_userdata(models\Operator::KEY_OFFICE_ID);
            $this->session->unset_userdata(models\Operator::KEY_LOGIN);
            $this->session->unset_userdata(models\Operator::KEY_LAST_NAME);
            $this->session->unset_userdata(models\Operator::KEY_FIRST_NAME);
            $this->session->unset_userdata(models\Operator::KEY_MIDDLE_NAME);

            if (!$this->session->userdata(models\Operator::KEY_ID)) {
                echo InfoCode::SUCCESSFUL_LOGOUT;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}