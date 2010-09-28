<?php /* if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			/* @danott fork. Commented this out for EE1 compatibility */

/**
 * NSM Body Class Plugin
 * 
 * Generally a module is better to use than a plugin if if it has not CP backend
 *
 * @package			NsmBodyClass
 * @version			1.0.1
 * @author			Leevi Graham <http://leevigraham.com> - Technical Director, Newism
 * @copyright 		Copyright (c) 2007-2010 Newism <http://newism.com.au>
 * @license 		Commercial - please see LICENSE file included with this distribution
 * @link			http://expressionengine-addons.com/nsm-body-class
 * @see 			http://expressionengine.com/public_beta/docs/development/plugins.html
 */

/*
 * @danott Fork
 *
 * Forked by @danott to bring compatability to an EE1 project.
 * The basic strategy is simple. Abstract the TMPL class using @erikreagan's technique from
 * Dan Benjamin's Shrimp plugin. Then replace all calls to $this->EE->TMPL->function() with
 * $this->TMPL->function().
 */
 
/**
 * Plugin Info
 *
 * @var array
 */
$plugin_info = array(
	'pi_name' => 'NSM Body Class',
	'pi_version' => '1.0.1',
	'pi_author' => 'Leevi Graham &mdash; Technical Director, <a href="http://newism.com.au/">Newism</a>',
	'pi_author_url' => 'http://leevigraham.com/',
	'pi_description' => 'Returns a class attribute or string based on embedded variables',
	'pi_usage' => 'http://expressionengine-addons.com/nsm-body-class'
);

class Nsm_body_class {
	
	/**
	 * The ExpressionEngine TMPL object, independent of version
	 * Implemented in @danott fork
	 *
	 * @var object
	 **/
	protected $TMPL;
	
	/**
	 * The return data
	 *
	 * @var string
	 **/
	public $return_data = '';

	/**
	 * The class string
	 *
	 * @var mixed
	 **/
	protected $class_string = FALSE;

	/**
	 * The parameter map
	 * 
	 * Keys are the embed param
	 * Values are the class value prefix
	 *
	 * @var array
	 **/
	protected $param_map = array(
		"entry_id"        => "eid-",
		"url_title" 		  => "eut-",
		"year"            => "y-",
		"month"           => "m-",
		"day"             => "d-",
		"template"        => "t-",
		"template_group"  => "tg-",
		"channel_name"		=> "cn-",
		"channel_id"	  	=> "cid-",
		"weblog_name"		  => "wn-",   // @danott fork. Include both EE1 and EE2 nomenclatures since only what is passed shows up anyway.
		"weblog_id"	    	=> "wid-",  // @danott fork. Include both EE1 and EE2 nomenclatures since only what is passed shows up anyway.
		"body_class"	  	=> ""
	);

	/**
	 * Constructor
	 * 
	 * Loops over embedded template variables and creates a class string
	 * Sets return data that is then outputted to template
	 **/
	public function nsm_body_class()
	{
	  
		/* 
		 * @danott fork
		 * Technique from @erikreagan in Dan Benjamin's Shrimp plugin
		 * EE version check to properly reference our EE objects
		 */
		if (version_compare(APP_VER, '2', '<'))
		{
			// EE 1.x is in play
			global $TMPL;
			$this->TMPL =& $TMPL;
		} else {
			// EE 2.x is in play
			$this->EE	=& get_instance();
			$this->TMPL =& $this->EE->TMPL;
		}


		if(! $return = $this->TMPL->fetch_param("return"))
			$retun = "class";

		foreach ($this->param_map as $var => $prefix)
		{
			if(array_key_exists("embed:" . $var, $this->TMPL->embed_vars))
			{
				if(! $val = $this->TMPL->fetch_param($var))
					$val = $this->TMPL->embed_vars["embed:" . $var];

				$this->class_string .= "{$prefix}{$val} ";
			}
		}

		$this->return_data .= ($return == "class_attr") ? $this->class_string : " class='{$this->class_string}' ";

	}

	/**
	 * Extends the variable map using the param_map tag parameter. Optionally replace the existing map.
	 **/
	private function _extendParamMap()
	{
		if(! $param_map = $this->TMPL->fetch_param("param_map"))
			return;
		
		$param_map = explode("|", $param_map);

		if(!$this->TMPL->fetch_param("replace_param_map"))
			$this->param_map = array();

		foreach ($param_map as $prop)
		{
			$parts = explode(":", $prop);
			$this->param_map[$parts[0]] = $parts[1];
		}
	}
}