<?php
namespace Craft;

class JSONExpandTwigExtension extends \Twig_Extension {

	public function getName() {
		return Craft::t('JSON');
	}

	public function getFilters() {
		return array(
			'json_expand' => new \Twig_Filter_Method($this, 'jsonExpandFilter')
		);
	}

	public function jsonExpandFilter($content) {

		if (is_array($content)) {

			$expandedContent = array();

			foreach ($content as $entry) {
				$expandedContent[] = craft()->jsonExpand->getEntryJson($entry);
			}

		} elseif (is_object($content)) {
			$expandedContent = craft()->jsonExpand->getEntryJson($content);


		} else {
			$expandedContent = null;
		}

		return JsonHelper::encode($expandedContent);

	}

}
