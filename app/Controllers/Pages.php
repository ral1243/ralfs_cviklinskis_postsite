<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{

    public function view($page)
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException("YOU SUCK WAAAH WAAH \n'" . $page . "'   doesn't exist you idiot");
        }
        $data['header'] = view('templates/header');
        $data['footer'] = view('templates/footer');
        return view('pages/' . $page, $data);




        //timeout stuff
        //$session = session();
        //if (null != $session->get('SessionStart')) { //controls user timeout
        //    if ((time() - $session->get('SessionStart')) > 600) { //set to timeout after 10 minutes
        //        $session->destroy();
        //       return view('pages/' . 'login', $data);
        //    } else {
        //        $session->set('SessionStart', time());
        //        return view('pages/' . $page, $data);
        //    }
        //} else {
        //    $session->set('SessionStart', time()); //change this to make it start only whne logged in
        //    return view('pages/' . $page, $data);
        // }




    }

    public function post($post_id)
    {
        $data['header'] = view('templates/header');
        $data['footer'] = view('templates/footer');

        $db = \Config\Database::connect();
        $query = $db->query("select * from posts where ID=" . $post_id . "");
        $posts = $query->getResultArray();

        $posts[0]["id"] = $post_id;

        $replace = ['"', "[", "]", "{", "}", "filename:", "filetitle:"];
        $posts[0]["image"] = str_replace($replace, '', $posts[0]["image"]); //removes all the unnesecary stuff form the filename
        $posts[0]["image"] = explode(",", $posts[0]["image"]);

        $replace = ['"', '[', ']'];
        $posts[0]["tags_id"] = str_replace($replace, '', $posts[0]["tags_id"]);
        if ($posts[0]["tags_id"] != "") {
            $tags_id = explode(",", $posts[0]["tags_id"]);
            $posts[0]["tags_id"] = [];
            $posts[0]["tags"] = [];
            log_message('debug', "aaaaaaaaaaaaaaaaaaaaaaaa" . json_encode($posts[0]["tags_id"]));

            foreach ($tags_id as $tag_id) {
                array_push($posts[0]["tags_id"], $tag_id);
                $query = $db->query("select tags from tags where ID=" . $tag_id . "");
                array_push($posts[0]["tags"], $query->getResultArray()[0]["tags"]);
            }
        } else {
            $posts[0]["tags"] = [];
            array_push($posts[0]["tags"], "");
            $posts[0]["tags_id"] = [];
            array_push($posts[0]["tags_id"], "");
        }


        $query = $db->query("select username, image from account where id=(select account_id from posts where id=" . $post_id . ")");
        $account = $query->getResultArray();

        $data['post_data'] = $posts;
        $data['account_info'] = $account;
        return view('pages/post', $data);
    }

    function index()
    {
        return view('pages/home');
    }
}
