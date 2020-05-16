<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller
{
    //Регулярные выражения
    const REG_LOGIN = "/^[a-z0-9\._-]{3,32}$/i";
    const REG_PASSWORD = '/^[a-z0-9\._`"\'!~@#$%^&*(){}|?:;<>]{6,20}$/i';

    function __construct()
    {
        parent::__construct();

        if (!$this->auth->isLoggedIn()) {
            $this->auth->goToLogin();
        }
    }

    public function index()
    {
        try {
            $data['title'] = 'Операторы';
            $data['body_param'] = 'sidebar-mini';
            $data['operators'] = models\Operator::getOperators();
            $res['categories'] = models\Category::getActiveCategories();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $res);
            $this->load->view('operator/content', $data);
            $this->load->view('templates/footer');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * add operator
     */
    public function addoperator()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_ADMIN) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('office', 'Office', 'integer');
            $this->form_validation->set_rules('login', 'Login', 'required|max_length[32]');
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('password_check', 'Password check', 'required|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('last-name', 'Last name', 'required|max_length[60]');
            $this->form_validation->set_rules('first-name', 'First name', 'required|max_length[60]');
            $this->form_validation->set_rules('middle-name', 'Middle name', 'required|max_length[60]');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            $params[models\Operator::KEY_OFFICE_ID] = $this->input->post('office');
            $params[models\Operator::KEY_LOGIN] = $this->input->post('login');
            $params[models\Operator::KEY_PASSWORD] = $this->input->post('password');
            $params[models\Operator::KEY_PASSWORD_CHECK] = $this->input->post('password_check');
            $params[models\Operator::KEY_ROLE_ID] = $this->input->post('role');
            $params[models\Operator::KEY_LAST_NAME] = $this->input->post('last-name');
            $params[models\Operator::KEY_FIRST_NAME] = $this->input->post('first-name');
            $params[models\Operator::KEY_MIDDLE_NAME] = $this->input->post('middle-name');

            if (!$ci->doctrine->em->getRepository('models\Office')->findOneBy(
                [models\Office::KEY_ID => $params[models\Operator::KEY_OFFICE_ID]])
                && $params[models\Operator::KEY_OFFICE_ID]) {
                throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
            }

            if (!preg_match(self::REG_LOGIN, $params[models\Operator::KEY_LOGIN])) {
                throw new Exception(ErrorCode::INVALID_LOGIN);
            }

            if(!preg_match(self::REG_PASSWORD, $params[models\Operator::KEY_PASSWORD])) {
                throw new Exception(ErrorCode::INVALID_PASSWORD);
            } elseif ($params[models\Operator::KEY_PASSWORD] !== $params[models\Operator::KEY_PASSWORD_CHECK]) {
                throw new Exception(ErrorCode::PASSWORDS_DID_NOT_MATCH);
            }

            if ($ci->doctrine->em->getRepository('models\Operator')->findOneBy(
                [models\Operator::KEY_LOGIN => $params[models\Operator::KEY_LOGIN]])) {
                throw new Exception(ErrorCode::LOGIN_BUSY);
            }

            $result = models\Operator::addOperatorAndReturnResult($params);
            echo json_encode($result);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * edit operator
     */
    public function editoperator()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_ADMIN) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('office', 'Office', 'integer');
            $this->form_validation->set_rules('login', 'Login', 'required|max_length[32]');
            $this->form_validation->set_rules('password', 'Password', 'max_length[20]');
            $this->form_validation->set_rules('password_check', 'Password check', 'max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('last-name', 'Last name', 'required|max_length[60]');
            $this->form_validation->set_rules('first-name', 'First name', 'required|max_length[60]');
            $this->form_validation->set_rules('middle-name', 'Middle name', 'required|max_length[60]');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            if (!models\Operator::getOperatorId($this->input->post('operator-id')) ||
                (!$ci->doctrine->em->getRepository('models\Office')->findOneBy(
                        [models\Office::KEY_ID => $this->input->post('office')]
                    ) && $this->input->post('office'))) {
                throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
            }

            $params[models\Operator::KEY_OFFICE_ID] = $this->input->post('office');
            $params[models\Operator::KEY_ID] = $this->input->post('operator-id');
            $params[models\Operator::KEY_LOGIN] = $this->input->post('login');
            $params[models\Operator::KEY_PASSWORD] = $this->input->post('password');
            $params[models\Operator::KEY_PASSWORD_CHECK] = $this->input->post('password_check');
            $params[models\Operator::KEY_ROLE_ID] = $this->input->post('role');
            $params[models\Operator::KEY_LAST_NAME] = $this->input->post('last-name');
            $params[models\Operator::KEY_FIRST_NAME] = $this->input->post('first-name');
            $params[models\Operator::KEY_MIDDLE_NAME] = $this->input->post('middle-name');

            if (!preg_match(self::REG_LOGIN, $params[models\Operator::KEY_LOGIN])) {
                throw new Exception(ErrorCode::INVALID_LOGIN);
            }

            if ($params[models\Operator::KEY_PASSWORD] || $params[models\Operator::KEY_PASSWORD_CHECK]) {
                if (!preg_match(self::REG_PASSWORD, $params[models\Operator::KEY_PASSWORD])) {
                    throw new Exception(ErrorCode::INVALID_PASSWORD);
                } elseif ($params[models\Operator::KEY_PASSWORD] !== $params[models\Operator::KEY_PASSWORD_CHECK]) {
                    throw new Exception(ErrorCode::PASSWORDS_DID_NOT_MATCH);
                }
            }

            if (models\Operator::checkOperatorLogin($params[models\Operator::KEY_ID], $params[models\Operator::KEY_LOGIN])) {
                throw new Exception(ErrorCode::LOGIN_BUSY);
            }

            $result = models\Operator::editOperatorAndReturnResult($params);
            echo json_encode($result);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}