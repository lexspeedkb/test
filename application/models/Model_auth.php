<?php
class Model_auth extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

   /*
    * @return: 
    *   0 - if user exist 
    *   1 - if user !exist 
    */
    public function checkLogin($login, $password)
    {
        $query = $this->db->query("SELECT id FROM users WHERE login='$login' AND password='$password'");
        $row = $query->row();
        
        if (!empty($row->id)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getDataByLogin($login)
    {
        $query = $this->db->query("SELECT * FROM users WHERE login='$login'");
        foreach ($query->result_array() as $row) {
            $user['id']    = $row['id'];
            $user['login'] = $row['login'];
            $user['token'] = $row['token'];
        }
        
        return $user;
    }

    public function updateToken($id, $newToken)
    {
        $query = $this->db->query("UPDATE users SET token='$newToken' WHERE id = '$id'");
    }

    public function checkToken($id, $token, $loginPage=false)
    {
        $query = $this->db->query("SELECT id FROM users WHERE id='$id' AND token='$token'");
        $row = $query->row();

        if (!empty($row->id)) {
            if ($loginPage){
                redirect('/home', 'refresh');
                return 1;
            } else {
                return 0;
            }
        } else {
            if ($loginPage) {
                return 0;
            } else {
                redirect('/auth/login', 'refresh');
                return 1;
            }
        }
    }

    public function register($data)
    {
        $name     = $data['name'];
        $login    = $data['login'];
        $password = $data['password'];

        $this->db->query("INSERT INTO users (login, password, name) VALUES ('$login', '$password', '$name')");
    }

}
?>