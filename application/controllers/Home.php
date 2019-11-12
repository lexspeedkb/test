<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        $this->load->library('session');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->model('Model_auth');
        $this->load->model('Model_nav');

        $this->Model_auth->checkToken($_SESSION['id'], $_SESSION['token']);

        $data['navBar'] = $this->Model_nav->getNavBar($_GET['menu_order']);


        $this->load->view('include_files/header', $data);
        $this->load->view('include_files/nav', $data);
        $this->load->view('home', $data);
        $this->load->view('include_files/footer', $data);
    }
}
