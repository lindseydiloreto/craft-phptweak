<?php
namespace Craft;

class PhpTweakPlugin extends BasePlugin
{

	public function init()
	{
		craft()->phpTweak->initialize($this->getSettings());
	}

	function getName()
	{
		return Craft::t('PHP Tweak');
	}

	function getVersion()
	{
		return '0.9.3';
	}

	function getDeveloper()
	{
		return 'Double Secret Agency';
	}

	function getDeveloperUrl()
	{
		return 'http://doublesecretagency.com';
	}

    public function hasCpSection()
    {
        return $this->getSettings()->showDocs;
    }

	protected function defineSettings()
	{
		return array(
			'showDocs'       => array(AttributeType::Bool,  'label' => 'Enable documentation?', 'default' => true),
			'enableFrontEnd' => array(AttributeType::Bool,  'label' => 'Enable on front-end?',  'default' => true),
			'enableBackEnd'  => array(AttributeType::Bool,  'label' => 'Enable on back-end?',   'default' => false),
			'phpSettings'    => array(AttributeType::Mixed, 'label' => 'PHP Settings',          'default' => array()),
		);
	}

	public function getSettingsHtml()
	{

		// Get existing override settings
		$phpSettings = $this->getSettings()->phpSettings;

		if (!$phpSettings) {
			// Give it a default row
			$phpSettings = array(array('setting' => '', 'value' => ''));
		}

		$phpSettingsTable = craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'        => Craft::t('Which PHP settings would you like to override?'),
				'instructions' => Craft::t('Only settings which can be overridden at a script level (PHP_INI_ALL) will be available here.'),
				'id'           => 'phpSettings',
				'name'         => 'phpSettings',
				//'jsId'         => 'settings-phpSettings',
				'jsName'       => 'settings[phpSettings]',
				'addRowLabel'  => Craft::t('Add an option'),
				'cols'         => array(
					'setting' => array(
						'heading' => Craft::t('PHP Setting'),
						'class'   => 'thin',
						'type'    => 'select',
						'options' => craft()->phpTweak->settingsSelectMenu(),
						//'autopopulate' => 'value'
					),
					'value' => array(
						'heading' => Craft::t('Override Value'),
						'type'    => 'singleline',
						'class'   => 'code'
					),
					'enabled' => array(
						'heading' => Craft::t('Enabled?'),
						'type'    => 'checkbox',
						'class'   => 'thin'
					),
				),
				'rows' => $phpSettings,
				'addRowLabel'  => Craft::t('Add a setting'),
			)
		));

		return craft()->templates->render('phptweak/_settings', array(
			'settings'         => $this->getSettings(),
			'phpSettingsTable' => $phpSettingsTable,
		));
	}
	
}
