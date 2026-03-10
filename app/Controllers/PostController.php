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
                //$origName = $_FILES['titleimage']['name'][$i];          //vienā masīvā kas satur oriģinālo nosaukumu un lietotāja veidoto nosaukumu 

                //$i++;
                //$origNameconverted = $this->fileSlug($origName);
                //$randName = $img->getRandomName();
                //$randName = $origNameconverted . "_" . $randName; //izņem speciālus simbolus un pieliek random burtus/ciparus pie nosaukuma
                //$nameArray[] = [
                //    "filename" => $randName,
                //];

            }           //this shit was for combining random and user made name, dont plan on using it so remove
            log_message('debug', json_encode($nameArray));
            //$i = 0;
            //$imagefile = $this->request->getPost('fullName');
            // $imagefile = json_decode($imagefile, true);
            //foreach ($nameArray as &$name) {
            //    $name['filetitle'] = $imagefile[$i]['filetitle'];
            //    $i++;
            // }
            //$nameArray = json_encode($nameArray);
        }


        $session = session();

        $data = [                                                       //saliek fisu form informāciju masīvā lai to saglabātu
            'account_id' => (int) $session->get('account_id'),
            'title' => $this->request->getPost('title'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
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





    public function fetch($tagsArray)
    {
        $postModel = new \App\Models\PostModel();

        if ($tagsArray != "empty") {                                 //izvelk post no datubžes kuriem ir filtrētais tag
            $db = \Config\Database::connect();
            $query = $db->query('SELECT * FROM posts WHERE tags ?| array[' . $tagsArray . ']');
            $posts = $query->getResultArray();
        } else {
            $posts = $postModel->findAll();
        }

        #log_message('debug', "shit".json_encode($posts));
        $data = '';

        if ($posts) {                                               //izveido html ar kuru rādīs visus post 
            $post_id = 0;
            $session = session();
            foreach ($posts as $post) {
                $post_id++;
                #<div id="date' . $post_id . '" style="display: none">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                #'<div id="post" onmouseover="show_post_date('.$date.')" onmouseleave="hide_post_date('.$date.')" class="col-2 container row border border-black m-1 p-0">';





                $nameArray = json_decode($post['image'], true);
                #$date = "'date$post_id'";   
                $data .= '<div id="' . $post['ID'] . '" class="post col-2 container row border border-black m-1 p-0">';

                foreach ($nameArray as $imgName) {
                    $data .= '<img class="col" src="uploads/avatar/' . $imgName['filename'] . '">';
                    break;              #deprecated
                }
                $data .= '
                    
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
        $image_selected = 1;
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
            log_message('debug', json_encode($nameArray));
        }

        $session = session();

        $db = \Config\Database::connect();
        //if($image_selected == 1){
        $query = 'SELECT `edit_post`(' . $this->request->getPost('postID') . ', '
            . $session->get('account_id') . ', '
            . $image_selected . ', "'
            . $this->request->getPost("title") . '", "'
            . $this->request->getPost("price") . '", "'
            . $this->request->getPost("description") . '", '
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
