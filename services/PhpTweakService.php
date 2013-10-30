<?php
namespace Craft;

class PhpTweakService extends BaseApplicationComponent
{

	function __construct()
	{
		$plugin = craft()->plugins->getPlugin('phptweak');
		if (!$plugin) {
			throw new Exception('Couldn’t find the PhpTweak plugin!');
		}
	}

	// Initialize plugin
	public function initialize($settings)
	{
		$currentUrl = craft()->request->getUrl();
		$admin = craft()->config->get('cpTrigger');

		// Set bypass URLs
		$bypassUrls = array(
			"/$admin",
			"/$admin/login",
			"/$admin/logout",
			"/$admin/dashboard",
			"/$admin/settings",
			"/$admin/settings/plugins",
			"/$admin/settings/plugins/phptweak",
		);

		// Determine whether to bypass
		if (craft()->request->isActionRequest()) {
			$bypass = true;
		} else {
			$bypass = in_array($currentUrl, $bypassUrls);
		}

		// Determine if front-end/back-end is enabled
		if (craft()->request->isCpRequest()) {
			$endEnabled = $settings->enableBackEnd;
		} else {
			$endEnabled = $settings->enableFrontEnd;
		}

		// Always show override values on "Current PHP Settings" page
		if ("/$admin/phptweak/current-settings" == $currentUrl) {
			$bypass = false;
			$endEnabled = true;
		}

		// Bypass if instructed
		if ($bypass) {return;}

		// If enabled, override PHP setting
    	if (!empty($settings->phpSettings)) {
	        foreach ($settings->phpSettings as $s) {
		    	if ($s['enabled'] && $endEnabled) {
					ini_set($s['setting'], $s['value']);
		    	}
	        }
    	}
	}

	// Get specified setting
	public function get($setting)
	{
		if ($this->_validSetting($setting)) {
			return ini_get($setting);
		}
	}

	// Get specified setting with details
	public function getDetails($setting)
	{
		if ($this->_validSetting($setting)) {
			$details = $this->getAllDetails();
			return $details[$setting];
		}
	}

	// Get all settings
	public function getAll()
	{
		return ini_get_all('core', false);
	}

	// Get all settings with details
	public function getAllDetails()
	{
		$all = array();
		foreach (ini_get_all('core') as $setting => $details) {
			$all[$setting] = array(
				'originalValue' => $details['global_value'],
				'currentValue'  => $details['local_value'],
				'permissions'   => $details['access'],
			);
		}
		return $all;
	}

	// Get list of settings for dropdown menu
	public function settingsSelectMenu() {
		// Start with blank option
		$options = array('' => '');
		foreach ($this->getAllDetails() as $setting => $details) {
			// If setting is changeable at the script level
			if (7 == $details['permissions']) {
				$options[$setting] = $setting;
			}
		}
		return $options;
	}

	// Checks to ensure setting is valid
	private function _validSetting($setting)
	{
		return true;
	}

}