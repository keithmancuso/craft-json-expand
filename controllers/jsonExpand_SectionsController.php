<?php
namespace Craft;

class JsonExpand_SectionsController extends BaseController {
    protected $allowAnonymous = true;

    public function actionQuery() {

      $sectionId = craft()->request->getParam('sectionId');

      $criteria = craft()->elements->getCriteria(ElementType::Entry);
      $criteria->sectionId = $sectionId;
      $entries = $criteria->find();

      //$var = 'this is how it works: '.$section;

      $json = craft()->jsonExpand->getJson($entries);

      //return var;
      $this->returnJson($json);
    }

}
