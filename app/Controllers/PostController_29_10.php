<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PostController extends BaseController {
    public function index() {
        return view('index');
    }



     // handle add new post ajax request
        public function add() {
/*         $file = $this->request->getFile('file');
        $fileName = $file->getRandomName(); */
        /* rename("../../writable/uploads/". $newName, "../../writable/uploads/manabilde". $filenumber. ".jpg");
                    $filenumber ++; */

        if ($imagefile = $this->request->getFiles()) {  
            $nameArray = [];
            $arrayNum = 0;
            foreach ($imagefile['titleimage'] as $img) {
                if ($img->isValid() && ! $img->hasMoved()) {
                    $origName = $_FILES['titleimage']['name'][$arrayNum];
                    $arrayNum ++;
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
            $arrayNum = 0;
            $imagefile = $this->request->getPost('fullName');
                $imagefile = json_decode($imagefile, true);
            foreach ($nameArray as &$name) {
                $name['filetitle'] = $imagefile[$arrayNum]['filetitle'];
                $arrayNum ++;
        }
            $nameArray = json_encode($nameArray);
        }


        $data = [ 
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'body' => $this->request->getPost('body'),
            'image' => $nameArray,
            'created_at' => date('Y-m-d H:i:s')
        ];          
            $postModel = new \App\Models\PostModel();
            $postModel->save($data);
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Successfully added new post!'
            ]);
    }
    // handle fetch all posts ajax request
    public function fetch() {
        $postModel = new \App\Models\PostModel();
        $posts = $postModel->findAll();
        $data = '';

        if ($posts) {
            foreach ($posts as $post) {
               $nameArray = json_decode($post['image'], true);
                $data .= '<div class="col-md-4">
                <div class="card shadow-sm">';
                foreach ($nameArray as $imgName) {
                    $data .= '
                  <a href="#" id="' . $post['id'] . '" data-bs-toggle="modal" data-bs-target="#detail_post_modal" class="post_detail_btn"><img src="uploads/avatar/' . $imgName['filename'] . '" class="img-fluid card-img-top"></a>';
                }
                $data .= '<div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="card-title fs-5 fw-bold">' . $post['title'] . '</div>
                      <div class="badge bg-dark">' . $post['category'] . '</div>
                    </div>
                    <p>
                      ' . substr($post['body'], 0, 80) . '...
                    </p>
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="fst-italic">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                    <div>
                      <a href="#" id="' . $post['id'] . '" data-bs-toggle="modal" data-bs-target="#edit_post_modal" class="btn btn-success btn-sm post_edit_btn">Edit</a>

                      <a href="#" id="' . $post['id'] . '" class="btn btn-danger btn-sm post_delete_btn">Delete</a>
                    </div>
                  </div>
                </div>
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

    // handle edit post ajax request
    public function edit($id = null) {
        $postModel = new \App\Models\PostModel();
        $post = $postModel->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post
        ]);
    }

    // handle update post ajax request
    public function update() {


        if ($imagefile = $this->request->getFiles()) {  
            $nameArray = [];
            $arrayNum = 0;
            foreach ($imagefile['titleimage'] as $img) {
                if ($img->isValid() && ! $img->hasMoved()) {
                    $origName = $_FILES['titleimage']['name'][$arrayNum];
                    $arrayNum ++;
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
            $arrayNum = 0;
            $imagefile = $this->request->getPost('fullName');
                $imagefile = json_decode($imagefile, true);
            foreach ($nameArray as &$name) {
                $name['filetitle'] = $imagefile[$arrayNum]['filetitle'];
                $arrayNum ++;
        }
            $nameArray = json_encode($nameArray);
            log_message('debug', $nameArray);
        }





        $id = $this->request->getPost('id');
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
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'body' => $this->request->getPost('body'),
            'image' => $fileName,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $postModel = new \App\Models\PostModel();
        $postModel->update($id, $data);
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully updated post!'
        ]);
    }

    // handle delete post ajax request
    public function delete($id = null) {
        $postModel = new \App\Models\PostModel();
        $post = $postModel->find($id);
        $postModel->delete($id);
        unlink('uploads/avatar/' . $post['image']);
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully deleted post!'
        ]);
    }

    // handle fetch post detail ajax request
    public function detail($id = null) {
        $postModel = new \App\Models\PostModel();
        $post = $postModel->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post
        ]);
    } 
}