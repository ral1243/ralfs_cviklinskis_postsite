<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AccountController extends BaseController
{

    public function login($login)
    {
        $db = db_connect();
        $login = explode(",", $login);
        $query = $db->query('SELECT `login`("' . $login[0] . '", "' . $login[1] . '") as login');
        $login = $query->getRow();
        log_message('debug', "login--------------------------" . json_encode($login));
        $login = explode("-", $login->{"login"});
        $session = session();
        if ($login[1] == "loged in successfully") {
            $session->set('account_id', $login[0]);
            $session->set('logged_in', '1');
        }
        return $this->response->setJSON([
            'error' => false,
            'message' => $login
        ]);
    }

    public function signup()
    {
        $imagefile = $this->request->getFiles();
        $newName = $imagefile["image_select"]->getRandomName();
        $imagefile["image_select"]->move('uploads/avatar', $newName);

        $db = db_connect();
        $query = $db->query('SELECT `create_account`(' . $db->escape($this->request->getPost('email')) . ', ' . $db->escape($this->request->getPost('username')) . ', ' . $db->escape($this->request->getPost('phone')) . ', ' . $db->escape($this->request->getPost('password')) . ', ' . $db->escape($newName) . ') as signup');
        $signup = $query->getRow();
        $signup = explode("-", $signup->{"signup"});
        $session = session();
        if ($signup[1] == "account_created") {
            $session->set('account_id', $signup[0]);
            $session->set('logged_in', '1');
        }
        return $this->response->setJSON([
            'error' => false,
            'message' => $signup
        ]);
    }

    public function logout()
    {
        $session = session();
        $db = db_connect();
        $db->query("DELETE FROM user WHERE account_id=" . $session->get('account_id'));
        $logout = "loged out successfully";
        $session->destroy();
        $session->close();

        return $this->response->setJSON([
            'error' => false,
            'message' => $logout
        ]);
    }

    public function delete($password)
    {
        $session = session();
        $db = db_connect();
        $query = $db->query("SELECT `account_deletion`('" . $session->get('account_id') . "', '" . $password . "') as 'delete'");
        $result = $query->getRow();
        $result = explode("-", $result->{"delete"});
        if ($result[0] == "deleted") {
            $delete = "account deleted succesfully";
            $session->destroy();
            $session->close();
        } else {
            $delete = "nuh uh";
        }



        return $this->response->setJSON([
            'error' => false,
            'message' => $delete
        ]);
    }
}
