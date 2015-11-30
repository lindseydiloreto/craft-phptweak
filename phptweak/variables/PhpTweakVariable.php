<?php
namespace Craft;

class PhpTweakVariable
{

	// Get specified PHP setting
	public function get($setting)
	{
		return craft()->phpTweak->get($setting);
	}

	// Get specified PHP setting, including details
	public function getDetails($setting)
	{
		return craft()->phpTweak->getDetails($setting);
	}

	// Get all PHP settings
	public function getAll()
	{
		return craft()->phpTweak->getAll();
	}

	// Get all PHP settings, including details
	public function getAllDetails()
	{
		return craft()->phpTweak->getAllDetails();
	}

}
