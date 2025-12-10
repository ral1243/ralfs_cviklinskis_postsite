<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{

    public function view(string $page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException("YOU SUCK WAAAH WAAH \n'" . $page . "'   doesn't exist you idiot");
        }
        $data['header'] = view('templates/header');
        $data['footer'] = view('templates/footer');

            return view('pages/' . $page, $data);
    
    }

    function index()
    {
        return view('index');
    }
}
