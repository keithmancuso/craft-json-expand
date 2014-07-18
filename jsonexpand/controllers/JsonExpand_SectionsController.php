<?php
namespace Craft;

class JsonExpand_SectionsController extends BaseController {
    protected $allowAnonymous = true;

    public function actionGet() {

      $sectionId = craft()->request->getSegments(5);

      $startDate = craft()->request->getParam('startDate', null);

      $criteria = craft()->elements->getCriteria(ElementType::Entry);
      $criteria->sectionId = $sectionId;

      if ($startDate != null) {
        $criteria->startDate > date("U");
      }

      $criteria->place = 'Partnership for After School Education';

      $entries = $criteria->find();

      //$var = 'this is how it works: '.$section;

      $json = craft()->jsonExpand->getJson($entries);

      //return var;
      $this->returnJson($json);
    }

}
