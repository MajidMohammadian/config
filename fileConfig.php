<?php
/**
 * @package     Cheshme
 * @subpackage  CFileConfig
 *
 * @since		1.0
 *
 * @Creator     Majeed Mohammadian
 * @copyright   Copyright (C) 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

class CFileConfig
{
	/**
	 * @var    string	Directory file
	 * @since  1.0
	 */
	protected $path;
	
	/**
	 * @var    string	Name file
	 * @since  1.0
	 */
	protected $name;
	
	/**
	 * @var    string	Object name in file
	 * @since  1.0
	 */
	protected $nameObject;
	
	/**
	 * @var    object	Object in file
	 * @since  1.0
	 */
	protected $object;
	
	/**
	 * Constructor
	 *
	 * @param	string	$path		Directory file
	 * @param	string	$name		Name file
	 * @param	string	$Object		Name object in file
	 *
	 * @since   1.0
	 */
	public function __construct($path, $name, $Object = null)
	{
		$this->path = $path;
		$this->name = $name;
		if($Object != null)
			$this->nameObject = $Object;
		else
			$this->nameObject = 'JAConfig';
	}
	
	/**
	 * Load Object
	 *
	 * @desc	Set the variable object in class
	 *
	 * @since   1.0
	 */
	private function loadObject()
	{
		if(!class_exists($this->nameObject))
			require_once($this->path . DS . $this->name);
		$this->object = new $this->nameObject;
	}
	
	/**
	 * Write Config
	 *
	 * @param	array	$param		Data array to change config file
	 *
	 * @since   1.0
	 */
	public function writeConfig($param = array())
	{
		CFileConfig::loadObject();
		$file = file_get_contents($this->path . DS . $this->name);
		foreach($this->object as $keyObject => $valueObject)
		{
			$find_str = 'public $'.$keyObject.' = "'.$valueObject.'";';
			foreach($param as $keyParam => $valueParam)
			{
				if($keyObject == $keyParam)
				{
					$replace_str = 'public $'.$keyParam.' = "'.$valueParam.'";';
					$file = str_replace($find_str, $replace_str, $file);
					file_put_contents($this->path . DS . $this->name, $file);
				}
			}
		}
	}
	
	/**
	 * Get Config
	 *
	 * @param	string	$param		Metode in file config
	 *
	 * @return	string	Value metode in file config
	 *
	 * @since   1.0
	 */
	public function getConfig($param)
	{
		CFileConfig::loadObject();
		return $this->object->$param;
	}
}
?>
