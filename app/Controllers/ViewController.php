<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ViewController extends BaseController
{
    public function index(): string
    {
        return view('app_index');
    }

    public function pingDataBase(): ResponseInterface
    {
        $mongo = new \App\Libraries\MongoDBLibrary();
        $connected = $mongo->ping();
        return $this->response->setJSON([
            'status' => $connected ? 'ok' : 'error',
            'connected' => $connected
        ]);
    }
}
