NSM Body class - Class generator for the `<body>` tag
=====================================================

NSM Body class is an [EE 2.0][ee] plugin that generates a class attribute based on embed template parameters allowing greater CSS styling of templates.

A quick example:

The embed tag (a shared header template) inside the primary template would looks like:

	{embed="_includes/.header"
		entry_id="10"
		template="index"
		template_group="pages"
	}

Inside the `_includes/.header` template

	<!-- Tag -->
	<body {exp:nsm_body_class}>
	
	<!-- Output -->
	<body class="eid-10 eut-my_url_title y-2010 m-02 d-5 t-index tg-pages">

By default `{exp:nsm_body_class}` searches for the following embed parameters and adds them to a class attribute string (prefixed with an identifier):

* `entry_id`
* `url_title`
* `year`
* `month`
* `day`
* `template`
* `template_group`
* `body_class`

The parameter map can be extended or replaced using the `param_map=''` tag parameter.

The plugin returns a full class attribute by default ie: `class='eid-3'` however the attribute value can be returned by modifying the `return=''` parameter.

See the "Tag reference" below for more details.

Overview
--------

### Requirements

Technical requirements include:

* [ExpressionEngine 2.0][ee]
* PHP5
* A modern browser: [Firefox][firefox], [Safari][safari], [Google Chrome][chrome] or IE8+

### Installation

1. Download the latest version of NSM body class.
2. Extract the .zip file to your desktop
3. Copy `pi.nsm_body_class.php` to `system/expressionengine/third_party/nsm_body_class` (you may need to create the folder).

if your existing site is a Git repo you can install the addon as a submodule:

	cd path_to_your_site_git_repo_root
	git submodule add git://github.com/newism/nsm.body_class.ee_addon.git \
	system/expressionengine/third_party/nsm_body_class
	

Tag reference
------------

### `{exp:nsm_body_class}`

    {exp:nsm_body_class:link [param_map, replace_param_map,
                              entry_id, url_title, year, month, day,
                              template, template_group,
                              return
                            ]}

Generate a class attribute (or value) based on embedded variables.

#### Tag Parameters

##### `param_map='variable_name:prefix'` [optional]

NSM body class has an internal variable map that maps an variable name to a unique prefix.

The default map is:

* `entry_id` => eid
* `url_title` => eut
* `year` => y
* `month` => m
* `day` => d
* `template_group` => tg
* `template` => t
* `body_class` => ""

The class prefix is used when creating the class value. Example: If an `entry_id` and `url_title` are found as an embedded variable (or a tag parameter) the concatenated class would be:

	class='eid-1 eut-my_entry_url_title'

The variable map can be extended to add as many extra mapping references as needed using the following syntax:

	variable_name:prefix

Multiple mapping references are joined with a pipe like so:

	param_1:prefix_1|param_2:prefix_2

The `param_map` parameter allows you to extend the functionality of the tag in endless ways.

##### `replace_param_map='no'` [optional, default: 'class']

Replace the existing parameter map. Default behaviour is to extend the default parameter map with the new param references.

##### `entry_id, url_title, year, month, day, template, template_group, body_class` [optional]

The embedded parameters can be overridden with an explicit tag parameter. Any variable name in the variable map can be overridden this way.

Example: Override the embedded `month` parameter:

	<body {exp:nsm_body_class month="12"}>

##### `return='class_attr'` [optional, default: 'class_str']

Return the class value without the wrapping `class=''` string.

Userguide
---------

1. Create a new `.header` template that contains a `<body>` tag.
1. Add `{exp:nsm_body_class}` inside your `<body>` tag like so: `<body {exp:nsm_body_class}>`
3. Embed your `.header` template inside a primary template using: ``{embed="_includes/.header" entry_id='10'}``
4. Request the primary template in your browser and the documents `<body>` tag will look like: `<body class="e-10">`

Release Notes
-------------

### Upgrading?

* Before upgrading back up your database and site first, you can never be too careful.
* Never upgrade a live site, you're asking for trouble regardless of the addon.
* After an upgrade if you are experiencing errors re-save the extension settings for each site in your ExpressionEngine install.

There are no specific upgrade notes for this version.

### Change log

#### 1.0.0

* Initial release

Support
-------

Technical support is available primarily through the [ExpressionEngine forums][ee_forums]. [Leevi Graham][lg] and [Newism][nsm] do not provide direct phone support. No representations or guarantees are made regarding the response time in which support questions are answered.

Although we are actively developing this addon, [Leevi Graham][lg] and [Newism][nsm] makes no guarantees that it will be upgraded within any specific timeframe.

License
------

Ownership of this software always remains property of the author.

You may:

* Modify the software for your own projects
* Use the software on personal and commercial projects

You may not:

* Resell or redistribute the software in any form or manner without permission of the author
* Remove the license / copyright / author credits

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

[lg]: http://leevigraham.com

[nsm]: http://newism.com.au
[nsm_publish_plus]: http://leevigraham.com/cms-customisation/expressionengine/nsm-publish-plus/

[ee]: http://expressionengine.com/index.php?affiliate=newism
[ee_forums]: http://expressionengine.com/index.php?affiliate=newism&page=forums
[ee_cp]: http://expressionengine.com/index.php?affiliate=newism&page=docs/cp/index.html
[ee_cp_edit]: http://expressionengine.com/index.php?affiliate=newism&page=docs/cp/edit/index.html
[ee_cp_extensions_manager]: http://expressionengine.com/index.php?affiliate=newism&page=docs/cp/admin/utilities/extension_manager.html
[ee_msm]: http://expressionengine.com/index.php?affiliate=newism&page=downloads/details/multiple_site_manager/

[firefox]: http://firefox.com
[safari]: http://www.apple.com/safari/download/
[chrome]: http://www.google.com/chrome/

[lg_addon_updater]: http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/
[gh_morphine_theme]: http://github.com/newism/nsm.morphine.theme