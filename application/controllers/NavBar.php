<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NavBar extends CI_Controller {


    public function index()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('Model_auth');
        $this->load->model('Model_nav');

        $this->Model_auth->checkToken($_SESSION['id'], $_SESSION['token']);

        $data['navBar'] = $this->Model_nav->getNavBar('id', true);

        $this->load->view('include_files/header', $data);
        $this->load->view('include_files/nav', $data);
        $this->load->view('include_files/footer', $data);
    }

    public function editItem()
    {
        $this->load->library('session');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->model('Model_auth');
        $this->load->model('Model_nav');

        // $this->Model_auth->checkToken($_SESSION['id'], $_SESSION['token']);

        switch ($_GET['action']) {
            case 'add':
                $data['id']     = $_GET['parent_id'];
                $data['action'] = 'add';
                break;

            case 'delete':
                $data['id']     = $_GET['id'];
                $data['action'] = 'delete';
                break;

            case 'edit':
                $item = $this->Model_nav->getOneItem($_GET['id']);

                $data['id']     = $item['id'];
                $data['link']   = $item['href'];
                $data['title']  = $item['title'];
                $data['action'] = 'edit';
                break;

            default:
                die('error');
                break;
        }

        $this->load->view('include_files/header', $data);
        $this->load->view('include_files/nav', $data);
        $this->load->view('nav_edit', $data);
        $this->load->view('include_files/footer', $data);
    }

    public function search()
    {
        $this->load->library('session');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->model('Model_auth');
        $this->load->model('Model_nav');

        // $this->Model_auth->checkToken($_SESSION['id'], $_SESSION['token']);

        $data['navBar'] = $this->Model_nav->getNavBar('id');

        $data['results'] = $this->Model_nav->search($_GET['s']);

        $this->load->view('include_files/header', $data);
        $this->load->view('include_files/nav', $data);
        $this->load->view('search', $data);
        $this->load->view('include_files/footer', $data);
    }

    public function add()
    {
        $this->load->helper('url');
        $this->load->model('Model_nav');

        $this->Model_nav->add($_POST['id'], $_POST['title'], $_POST['link']);
        
        redirect('/navBar', 'refresh');
    }

    public function delete()
    {
        $this->load->helper('url');
        $this->load->model('Model_nav');

        $this->Model_nav->delete($_POST['id']);

        redirect('/navBar', 'refresh');
    }

    public function edit()
    {
        $this->load->helper('url');
        $this->load->model('Model_nav');

        $this->Model_nav->edit($_POST['id'], $_POST['title'], $_POST['link']);

        redirect('/navBar', 'refresh');
    }
}
