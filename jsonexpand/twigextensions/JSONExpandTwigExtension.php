<?php
namespace Craft;

class JSONExpandTwigExtension extends \Twig_Extension
{

	public function getName()
	{
		return Craft::t('JSON');
	}

	public function getFilters()
	{
		return array(
			'json_expand' => new \Twig_Filter_Method($this, 'jsonExpandFilter')
		);
	}

	public function jsonExpandFilter($content)
	{

		if (is_array($content)) {

			$expandedContent = array();
			foreach ($content as $entry) {

				$expandedContent[] = $this->getEntryJson($entry);

			}

		} elseif (is_object($content)) {

			$expandedContent = $this->getEntryJson($content);

		} else {

			$expandedContent = null;

		}

		return JsonHelper::encode($expandedContent);

	}

	private function getEntryJson(EntryModel $entry)
	{
	    $entryData = array();

			$entryData['title'] = $entry->title;

	    foreach ($entry->getType()->getFieldLayout()->getFields() as $field)
	    {

				$field = $field->getField();
        $handle = $field->handle;
        $value = $entry->$handle;

				// TODO: Need to add conditionals for Matrix, dropdowns

				// check if its a relational field type
				if ( $field['type'] == 'Categories' || $field['type'] == 'Users' || $field['type'] == 'Assets' || $field['type'] == 'Entries' || $field['type'] == 'Matrix'  ) {

					// for each related element
					foreach ($value as $key=> $relatedElement)
					{

						$relatedArray = array (
							'id' => $relatedElement->id,
							'label' => (string) $relatedElement
						);

						// add additional standard fields for different types
						if ($field['type'] == 'Catgories') {
							$relatedArray['slug'] = $relatedElement->slug;
						} else if ($field['type'] == 'Assets') {
							$relatedArray['url'] = $relatedElement->url;
							$relatedArray['filename'] = $relatedElement->filename;
						} else if ($field['type'] == 'Users') {
							$relatedArray['firstName'] = $relatedElement->firstName;
							$relatedArray['lastName'] = $relatedElement->lastName;
						}

						// TODO: get asset transforms for each asset

						foreach ($relatedElement->getFieldLayout()->getFields() as $subField)
						{

							$subField = $subField->getField();
							$subHandle = $subField->handle;
							$subValue = $relatedElement->$subHandle;

							//$categoryObject[$subHandle]['field'] =  $subField;
							//echo 'GOT FIELD'.$subHandle;
							$relatedArray[$subHandle] = $subValue;
							//var_dump($categoryObject);

						}

						$entryData[$handle][] = $relatedArray;
					}

				} else {

					// Deal with Checkboxes and Multi-select fields
					// these are pulled over from brandons code but dont seem to work?
					if ($value instanceof \ArrayObject)
					{
					    $value = array_merge($value);
					}

					if (is_array($value))
					{
					    $entryData[$handle] = $value;
					} else {
						// out field info for debugging
						//$entryData[$handle] = $field;
						$entryData[$handle] = $value;

					}

				}

	    }

	    return $entryData;
	}


	// not in use now but seemed like a good idea to abstract out?
	private function getFieldData($field) {


		$fieldObject;
		$field = $field->getField();
		$handle = $field->handle;
		$value = $entry->$handle;
		$fieldObject->$handle = $value;
		return $fieldObject;

	}

}
