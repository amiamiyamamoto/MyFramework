<?php

class OtherController extends BaseController {
    public function action() {
        $this->setStatusCode('404');
        $this->displayHtml('404');        
    }
}
