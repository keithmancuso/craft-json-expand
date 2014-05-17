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
			foreach ($content as $key => $value) {

				$expandedContent[] = $this->getEntryJson($value);

			}

		} elseif (is_object($content)) {

			$expandedContent = $this->getEntryJson($content);

		} else {

			$expandedContent = null;

		}

		return JsonHelper::encode($expandedContent);

	}

	public function getEntryJson(EntryModel $entry)
	{
	    $entryData = array();

	    foreach ($entry->getType()->getFieldLayout()->getFields() as $field)
	    {
	        $field = $field->getField();
	        $handle = $field->handle;
	        $value = $entry->$handle;

	        if ($field instanceof BaseElementFieldType)
	        {
	            $entryData[$handle] = array();

	            foreach ($value as $relElement)
	            {
	                $entryData[$handle][] = array(
	                    'id' => $relElement->id,
	                    'label' => (string) $relElement
	                );
	            }
	        }
	        else if ($field instanceof MatrixFieldType)
	        {
	            $entryData[$handle] = array();

	            foreach ($value as $block)
	            {
	                $entryData[$handle][] = array(
	                    // ...
	                );
	            }
	        }
	        else
	        {
	            // Deal with Checkboxes and Multi-select fields
	            if ($value instanceof \ArrayObject)
	            {
	                $value = array_merge($value);
	            }

	            if (is_array($value))
	            {
	                $entryData[$handle] = $value;
	            }
	            else
	            {
	                // Let's just force anything else to a string, in case it's something like a SingleOptionFieldData class
	                //$entryData[$handle] = (string) $value;
	            }

	            $entryData[$handle] = $value;
	        }
	    }

	    return $entryData;
	}

}
