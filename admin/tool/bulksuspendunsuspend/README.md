moodle-tool_bulksuspendunsuspend
=============================

[![Moodle Plugin CI](https://github.com/lernlink/moodle-tool_deletequizattempts/workflows/Moodle%20Plugin%20CI/badge.svg?branch=master)](https://github.com/lernlink/moodle-tool_deletequizattempts/actions?query=workflow%3A%22Moodle+Plugin+CI%22+branch%3Amaster)

Admin tool to manually delete all quiz attempts from all students in all courses.


Requirements
------------

This plugin requires Moodle 4.1+


Motivation for this plugin
--------------------------

With the according capability tool/deletequizattempts:manage the user will be enabled to visit in the 
administrator backend the page for the tool. The goal of this plugin is to clean the quizzes_attempts table
from all student attempts so that these students can restart each and every quiz within all courses.


Installation
------------

Install the plugin like any other plugin to folder
/admin/tool/deletequizattempts

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

After installing the plugin, it is ready to use without the need for any configuration.


Capabilities
------------

This plugin also introduces these additional capabilities:

### tool/bulksuspendunsuspend:manage

You can allow usergroups to use this plugin individually. The context level is based on courses.
The standard setup for usergroups is
* guest => CAP_PREVENT
* student => CAP_PREVENT
* manager => CAP_ALLOW


How this plugin works 
-----------------------------------

Go to "plugins" > "admin tools" > and than click on the link "Delete all students quiz attempts" to visit the plugin own backend page. There you will be able to initiate the deletion of all quiz attempts.


Theme support
-------------

This plugin acts behind the scenes, therefore it should work with all Moodle themes. This plugin is developed and tested on Moodle Core's Boost theme.
It should also work with Boost child themes, including Moodle Core's Classic theme. However, we can't support any other theme than Boost.


Plugin repositories
-------------------


This plugin is not published in the Moodle plugins repository.

The latest development version can be found on Github:
https://github.com/lernlink/moodle-tool_deletequizattempts


Bug and problem reports
-----------------------

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.

Please report bugs and problems on Github:
https://github.com/lernlink/moodle-tool_deletequizattempts/issues


Community feature proposals
---------------------------

The functionality of this plugin is primarily implemented for the needs of our clients and published as-is to the community. We are aware that members of the community will have other needs and would love to see them solved by this plugin.

Please issue feature proposals on Github:
https://github.com/lernlink/moodle-tool_deletequizattempts/issues

Please create pull requests on Github:
https://github.com/lernlink/moodle-tool_deletequizattempts/pulls


Paid support
------------

We are always interested to read about your issues and feature proposals or even get a pull request from you on Github. However, please note that our time for working on community Github issues is limited.

As certified Moodle Partner, we also offer paid support for this plugin. If you are interested, please have a look at our services on https://lern.link or get in touch with us directly via team@lernlink.de.


Moodle release support
----------------------

This plugin is only maintained for the most recent major release of Moodle as well as the most recent LTS release of Moodle. Bugfixes are backported to the LTS release. However, new features and improvements are not necessarily backported to the LTS release.

Apart from these maintained releases, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major release - please let us know on Github.

If you are running a legacy version of Moodle, but want or need to run the latest version of this plugin, you can get the latest version of the plugin, remove the line starting with $plugin->requires from version.php and use this latest plugin version then on your legacy Moodle. However, please note that you will run this setup completely at your own risk. We can't support this approach in any way and there is an undeniable risk for erratic behavior.


Translating this plugin
-----------------------

This plugin does not contain any strings which are visible to a Moodle student / teacher and it can't be translated on AMOS as it is not published in the Moodle plugins repository. In our point of view, translating this plugin is not necessary.


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


Maintainers
-----------

lern.link GmbH\
Danou Nauck


Copyright
---------

lern.link GmbH\
Danou Nauck


