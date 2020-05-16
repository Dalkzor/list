<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends CI_Controller
{
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
            $data['title'] = 'Жалобы';
            $data['body_param'] = 'sidebar-mini';
            $res['categories'] = models\Category::getActiveCategories();
            $data['complaints_type'] = models\ComplaintType::getComplaintTypes();
            $data['complaints_status'] = models\ComplaintStatus::getComplaintStatus();
            $data['operators'] = models\Operator::getOperators();
            $data['clients'] = models\Client::getClients();
            $data['offices'] = models\Office::getOffices();
            $resComplaints = models\Complaint::getFullComplaint();
            if ($resComplaints) {
                $data['complaints'] = $resComplaints;
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $res);
            $this->load->view('complaint/content', $data);
            $this->load->view('templates/footer');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * add complaint
     */
    public function addcomplaint()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_OPERATOR) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('office', 'Office', 'required|integer');
            $this->form_validation->set_rules('client', 'Client', 'required|integer');
            $this->form_validation->set_rules('operators[]', 'Operators', 'required');
            $this->form_validation->set_rules('complaint-type', 'Complaint type', 'required|integer');
            $this->form_validation->set_rules('complaint-status', 'Complaint status', 'integer');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('result', 'Result', '');
            $this->form_validation->set_rules('reason', 'Reason', '');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            if (!models\Office::getOfficeId($this->input->post('office')) ||
                !models\Client::getClientId($this->input->post('client')) ||
                !models\ComplaintType::getComplaintTypeId($this->input->post('complaint-type'))
            ) {
                throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
            }

            if ($this->input->post('complaint-status')) {
                if (!models\ComplaintStatus::getComplaintStatusId($this->input->post('complaint-status'))) {
                    throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
                }
            }

            foreach ($this->input->post('operators') as $operator) {
                if (models\Operator::getOperatorId($operator)) {
                    $params['operators'][] = $operator;
                } else {
                    throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
                }
            }

            $params[models\Complaint::KEY_OFFICE_ID] = $this->input->post('office');
            $params[models\Complaint::KEY_CLIENT_ID] = $this->input->post('client');
            $params[models\Complaint::KEY_COMPLAINT_TYPE_ID] = $this->input->post('complaint-type');
            $params[models\Complaint::KEY_COMPLAINT_STATUS_ID] = $this->input->post('complaint-status');
            $params[models\Complaint::KEY_DESCRIPTION] = $this->input->post('description');
            $params[models\Complaint::KEY_RESULT] = $this->input->post('result');
            $params[models\Complaint::KEY_REASON] = $this->input->post('reason');

            $this->doctrine->em->getConnection()->beginTransaction();
            $result = models\Complaint::addComplaintAndReturnResult($params);
            $result = models\Complaint::toArray($result);
            $this->doctrine->em->getConnection()->commit();
            echo json_encode($result);

        } catch (Exception $e) {
            $this->doctrine->em->getConnection()->rollback();
            echo $e->getMessage();
        }
    }

    /**
     * edit complaint
     */
    public function editcomplaint()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_OPERATOR) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('complaint-id', 'Complaint ID', 'required|integer');
            $this->form_validation->set_rules('office', 'Office', 'required|integer');
            $this->form_validation->set_rules('client', 'Client', 'required|integer');
            $this->form_validation->set_rules('operators[]', 'Operators', 'required');
            $this->form_validation->set_rules('complaint-type', 'Complaint type', 'required|integer');
            $this->form_validation->set_rules('complaint-status', 'Complaint status', 'integer');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('result', 'Result', '');
            $this->form_validation->set_rules('reason', 'Reason', '');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            if (!models\Complaint::getComplaintId($this->input->post('complaint-id')) ||
                !models\Office::getOfficeId($this->input->post('office')) ||
                !models\Client::getClientId($this->input->post('client')) ||
                !models\ComplaintType::getComplaintTypeId($this->input->post('complaint-type'))
            ) {
                throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
            }

            if ($this->input->post('complaint-status')) {
                if (!models\ComplaintStatus::getComplaintStatusId($this->input->post('complaint-status'))) {
                    throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
                }
            }

            foreach ($this->input->post('operators') as $operator) {
                if (models\Operator::getOperatorId($operator)) {
                    $params['operators'][] = $operator;
                } else {
                    throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
                }
            }

            $params[models\Complaint::KEY_ID] = $this->input->post('complaint-id');
            $params[models\Complaint::KEY_OFFICE_ID] = $this->input->post('office');
            $params[models\Complaint::KEY_CLIENT_ID] = $this->input->post('client');
            $params[models\Complaint::KEY_COMPLAINT_TYPE_ID] = $this->input->post('complaint-type');
            $params[models\Complaint::KEY_COMPLAINT_STATUS_ID] = $this->input->post('complaint-status');
            $params[models\Complaint::KEY_DESCRIPTION] = $this->input->post('description');
            $params[models\Complaint::KEY_RESULT] = $this->input->post('result');
            $params[models\Complaint::KEY_REASON] = $this->input->post('reason');

            $this->doctrine->em->getConnection()->beginTransaction();
            $result = models\Complaint::editComplaintAndReturnResult($params);
            $result = models\Complaint::toArray($result);
            $this->doctrine->em->getConnection()->commit();
            echo json_encode($result);

        } catch (Exception $e) {
            $this->doctrine->em->getConnection()->rollback();
            echo $e->getMessage();
        }
    }

    /**
     * delete complaint
     */
    public function deleted()
    {
        try {
            $ci = &get_instance();
            if ($ci->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_COMPLAINTS_DEPARTMENT) {
                throw new Exception(ErrorCode::NO_PERMISSIONS);
            }

            $this->form_validation->set_rules('complaint-id', 'complaint-id', 'required|integer');

            if (!$this->form_validation->run()) {
                throw new Exception(ErrorCode::INVALID_INPUT_PARAMETERS);
            }

            if (!models\Complaint::getComplaintId($this->input->post('complaint-id'))) {
                throw new Exception(ErrorCode::ENTITY_NOT_FOUND);
            }

            $params[models\Complaint::KEY_ID] = $this->input->post('complaint-id');
            echo models\Complaint::deletedComplaint($params);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * filter complaints
     */
    public function filter()
    {
        try {
            if ($this->input->post('date-from')) {
                $params['date-from'] = $this->input->post('date-from') . ' 00:00:00';
            }
            if ($this->input->post('date-to')) {
                $params['date-to'] = $this->input->post('date-to') . ' 23:59:59';
            } else {
                if ($this->input->post('date-from')) {
                    $params['date-to'] = $this->input->post('date-from') . ' 23:59:59';
                }
            }
            if ($this->input->post('office')) {
                $params['office'] = $this->input->post('office');
            }
            if ($this->input->post('client')) {
                $params['client'] = $this->input->post('client');
            }
            if ($this->input->post('complaint-type')) {
                $params['complaint-type'] = $this->input->post('complaint-type');
            }
            if ($this->input->post('complaint-status')) {
                $params['complaint-status'] = $this->input->post('complaint-status');
            }
            if ($this->input->post('operator')) {
                $params['operator'] = $this->input->post('operator');
            }

            if (isset($params)) {
                $result = models\Complaint::getFullComplaint($id = null, $params);
                $result = models\Complaint::toArray($result);
                echo json_encode($result);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}