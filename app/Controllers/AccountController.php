<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AccountController extends BaseController
{

    public function login($login)
    {
        $db = db_connect();
        $login = explode(",", $login);

        $email = str_contains($login[0], "@");
        if ($email == true) {
            $query = $db->query('select password from account where email = "' . $login[0] . '"');
            $result = $query->getRow();
            $query = 'select id, username, image from account where email = "' . $login[0] . '"';
        } else {
            $query = $db->query('select password from account where username = "' . $login[0] . '"');
            $result = $query->getRow();
            $query = 'select id, username, image from account where username = "' . $login[0] . '"';
        }

        if ($result != "") {
            if (password_verify($login[1], $result->{"password"}) == true) {
                $query = $db->query($query);
                $result = $query->getRow();
                log_message('debug', "result--------------------------" . json_encode($result));

                $session = session();

                $session->set('account_id', $result->{"id"});
                $session->set('logged_in', '1');
                $session->set('username', $result->{"username"});
                $session->set('pfp', $result->{"image"});
                $result = "loged in successfully";
            } else {
                $result = "Nepareizi ievadīti dati";
                log_message('debug', "login1");
            }
        } else {
            $result = "Nepareizi ievadīti dati";
            log_message('debug', "login2");
        }
        return $this->response->setJSON([
            'error' => false,
            'message' => $result
        ]);
    }

    public function signup()
    {
        $imagefile = $this->request->getFiles();
        if ($imagefile["image_select"] != "") {
            $newName = $imagefile["image_select"]->getRandomName();
        } else {
            $newName = "default.png";
        };


        $db = db_connect();
        $pass = PASSWORD_hash($this->request->getPost('password'), PASSWORD_ARGON2ID);
        log_message('debug', $db->escape($pass));
        $query = $db->query('SELECT `create_account`(' . $db->escape($this->request->getPost('email')) . ', ' . $db->escape($this->request->getPost('username')) . ', ' . $db->escape($this->request->getPost('phone')) . ', ' . $db->escape($pass) . ', ' . $db->escape($newName) . ') as signup');
        $result = $query->getRow();
        $result = explode(",", $result->{"signup"});
        log_message('debug', json_encode($result));
        $session = session();
        if ($result[1] == "account_created") {
            if ($newName != "default.png") {
                $imagefile["image_select"]->move('uploads/avatar', $newName);
            }
            $session->set('account_id', $result[0]);
            $session->set('logged_in', '1');
            $session->set('username', $this->request->getPost('username'));
            $session->set('pfp', $newName);
        }
        return $this->response->setJSON([
            'error' => false,
            'message' => $result
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
        $query = $db->query("SELECT password, image from account where id = " . $session->get("account_id"));
        $result = $query->getRow();
        if (password_verify($password, $result->{"password"}) == true) {
            $query = $db->query("SELECT `account_deletion`('" . $session->get('account_id') . "') as deleted");
            $result = $query->getRow();
            if ($result->{"deleted"} != "default.png") {
                unlink('uploads/avatar/' . $result->{"deleted"});
            }
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

    public function fetchAccount()
    {
        $session = session();
        $db = db_connect();
        $query = $db->query("SELECT email, username, phone, image from account where id = " . $session->get("account_id"));
        $result = $query->getRow();
        return $this->response->setJSON([
            'error' => false,
            'message' => $result
        ]);
    }

    public function editAccount()
    {
        $session = session();
        $db = db_connect();
        $file = $this->request->getFile('file');
        $fileName = $file->getFilename();
        if ($fileName != '') {
            $fileName = $file->getRandomName();
            $file->move('uploads/avatar', $fileName);
        } else {
            $fileName = "default.png";
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'phone' => $this->request->getPost('phone'),
            'password' => PASSWORD_hash($this->request->getPost('password'), PASSWORD_ARGON2ID),
            'image' => $fileName,
        ];
        $query = $db->query("SELECT password from account where id = " . $session->get("account_id"));
        $result = $query->getRow();
log_message("debug", json_encode($data));
        if (password_verify($this->request->getPost('passwordConfirmEdit'), $result->{"password"}) == true) {
            if ($this->request->getPost("password") == "") {
                $query = $db->query('UPDATE account set email = "' . $data["email"] . '", username = "' . $data["username"] . '", phone = ' . $data["phone"] . ', image = "' . $data["image"] . '" where id = ' . $session->get("account_id"));
                $result = "success";
                $session->set('pfp', $data["image"]);
            } else {
                $result = $query->getRow();
                $query = $db->query('UPDATE account set email = "' . $data["email"] . '", username = "' . $data["username"] . '", phone = ' . $data["phone"] . ', password = "' . $data["password"] . '", image = "' . $data["image"] . '" where id = ' . $session->get("account_id"));
                $result = "success";
                $session->set('pfp', $data["image"]);
            }
        } else ($result = "incorrect password");
        log_message("debug", json_encode($result));
        return $this->response->setJSON([
            'error' => false,
            'message' => $result,
        ]);
    }
}
