<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller
{
    const PHONE_NUMBER_LENGTH = 10;

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
            $data['title'] = 'Клиенты';
            $data['body_param'] = 'sidebar-mini';
            $data['clients'] = models\Client::getClients();
            $res['categories'] = models\Category::getActiveCategories();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $res);
            $this->load->view('client/content', $data);
            $this->load->view('templates/footer');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * add client
     */
    public function addclient()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_OPERATOR) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('last-name', 'Last name', 'required|max_length[60]');
            $this->form_validation->set_rules('first-name', 'First name', 'required|max_length[60]');
            $this->form_validation->set_rules('middle-name', 'Middle name', 'required|max_length[60]');
            $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[14]');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            $params[models\Client::KEY_LAST_NAME] = $this->input->post('last-name');
            $params[models\Client::KEY_FIRST_NAME] = $this->input->post('first-name');
            $params[models\Client::KEY_MIDDLE_NAME] = $this->input->post('middle-name');
            $params[models\Client::KEY_PHONE] = preg_replace("/[^0-9]/", '', $this->input->post('phone'));

            if (strlen($params[models\Client::KEY_PHONE]) != self::PHONE_NUMBER_LENGTH
                && !is_int($params[models\Client::KEY_PHONE])) {
                throw new Exception(ErrorCode::INCOMPLETE_STRING);
            }

            if ($ci->doctrine->em->getRepository('models\Client')->findOneBy(
                [models\Client::KEY_PHONE => $params[models\Client::KEY_PHONE]])) {
                throw new Exception(ErrorCode::DUPLICATE_RECORD);
            }

            $result = models\Client::addClientAndReturnResult($params);
            echo json_encode($result);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * edit client
     */
    public function editclient()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_SENIOR_OPERATOR) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('last-name', 'Last name', 'required|max_length[60]');
            $this->form_validation->set_rules('first-name', 'First name', 'required|max_length[60]');
            $this->form_validation->set_rules('middle-name', 'Middle name', 'required|max_length[60]');
            $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[14]');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            if (!models\Client::getClientId($this->input->post('client-id'))) {
                throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
            }

            $params[models\Client::KEY_ID] = $this->input->post('client-id');
            $params[models\Client::KEY_LAST_NAME] = $this->input->post('last-name');
            $params[models\Client::KEY_FIRST_NAME] = $this->input->post('first-name');
            $params[models\Client::KEY_MIDDLE_NAME] = $this->input->post('middle-name');
            $params[models\Client::KEY_PHONE] = preg_replace("/[^0-9]/", '', $this->input->post('phone'));

            if (strlen($params[models\Client::KEY_PHONE]) != self::PHONE_NUMBER_LENGTH
                && !is_int($params[models\Client::KEY_PHONE])) {
                throw new Exception(ErrorCode::INCOMPLETE_STRING);
            }

            if (models\Client::checkEditPhone($params[models\Client::KEY_ID], $params[models\Client::KEY_PHONE])) {
                throw new Exception(ErrorCode::DUPLICATE_RECORD);
            }

            $result = models\Client::editClientAndReturnResult($params);
            echo json_encode($result);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}