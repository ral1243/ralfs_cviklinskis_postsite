<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;

class CommentController extends BaseController
{

    public function add($contents)
    {
        $session = session();
        $contents = explode(",", $contents);
        $post_id =  $contents[0];
        $comment = $contents[1];
        $commenter_id = $session->get("account_id");

        $db = \Config\Database::connect();
        $query = $db->query('SELECT `create_comment`(' . $post_id . ', ' . $db->escape($comment) . ', ' . $commenter_id . ') as comment');
        $result = $query->getResultArray();
        $result = explode(",", $result[0]["comment"]);
        date_default_timezone_set('Europe/Riga');

        $data = '<div id="' . $result[1] . '_comment" class="col-12 row my-1 mx-0 justify-content-evenly border border-black"> 
            <div class="col-1 justify-content-evenly">
            <img class="" style="height: 65px" src="' . base_url('uploads/avatar/' . $session->get("pfp")) . '">
            
            </div>

            <div class="col-11 row justify-content-evenly">
            <div class="col-11 row my-1 border border-black justify-content-between"><span class="col-4 align-self-center p-0">' . $session->get("username") . '    ' . date("Y-m-d H:i:s") . '</span>
            <div  class="col-3 row">
            <button id="' . $result[1] . '_edit"  type="button" class="edit_comment col m-1 btn btn-primary btn-sm" onclick="commentEdit(this.id)">edit</button>
            <button id="' . $result[1] . '_delete"  type="button" class="delete_comment col m-1 btn btn-primary btn-sm" >delete</button>
            </div>
            </div>

            <div id="' . $result[1] . '_comment_text" class="col-11 mb-1 border border-black">' . $comment . '</div>
            </div>
            </div>';

        return $this->response->setJSON([
            'error' => false,
            'message' => $data,
        ]);
    }

    public function fetch($contents)
    {
        $data = '';
        $db = \Config\Database::connect();
        $session = session();
        $contents = explode(",", $contents);
        if ($contents[1] == "0") {
            $last_id = 0;
        } else {
            $last_id = $contents[1];
        }
        for ($i = 0; $i < 2; $i++) {
            try {
                $query = $db->query('select `fetch_comments`(' . $contents[0] . ', ' . $last_id . ') as comment');
                $result = $query->getResultArray();
                $result = explode(",", $result[0]["comment"]);
                $editing = "";
                if ($result[0] = "success") {
                    $last_id = $result[4];

                    if ($result[6] == $session->get('account_id')) {
                        $editing = '<div  class="col-3 row">
            <button id="' . $last_id . '_edit"  type="button" class="edit_comment col m-1 btn btn-primary btn-sm" onclick="commentEdit(this.id)">edit</button>
            <button id="' . $last_id . '_delete"  type="button" class="delete_comment col m-1 btn btn-primary btn-sm" >delete</button>
            </div>';
                    }
                }
                $data .= '<div id="' . $last_id . "_comment" . '" class="col-12 row mx-0 my-1 justify-content-evenly border border-black"> 
            <div class="col-1 justify-content-evenly ">
            <img class="" style="height: 65px" src="' . base_url('uploads/avatar/' . $result[1]) . '">
            </div>

            <div class="col-11 row justify-content-evenly">
            <div class="col-11 row my-1 border border-black justify-content-between"><span class="col-4 align-self-center p-0">' . $result[2] . '    ' . $result[5] . '</span>
            ' . $editing . '
            
            </div>

            <div id="' . $last_id . '_comment_text" class="col-11 mb-1 border border-black">' . $result[3] . '</div>
            </div>
            </div>';
            } catch (Exception) {
                log_message('debug', "man im dead -PHP");
                break;
            }
        }
        return $this->response->setJSON([
            'error' => false,
            'message' => $data,
            'id' => $last_id
        ]);
    }

    public function delete($comment_id)
    {
        $session = session();
        $db = \Config\Database::connect();
        $query = $db->query('SELECT `delete_comment`(' . $comment_id . ', ' . $session->get("account_id") . ') as comment');
        $result = $query->getResultArray();
        log_message('debug', json_encode($result));
        if ($result[0]["comment"] = "success") {
            return $this->response->setJSON([
                'error' => false,
                'message' => "success"
            ]);
        }
    }

    public function edit($comment)
    {
        $session = session();
        $db = \Config\Database::connect();
        $comment = explode("_", $comment);
        $query = $db->query('SELECT `edit_comment` (' . $comment[0] . ', ' . $session->get("account_id") . ', ' . $db->escape($comment[1]) . ') as comment');
        $result = $query->getResultArray();
        log_message('debug', json_encode($result));
        if ($result[0]["comment"] = "success") {
            return $this->response->setJSON([
                'error' => false,
                'message' => "success"
            ]);
        }
    }

    public function report() {}
}
