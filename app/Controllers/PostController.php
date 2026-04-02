<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;

class PostController extends BaseController
{



    public function fetchTags()
    {         //ar ajax request dabūj visus tags
        $db = db_connect();
        $result = $db->query('SELECT * FROM tags as tags');               // izmanto view lai iegūtu visus tags
        $result->getResultArray();
        return $this->response->setJSON([
            'error' => false,
            'message' => $result
        ]);
    }


    public function add()
    {                                             //saglabā form
        $nameArray = [];
        if ($imagefile = $this->request->getFiles()) {

            foreach ($imagefile['titleimage'] as $img) {                    //izveido nosaukumu kas satur uz nejaušību ģenerētus burtus un to saglabā
                $randName = $img->getRandomName();
                $img->move('uploads/avatar', $randName);
                $nameArray[] = [
                    "filename" => $randName,
                ];
            }           
            log_message('debug', json_encode($nameArray));
        }

        $session = session();

        $data = [                                                       //saliek fisu form informāciju masīvā lai to saglabātu
            'account_id' => (int) $session->get('account_id'),
            'title' => $this->request->getPost('title'),
            'price' => $this->request->getPost('price'),
            'description' => "' ".$this->request->getPost('description')." '",
            'image' => json_encode($nameArray),
            'created_at' => date('Y-m-d H:i:s'),
            'tags_id' => $this->request->getPost('fullTags')
        ];
        $postModel = new \App\Models\PostModel();
        log_message('debug', "full data to send to db" . json_encode($data));
        $postModel->save($data);                                    //saglabā masīvu datubāzē

        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully added new post!'
        ]);
    }





    public function fetch($condition)
    {
        $condition = explode("-", $condition);
        log_message('debug', json_encode($condition));
        switch ($condition[0]) {

            case "search":
                $db = new \App\Models\PostModel();
                $query = $db->query('select ID, title, price, image, created_at FROM posts WHERE title LIKE "%' . $condition[1] . '%" order by id desc');
                $result = $query->getResultArray();
                break;
            case "tags":
                array_shift($condition);
                $db = new \App\Models\PostModel();

                $query = 'select ID, title, price, image, created_at FROM posts WHERE  ';
                foreach ($condition as $tag_id) {
                    $query .= ' or tags_id like "%' . $tag_id . '%"';
                }
                $query .= ' order by id desc';

                $query = str_replace("  or ", "", $query);
                //log_message('debug', $query);
                $query = $db->query($query);
                $result = $query->getResultArray();
                break;
            default:
                $db = new \App\Models\PostModel();
                $result = $db->query('select ID, title, price, image, created_at FROM posts order by id desc');
                $result = $result->getResultArray();
                break;
        }



        $data = '';

        if ($result) {                                               //izveido html ar kuru rādīs visus post 
            $session = session();
            foreach ($result as $post) {
                $nameArray = json_decode($post['image'], true);

                $data .= '
                <div id="' . $post['ID'] . '" style="width:200px" class="post col p-1 container row border border-black m-1 p-0">
                    <img class="col p-0" src="uploads/avatar/' . $nameArray[0]['filename'] . '">
                      <div class=""> ' . $post['title'] . ' </div>
                      <div class=""> ' . $post['price'] . ' </div> 
                      <div id="date">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                </div>';
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'error' => false,
                'message' => '<div class="text-secondary text-center fw-bold my-5">No posts found in the database!</div>'
            ]);
        }
    }

    public function edit()
    {
        $image_selected = 0;
        $nameArray = [];
        $imagefile = $this->request->getFiles();
        if ($imagefile['titleimage'][0]->isValid() == 1) {
            foreach ($imagefile['titleimage'] as $img) {                    //izveido nosaukumu kas satur uz nejaušību ģenerētus burtus un to saglabā
                $randName = $img->getRandomName();
                log_message('debug', 'uploaded images');
                $nameArray[] = [
                    "filename" => $randName,
                ];
            }
            $image_selected = 1;
            log_message('debug', json_encode($nameArray));
        }

        $session = session();

        $db = \Config\Database::connect();
        $query = 'SELECT `edit_post`(' . $this->request->getPost('postID') . ', '
            . $session->get('account_id') . ', '
            . $image_selected . ', "'
            . $this->request->getPost("title") . '", "'
            . $this->request->getPost("price") . '", '
            . $db->escape($this->request->getPost('description')) . ', '
            . $db->escape(json_encode($nameArray)) . ', '
            . $db->escape($this->request->getPost("fullTags")) . ') as edit';
        log_message('debug', "full data to send to db" . json_encode($query));
        $query = $db->query($query);
        $result = $query->getResultArray();




        if ($result[0]["edit"] == "success") {
            if ($imagefile['titleimage'][0]->isValid() == 1) {
                foreach ($imagefile['titleimage'] as $index => $img) {                    //izveido nosaukumu kas satur uz nejaušību ģenerētus burtus un to saglabā
                    $img->move('uploads/avatar', $nameArray[$index]['filename']);
                    log_message('debug', 'file to save' . $nameArray[$index]['filename']);
                }


                helper('filesystem');
                foreach (json_decode($this->request->getPost("oldimages")) as $img) {
                    log_message('debug', "removing file - " . $img);
                    try {
                        unlink(APPPATH . "/../public/uploads/avatar/" . $img);
                    } catch (Exception) {
                        log_message('debug', "file already deleted");
                    }
                }
            }
        }

        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully added new post!'
        ]);
    }

    public function updateLLLLLLLLLL()
    {                                          //atjaunina rediģēto post 

        $id = $this->request->getPost('id');
        $unlinkfiles = $this->request->getPost('old_image');
        $unlinkfiles = json_decode($unlinkfiles, true);
        $newnameArray = [];
        $oldnamearray = [];
        $dbNamearray = [];
        $i = "a";
        log_message('debug', "nonseperated" . json_encode($unlinkfiles));
        if ($unlinkfiles != '') {
            foreach ($unlinkfiles as &$img) {
                log_message('debug', "seperated " . $img['oldname']);
                unlink('uploads/avatar/' . $img['oldname']);
                $oldnameArray[] = [
                    "filename" => $img['oldname']
                ];
            }
        }/*else {
            foreach ($unlinkfiles as &$img) {
            $fileName = $this->request->getPost('old_image');
            }
        } */


        $i = 0;
        $dbfiles = $this->request->getPost('fulldbName');
        $dbfiles = json_decode($dbfiles, true);
        foreach ($dbfiles as $img) {
            $dbNamearray[] = [
                "filename" => $img['filename'],
                "originalfilename" => $img['original'],
                "filetitle" => $img['filetitle']
            ];
            log_message('debug', $dbNamearray[$i]['filename']);
            $i++;
        }
        if ($unlinkfiles != '') {
            foreach ($unlinkfiles as $img) {
                log_message('debug', $img['oldname']);
                unlink('uploads/avatar/' . $img['oldname']);
                // log_message('debug', $img['oldname']);
            }
        }


        if ($imagefile = $this->request->getFiles()) {

            $i = 0;
            foreach ($imagefile['edittitleimage'] as $img) {
                if ($img->isValid() && ! $img->hasMoved()) {
                    $origName = $_FILES['edittitleimage']['name'][$i];
                    $origNameconverted = $this->fileSlug($origName);
                    $randName = $img->getRandomName();
                    $randName = $origNameconverted . "_" . $randName;
                    $newnameArray[] = [
                        "filename" => $randName,
                        "originalfilename" => $origName,
                    ];
                    #log_message('debug', json_encode($nameArray[$i], true));
                    $img->move('uploads/avatar', $randName);
                    $i++;
                }
            }
            $i = 0;
            $imagefile = $this->request->getPost('fullName');
            $imagefile = json_decode($imagefile, true);
            foreach ($newnameArray as &$name) {
                $name['filetitle'] = $imagefile[$i]['filetitle'];
                $i++;
            }
            $fullnameArray = array_merge($dbNamearray, $newnameArray);
            $fullnameArray = json_encode($fullnameArray);
        }

        $tagArray = [];
        $tag = $this->request->getPost('tags');
        // foreach ($tag as $img) {
        $tagArray[] = [
            "posttag" => ""
        ];
        // }



        /*         $id = $this->request->getPost('id');
        $file = $this->request->getFile('file');
        $fileName = $file->getFilename();

        if ($fileName != '') {
            $fileName = $file->getRandomName();
            $file->move('uploads/avatar', $fileName);
            if ($this->request->getPost('old_image') != '') {
                unlink('uploads/avatar/' . $this->request->getPost('old_image'));
            }
        } else {
            $fileName = $this->request->getPost('old_image');
        } */

        $data = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'body' => $this->request->getPost('body'),
            'image' => $fullnameArray,
            'updated_at' => date('Y-m-d H:i:s'),
            //'tags' => $tagArray
        ];

        $postModel = new \App\Models\PostModel();
        $postModel->update($id, $data);
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully updated post!'
        ]);
    }

    public function delete($post_id)
    {                                //izdzēš izvēlēto post
        $session = session();
        $db = \Config\Database::connect();
        $query = $db->query('SELECT `post_deletion` ("' . $post_id . '", "' . $session->get('account_id') . '") as removed');
        $result = $query->getResultArray();
        $result = $result[0]["removed"];
        $replace = ['"', "[", "]", "{", "}", "filename:"];
        $result = str_replace($replace, '', $result);
        $result = explode(",", $result);
        log_message('debug', json_encode($result));
        if ($result[0] == "success") {
            array_shift($result);
            helper('filesystem');
            foreach ($result as $img) {
                log_message('debug', "removing file - " . $img);
                try {
                    unlink(APPPATH . "/../public/uploads/avatar/" . $img);
                } catch (Exception) {
                    log_message('debug', "file already deleted");
                }
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => 'success'
            ]);
        } else {
            return $this->response->setJSON([
                'error' => false,
                'message' => 'failed'
            ]);
        }






        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully deleted post!'
        ]);
    }
}
