PHP Tweak plugin for Craft CMS
==================================

_Override PHP settings from the control panel._

The main purpose of this plugin is to provide an easy way to override PHP settings from the Craft control panel. These overrides can be applied to the **front-end** and/or **back-end**.

It's a great solution for quickly troubleshooting or problem solving...

 - Figure out what your `php.ini` settings _should_ be before changing them permanently.
 - Bump up certain settings temporarily, simply to allow for a quick action to be run.

In addition to the primary goal of overriding PHP settings, you can also access these values through a normal Twig template:

### get(setting)

Retrieve details of a specific PHP setting.

    {{ craft.phpTweak.get('max_execution_time') }}

### getDetails(setting)

Retrieve details of a specific PHP setting.

    {% set details = craft.phpTweak.getDetails('max_execution_time') %}
    <ul>
        <li>Original Value: {{ details.originalValue }}</li>
        <li>Current Value: {{ details.currentValue }}</li>
        <li>Permissions: {{ details.permissions }}</li>
    </ul>

### getAll()

Retrieve complete set of PHP settings.

    {% for setting,value in craft.phpTweak.getAll() %}
        <p>The current value of {{ setting }} is {{ value }}.</p>
    {% endfor %}

### getAllDetails()

Retrieve complete set of PHP settings, including details.

    {% for setting,details in craft.phpTweak.getAllDetails() %}
        <p>The details of the {{ setting }} setting are:</p>
        <ul>
            <li>Original Value: {{ details.originalValue }}</li>
            <li>Current Value: {{ details.currentValue }}</li>
            <li>Permissions: {{ details.permissions }}</li>
        </ul>
    {% endfor %}
