<?php
namespace Craft;

class JSONExpand_SectionsController extends BaseController {
    protected $allowAnonymous = true;

    public function actionGetSection() {

      $var = 'this is how it works: '.$section;
      $this->returnJson($var);
    }

}
