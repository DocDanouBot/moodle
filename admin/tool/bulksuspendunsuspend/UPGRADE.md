Upgrading this plugin
=====================

This is an internal documentation for plugin developers with some notes what has to be considered when updating this plugin to a new Moodle major version.

General
-------

* Generally, this is a quite simple plugin with just one purpose.
* It does not rely on any fluctuating library functions and should remain quite stable between Moodle major versions. 
* Thus, the upgrading effort is low.


Upstream changes
----------------

* This plugin does not inherit or copy anything from upstream sources. 


Automated tests
---------------

* The plugin has a currently no coverage with Behat tests.


Manual tests
------------

* After upgrade you should execute the plugin and see if the Ad-Hoc task runs.
* And if the task will afterwards write an event after completion into the table logstore_standard_log.
* With its eventname \tool_deletequizattempts\event\event_quizattemptsdeleted. 
* The event will only be written, if at least one attempt has been deleted.

