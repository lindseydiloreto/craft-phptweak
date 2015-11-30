<?php
namespace Craft;

class PhpTweakPlugin extends BasePlugin
{

	public function init()
	{
		parent::init();
		craft()->phpTweak->initialize($this->getSettings());
	}

	public function getName()
	{
		return Craft::t('PHP Tweak');
	}

	public function getDescription()
	{
		return 'Override PHP settings from the control panel.';
	}

	public function getDocumentationUrl()
	{
		return 'https://github.com/lindseydiloreto/craft-phptweak';
	}

	public function getVersion()
	{
		return '1.0.0';
	}

	public function getSchemaVersion()
	{
		return '1.0.0';
	}

	public function getDeveloper()
	{
		return 'Double Secret Agency';
	}

	public function getDeveloperUrl()
	{
		return 'https://github.com/lindseydiloreto/craft-phptweak';
		//return 'http://doublesecretagency.com';
	}

	protected function defineSettings()
	{
		return array(
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
				'instructions' => Craft::t('Only settings which can be overridden at a script level (PHP\_INI\_ALL) will be available here.'),
				'id'           => 'phpSettings',
				'name'         => 'phpSettings',
				'cols'         => array(
					'setting' => array(
						'heading' => Craft::t('PHP Setting'),
						'class'   => 'thin',
						'type'    => 'select',
						'options' => craft()->phpTweak->settingsSelectMenu(),
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
			'phpSettingsTable' => TemplateHelper::getRaw($phpSettingsTable),
		));
	}

}
