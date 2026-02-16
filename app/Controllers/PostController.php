<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PostController extends BaseController
{



    public function fetchTags()
    {         //ar ajax request dabūj visus tags
        $db = db_connect();
        $query = $db->query('SELECT tags FROM posts');               // izmanto view lai iegūtu visus tags
        $allTags = array_column($query->getResultArray(), 'tags');;
        return $this->response->setJSON([
            'error' => false,
            'message' => $allTags
        ]);
    }


    public function add()
    {                                             //saglabā form
        $nameArray = [];
        if ($imagefile = $this->request->getFiles()) {
            $i = 0;
            foreach ($imagefile['titleimage'] as $img) {                    //izveido nosaukumu kas satur uz nejaušību ģenerētus burtus un to saglabā
                if ($img->isValid() && ! $img->hasMoved()) {                //vienā masīvā kas satur oriģinālo nosaukumu un lietotāja veidoto nosaukumu 
                    $origName = $_FILES['titleimage']['name'][$i];

                    $i++;
                    $origNameconverted = $this->fileSlug($origName);
                    $randName = $img->getRandomName();
                    $randName = $origNameconverted . "_" . $randName; //izņem speciālus simbolus un pieliek random burtus/ciparus pie nosaukuma
                    $nameArray[] = [
                        "filename" => $randName,
                    ];
                    $img->move('uploads/avatar', $randName);
                }
            }
            $i = 0;
            $imagefile = $this->request->getPost('fullName');
            $imagefile = json_decode($imagefile, true);
            foreach ($nameArray as &$name) {
                $name['filetitle'] = $imagefile[$i]['filetitle'];
                $i++;
            }
            $nameArray = json_encode($nameArray);
        }


        $session = session();

        $data = [                                                       //saliek fisu form informāciju masīvā lai to saglabātu
            'account_id' => (int) $session->get('account_id'),
            'title' => $this->request->getPost('title'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'image' => $nameArray,
            'created_at' => date('Y-m-d H:i:s'),
            'tags_id' => $this->request->getPost('fullTags')
        ];
        $postModel = new \App\Models\PostModel();
        $postModel->save($data);                                    //saglabā masīvu datubāzē
        log_message('debug', "full data to send to db" . json_encode($data));
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
            foreach ($posts as $post) {
                $post_id++;
                #<div id="date' . $post_id . '" style="display: none">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                #'<div id="post" onmouseover="show_post_date('.$date.')" onmouseleave="hide_post_date('.$date.')" class="col-2 container row border border-black m-1 p-0">';

                $session = session();
                
                if ($session->get('account_id') == $post['account_id']) {
                    $loggedIn =
                        '<div>
                      <a href="#" class="post_edit_button" id="' . $post['ID'] . '" ">Edit</a>

                      <a href="#" class="post_delete_button" id="' . $post['ID'] . '" ">Delete</a>
                    </div>';
                } else {
                    $loggedIn = '';
                }

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
                    ' . $loggedIn . '
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

    public function edit($id = null)
    {
        $postModel = new \App\Models\PostModel();               //izvelk izvelēto form no datubāzes
        $post = $postModel->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post
        ]);
    }

    public function update()
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
        $query = $db->query('SELECT `post_deletion` ("' . $post_id . '", "' . $session->get('account_id') . '")');
        $posts = $query->getResultArray();

        log_message('debug', "-------------------------------deleting--------------" . json_encode($posts)); //maybe move to the posts page not preview
        

        if($posts == "deleted"){
        foreach ($post as $del) {
            log_message('debug', "-------------------------------deleting--------------" . json_encode($del));
        //    unlink('uploads/avatar/' . $del["filename"]);
        }}

        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully deleted post!'
        ]);
    }


}
