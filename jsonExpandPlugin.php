<?php
namespace Craft;

class JsonExpandPlugin extends BasePlugin
{

	/* --------------------------------------------------------------
	 * PLUGIN INFO
	 * ------------------------------------------------------------ */

	public function getName()
	{
		return Craft::t('JSON Expand');
	}

	public function getVersion()
	{
		return '0.1';
	}

	public function getDeveloper()
	{
		return 'Familiar';
	}

	public function getDeveloperUrl()
	{
		return 'http://familiar.is';
	}

	/* --------------------------------------------------------------
	 * HOOKS
	 * ------------------------------------------------------------ */

	/**
	 * Load the TruncateTwigExtension class from our ./twigextensions
	 * directory and return the extension into the template layer
	 */
	public function addTwigExtension()
	{
		Craft::import('plugins.jsonexpand.twigextensions.JSONExpandTwigExtension');
		return new JSONExpandTwigExtension();
	}

}
