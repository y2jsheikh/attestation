<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/third_party/Html_to_doc.php";

class Doc extends Html_to_doc {

    function __construct() {
        parent::__construct();
    }

    function toDoc($html) {
        $htmltodoc = new Html_to_doc();
        $htmltodoc->createDoc($html, "document");
    }

}
