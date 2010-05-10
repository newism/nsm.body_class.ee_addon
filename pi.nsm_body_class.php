<?php

/**
 * NSM body class
 * 
 * Returns a class attribute or string based on embedded variables
 *
 * @author Leevi Graham
 * @license See README.md
 */

/**
 * Plugin infotmation
 *
 * @var array
 **/
$plugin_info = array(
	'pi_name' => 'NSM body class',
	'pi_version' => '0.9.0',
	'pi_author' => 'Leevi Graham',
	'pi_author_url' => 'http://leevigraham.com/',
	'pi_description' => 'Returns a class attribute or string based on embedded variables',
	'pi_usage' => "Refer to the README"
);

class Nsm_body_class {
	
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
		"entry_id" 			=> "eid-",
		"url_title" 		=> "eut-",
		"year"				=> "y-",
		"month"				=> "m-",
		"day"				=> "d-",
		"template" 			=> "t-",
		"template_group" 	=> "tg-",
		"body_class"		=> ""
	);

	/**
	 * Constructor
	 * 
	 * Loops over embedded template variables and creates a class string
	 * Sets return data that is then outputted to template
	 **/
	public function nsm_body_class()
	{
		$this->EE =& get_instance();
		$this->_extendParamMap();

		if(! $return = $this->EE->TMPL->fetch_param("return"))
			$retun = "class";

		foreach ($this->param_map as $var => $prefix)
		{
			if(array_key_exists("embed:" . $var, $this->EE->TMPL->embed_vars))
			{
				if(! $val = $this->EE->TMPL->fetch_param($var))
					$val = $this->EE->TMPL->embed_vars["embed:" . $var];

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
		if(! $param_map = $this->EE->TMPL->fetch_param("param_map"))
			return;
		
		$param_map = explode("|", $param_map);

		if(!$this->EE->TMPL->fetch_param("replace_param_map"))
			$this->param_map = array();

		foreach ($param_map as $prop)
		{
			$parts = explode(":", $prop);
			$this->param_map[$parts[0]] = $parts[1];
		}
	}
}