<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->auth->isLoggedIn()) {
            $this->auth->goToIndex();
        }
    }

    /**
     * Авторизация
     */
    public function index()
    {
        try {
            $data['title'] = 'Авторизация';
            $data['body_param'] = 'login-page';

            $this->load->view('templates/header', $data);
            $this->load->view('operator/login', $data);
            $this->load->view('templates/footer');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * authentication
     */
    public function signin()
    {
        try {
            $this->form_validation->set_rules('login', 'Login', 'required|max_length[100]');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            $login = $this->input->post(models\Operator::KEY_LOGIN);
            $password = $this->input->post(models\Operator::KEY_PASSWORD);

            // Получаем аккаунт если он существует
            if (!$response = models\Operator::operatorLogin($login, $password)) {
                throw new Exception(ErrorCode::WRONG_LOGIN_OR_PASSWORD);
            }

            // Проверяем аккаунт на блокировку
            if ($response->getRole()->getId() == models\Role::ID_BAN) {
                throw new Exception(ErrorCode::NO_AUTHENTICATION);
            }

            $operatorParam = array(
                models\Operator::KEY_ID => $response->getId(),
                models\Operator::KEY_ROLE_ID => $response->getRole()->getId(),
                models\Operator::KEY_LOGIN => $response->getLogin(),
                models\Operator::KEY_LAST_NAME => $response->getLastName(),
                models\Operator::KEY_FIRST_NAME => $response->getFirstName(),
                models\Operator::KEY_MIDDLE_NAME => $response->getMiddleName(),
            );

            if ($response->getOffice()) {
                $operatorParam[models\Operator::KEY_OFFICE_ID] = $response->getOffice()->getId();
            }

            $this->session->set_userdata($operatorParam);

            if ($this->session->userdata(models\Operator::KEY_ID)) {
                echo InfoCode::SUCCESSFUL_LOGIN;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}