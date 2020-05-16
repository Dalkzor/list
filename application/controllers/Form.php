<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller
{
    const COMPLAINT_FORM = 'complaint';
    const CLIENT_FORM = 'client';
    const OPERATOR_FORM = 'operator';

    function __construct()
    {
        parent::__construct();

        if (!$this->auth->isLoggedIn()) {
            $this->auth->goToLogin();
        }
    }

    /**
     * Connection form
     */
    public function index()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_OPERATOR) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            if (!$form = $this->input->post('form')) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            if ($id = $this->input->post(models\Complaint::KEY_ID)) {
                $id = intval($id);
            }

            if ($form == self::COMPLAINT_FORM) {
                $path = self::COMPLAINT_FORM;

                if ($id) {
                    $res = models\Complaint::getComplaintId($id);
                    $data[models\Complaint::KEY_OFFICE_ID] = $res->getOffice()->getId();
                    $data[models\Complaint::KEY_CLIENT_ID] = $res->getClient()->getId();
                    $data[models\Complaint::KEY_COMPLAINT_TYPE_ID] = $res->getComplaintType()->getId();
                    if ($res->getComplaintStatus())
                        $data[models\Complaint::KEY_COMPLAINT_STATUS_ID] = $res->getComplaintStatus()->getId();
                    $data[models\Complaint::KEY_DESCRIPTION] = $res->getDescription();
                    $data[models\Complaint::KEY_RESULT] = $res->getResult();
                    $data[models\Complaint::KEY_REASON] = $res->getReason();
                    $data[models\Complaint::KEY_RESPONSIBLE] = models\AssocComplaintsOperators::getResponsible($id);
                }

                $data[models\Complaint::KEY_ID] = $id;
                $data['offices'] = models\Office::getOffices();
                $data['clients'] = models\Client::getClients();
                $data['operators'] = models\Operator::getOperators();
                $data['complaints_type'] = models\ComplaintType::getComplaintTypes();
                $data['complaints_status'] = models\ComplaintStatus::getComplaintStatus();
            } elseif ($form == self::CLIENT_FORM) {
                $path = self::CLIENT_FORM;
                $data[models\Client::KEY_ID] = $id;
                $data['client'] = models\Client::getClientId($id);
            } elseif ($form == self::OPERATOR_FORM) {
                $path = self::OPERATOR_FORM;
                if ($id) {
                    $res = models\Operator::getOperatorId($id);
                    $data['operator'] = $res;
                    if ($res->getOffice()) {
                        $data[models\Operator::KEY_OFFICE_ID] = $res->getOffice()->getId();
                    }
                }
                $data[models\Operator::KEY_ID] = $id;
                $data['offices'] = models\Office::getOffices();
                $data['roles'] = models\Role::getRoles();
            } else {
                throw new Exception(ErrorCode::FORM_NOT_FIND);
            }

            if (isset($path) && isset($data)) {
                $this->load->view('form/' . $path, $data);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}