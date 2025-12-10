<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PostController extends BaseController {
  

    public function login($login) {
        $db = db_connect();
        $login = explode(",", $login);
        $query = $db->query('SELECT `login`('.$login[0].', '.$login[1].')');
        $login = $query->getResultArray();
        return $this->response->setJSON([
            'error' => false,
            'message' => $login
        ]);
    }

    public function signup($signup) {
        $db = db_connect();
        $signup = explode(",", $signup);
        $query = $db->query('SELECT `create_account`('.$db->escape($signup[0]).', '.$db->escape($signup[1]).', '.$signup[2].', '.$db->escape($signup[3]).') as login');
        $signup = $query->getRow();
        log_message('debug', "--------------------------".json_encode($signup));
        return $this->response->setJSON([
            'error' => false,
            'message' => $signup
        ]);
    }

    public function fetchTags() {         //ar ajax request dabūj visus tags
        $db = db_connect();
        $query = $db->query('SELECT tags FROM posts');               // izmanto view lai iegūtu visus tags
        $allTags = array_column($query->getResultArray(), 'tags');;
        return $this->response->setJSON([
            'error' => false,
            'message' => $allTags
        ]);
        
    }


        public function add() {                                             //saglabā form
        if ($imagefile = $this->request->getFiles()) {  
            $nameArray = [];
            $i = 0;
            foreach ($imagefile['titleimage'] as $img) {                    //izveido nosaukumu kas satur uz nejaušību ģenerētus burtus un to saglabā
                if ($img->isValid() && ! $img->hasMoved()) {                //vienā masīvā kas satur oriģinālo nosaukumu un lietotāja veidoto nosaukumu 
                    $origName = $_FILES['titleimage']['name'][$i];
                    $i ++;
                    $origNameconverted = $this->fileSlug($origName);
                    $randName = $img->getRandomName();
                    $randName = $origNameconverted. "_". $randName;
                    $nameArray[] = [
                        "filename" => $randName,
                        "originalfilename" => $origName,
                    ];
                    $img->move('uploads/avatar', $randName);
                }
            }
            $i = 0;
            $imagefile = $this->request->getPost('fullName');
                $imagefile = json_decode($imagefile, true);
            foreach ($nameArray as &$name) {
                $name['filetitle'] = $imagefile[$i]['filetitle'];
                $i ++;
        }
            $nameArray = json_encode($nameArray);
        }

        $tagArray = [];
        $tag = $this->request->getPost('tags');                         //izveido masīvu ar visiem form tags
        if ($tag != "") {
        foreach ($tag as $img) {
            $tagArray[] = $img;
        }
    }else{
        $tagArray = NULL;
    }
        $tagArray = json_encode($tagArray);

        $data = [                                                       //saliek fisu form informāciju masīvā lai to saglabātu
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('price'),
            'body' => $this->request->getPost('body'),
            'image' => $nameArray,
            'created_at' => date('Y-m-d H:i:s'),
            'tags' => $tagArray
        ];          
            $postModel = new \App\Models\PostModel();
            $postModel->save($data);                                    //saglabā masīvu datubāzē
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Successfully added new post!'
            ]);
    }

    public function fetch($tagsArray) {                                                   
        $postModel = new \App\Models\PostModel();
        $posts = $postModel->findAll();
        
         if($tagsArray != "empty"){                                 //izvelk post no datubžes kuriem ir filtrētais tag
            $db = \Config\Database::connect();
            $query = $db->query('SELECT * FROM posts WHERE tags ?| array[' . $tagsArray . ']');
            $posts = $query->getResultArray();
        } 

        #log_message('debug', "shit".json_encode($posts));
        $data = '';

        if ($posts) {                                               //izveido html ar kuru rādīs visus post 
            $post_id = 0;
            foreach ($posts as $post) {
                $post_id++;
                #<div id="date' . $post_id . '" style="display: none">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                #'<div id="post" onmouseover="show_post_date('.$date.')" onmouseleave="hide_post_date('.$date.')" class="col-2 container row border border-black m-1 p-0">';


               $nameArray = json_decode($post['image'], true);   
               #$date = "'date$post_id'";   
                $data .= '<div id="post" class="col-2 container row border border-black m-1 p-0">';
                foreach ($nameArray as $imgName) {
                    $data .= '<img class="col" src="uploads/avatar/' . $imgName['filename'] . '">';
                break;
                }
                $data .= '
                    
                      <div class=""> ' . $post['title'] . ' </div>
                      <div class=""> ' . $post['price'] . ' </div> 
                      <div id="date">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                      
<!--
 <p>
                      ' . substr($post['description'], 0, 80) . '...      
                    </p>
-->                 
                    
                    <!--
                    <div>
                      <a href="#" id="' . $post['ID'] . '" ">Edit</a>

                      <a href="#" id="' . $post['ID'] . '" ">Delete</a>
                    </div>
                    -->
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

    public function edit($id = null) {
        $postModel = new \App\Models\PostModel();               //izvelk izvelēto form no datubāzes
        $post = $postModel->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post
        ]);
    }

    public function update() {                                          //atjaunina rediģēto post 

        $id = $this->request->getPost('id');
        $unlinkfiles = $this->request->getPost('old_image');
        $unlinkfiles = json_decode($unlinkfiles, true);
        $newnameArray = [];
        $oldnamearray = [];
        $dbNamearray = [];
        $i;
        log_message('debug', "nonseperated".json_encode($unlinkfiles));
         if ($unlinkfiles != '') {     
            foreach ($unlinkfiles as &$img) {
                log_message('debug', "seperated ".$img['oldname']);
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
        if($unlinkfiles != ''){
            foreach($unlinkfiles as $img){
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
                    $randName = $origNameconverted. "_". $randName;
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

    public function delete($id = null) {                                //izdzēš izvēlēto post
        $postModel = new \App\Models\PostModel();
        $post = $postModel->find($id);
        $post = json_decode($post['image'], true);
        $postModel->delete($id);
        foreach ($post as $del) {
            unlink('uploads/avatar/' . $del["filename"]);
        }
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully deleted post!'
        ]);
    }


    public function detail($id = null) {                                 //parāda post informāciju
        $postModel = new \App\Models\PostModel();
        $post = $postModel->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post
        ]);
    } 
}