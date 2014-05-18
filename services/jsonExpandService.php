<?php
namespace Craft;

class JsonExpandService extends BaseApplicationComponent {

    public function getEntryJson($entry) {

      $entryData = array();
      $entryData['title'] = $entry->title;

      foreach ($entry->getType()->getFieldLayout()->getFields() as $field) {

        $field = $field->getField();
        $handle = $field->handle;
        $value = $entry->$handle;

        if ($value instanceof \ArrayObject) {
          $value = array_merge((array)$value);
        }

        // check if its a relational field type
        if ( $field['type'] == 'Categories' || $field['type'] == 'Users' || $field['type'] == 'Assets' || $field['type'] == 'Entries' || $field['type'] == 'Matrix'  ) {

          // for each related element
          foreach ($value as $relatedElement) {

            $relatedArray = array();

            // gets all the default attributes from the element
            $relatedArray = $relatedElement->getAttributes();

            // setup switch for fieldtype specific further customizations
            switch ($field['type']) {
              case 'Assets':
                $relatedArray['url'] = $relatedElement->url;
                break;

             }

            // get all the custom fields
            foreach ($relatedElement->getFieldLayout()->getFields() as $subField) {

              $subField = $subField->getField();
              $subHandle = $subField->handle;
              $subValue = $relatedElement->$subHandle;

              if ($subValue instanceof \ArrayObject) {
                  $subValue = array_merge((array)$subValue);
              }

              $relatedArray[$subHandle] = $subValue;

            }
            // add the item to the fields array
            $entryData[$handle][] = $relatedArray;
          }


        } else {
          // just set the field value to the field
          $entryData[$handle] = $value;
        }
      }

      return $entryData;

    }

}
