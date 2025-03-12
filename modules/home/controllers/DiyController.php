<?php

class DiyController {
    
    public function __construct() {
    }

    public function index() {
        $diyView = new DiyView();
        $diyView->show();
    }
} 