<?php
namespace Craft;

/**
 * Asset Index tool
 */
class AssetIndexTool extends BaseTool
{
	/**
	 * Returns the tool name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Update Asset Indexes');
	}

	/**
	 * Returns the tool's options HTML.
	 *
	 * @return string
	 */
	public function getOptionsHtml()
	{
		$sources = craft()->assetSources->getAllSources();
		$sourceOptions = array();

		foreach ($sources as $source)
		{
			$sourceOptions[] = array(
				'label' => $source->name,
				'value' => $source->id
			);
		}

		return craft()->templates->renderMacro('_includes/forms', 'checkboxSelectField', array(
			array(
				'label'   => Craft::t('Sources'),
				'name'    => 'sources',
				'options' => $sourceOptions
			)
		));
	}
}
