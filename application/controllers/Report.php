<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
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
            $data['title'] = 'Отчет';
            $data['body_param'] = 'sidebar-mini';
            $res['categories'] = models\Category::getActiveCategories();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/menu', $res);
            $this->load->view('report/content', $data);
            $this->load->view('templates/footer');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}