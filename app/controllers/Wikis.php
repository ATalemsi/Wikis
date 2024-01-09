<?php

class Wikis extends Controller
{
    private $wikismodel;

    public function __construct()
    {
        $this->wikismodel = $this->model('wiki');
    }
    public function index()
    {
        // get Projects

        $wikis = $this->wikismodel->getWikis();
        $data = [
            'wikis' => $wikis
        ];
        $this->view('wikis/index', $data);
    }
    public function add()
    {
        $wikis = $this->wikismodel->getWikis();
        $data = [
            'wikis' => $wikis
        ];
        $this->view('wikis/add', $data);
    }
}