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

        $posts[0]["image"] = str_replace('"', '', $posts[0]["image"]);
        $posts[0]["image"] = str_replace('{', '', $posts[0]["image"]);
        $posts[0]["image"] = str_replace('}', '', $posts[0]["image"]);
        $posts[0]["image"] = str_replace('[', '', $posts[0]["image"]);
        $posts[0]["image"] = str_replace(']', '', $posts[0]["image"]);
        $posts[0]["image"] = str_replace('filename:', '', $posts[0]["image"]); //removes all the unnecessary stuff from the array
        $posts[0]["image"] = str_replace('filetitle:', '', $posts[0]["image"]);
        $posts[0]["image"] = explode(",", $posts[0]["image"]);
        //var_dump($posts[0]["image"]);


        $posts[0]["tags_id"] = str_replace('"', '', $posts[0]["tags_id"]);
        $posts[0]["tags_id"] = str_replace('[', '', $posts[0]["tags_id"]);
        $posts[0]["tags_id"] = str_replace(']', '', $posts[0]["tags_id"]);
        $tags_id = explode(",", $posts[0]["tags_id"]);
         $posts[0]["tags_id"] = [];
        foreach($tags_id as $tag_id){
            $query = $db->query("select tags from tags where ID=" . $tag_id . "");

            //array_push($posts[0]["tags_id"], $query->getResultArray());
           // var_dump($posts[0]["tags_id"]);
           //var_dump($query->getResultArray());
           //echo $query->getResultArray()[0]["tags"];
           array_push($posts[0]["tags_id"], $query->getResultArray()[0]["tags"]);

        }
        

        
        $data['post_data'] = $posts;
        return view('pages/post', $data);
    }

    function index()
    {
        return view('pages/home');
    }
}
