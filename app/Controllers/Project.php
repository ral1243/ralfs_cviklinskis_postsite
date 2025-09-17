<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
 
class Project extends ResourceController
{
    protected $modelName = 'App\Models\ProjectModel';
    protected $format    = 'json';
 
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond($this->model->findAll(), 200);
    }
 
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if(is_null($data)) {
            return $this->fail(['error' => 'Project does not exist'], 404);
        }
 
        return $this->respond($data,200);
    }
 
     
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];
 
        if ($this->model->insert($data) === false){
             
            $response = [
                'errors' => $this->model->errors(),
                'message' => 'Invalid Inputs'
            ];
 
            return $this->fail($response , 409);
        }
         
        return $this->respond(['message' => 'Created Successfully'],201);
    }
 
    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
        ];
  
        if ($this->model->where('id', $id)->set($data)->update() === false)
        {
            $response = [
                'errors' => $this->model->errors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 409);
        }
  
        return $this->respond(['message' => 'Updated Successfully'], 200);
    }
 
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond(['message' => 'Deleted Successfully'], 200);
    }
}