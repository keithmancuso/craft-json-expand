<?php
namespace Craft;

class JsonExpandTwigExtension extends \Twig_Extension {

	public function getName() {
		return Craft::t('JSON Expand');
	}

	public function getFilters() {
		return array(
			'json_expand' => new \Twig_Filter_Method($this, 'jsonExpandFilter')
		);
	}

	public function jsonExpandFilter($content) {

		$expandedContent = craft()->jsonExpand->getJson($content);

		return JsonHelper::encode($expandedContent);

	}

}
