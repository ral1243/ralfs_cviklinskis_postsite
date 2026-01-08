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
        return $this->response->setJSON([
            'error' => false,
            'message' => $login
        ]);
    }

    public function signup($signup)
    {
        $db = db_connect();
        $signup = explode(",", $signup);
        $query = $db->query('SELECT `create_account`(' . $db->escape($signup[0]) . ', ' . $db->escape($signup[1]) . ', ' . $signup[2] . ', ' . $db->escape($signup[3]) . ') as signup');
        $signup = $query->getRow();
        log_message('debug', "signup--------------------------" . json_encode($signup));
        return $this->response->setJSON([
            'error' => false,
            'message' => $signup
        ]);
    }

}
?>