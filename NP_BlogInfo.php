<?php

/*
	2004-07-22 NP_BlogSetting Ver.0.1.0 (Taka) released the first source: http://japan.nucleuscms.org/bb/viewtopic.php?p=2765
	2005-10-23 NP_BlogInfo Ver.0.1.0 (ava) released the first source: http://japan.nucleuscms.org/bb/viewtopic.php?p=9382
	2006-03-01 NP_BlogSetting Ver.0.1.1 (cha_cya) added the function: http://japan.nucleuscms.org/bb/viewtopic.php?p=11252
	2008-08-19 NP_BlogInfo Ver.0.1.1 (ephemera) united NP_Info with NP_BlogSetting: http://japan.nucleuscms.org/bb/viewtopic.php?p=23237
	2008-11-11 NP_BlogInfo Ver.0.1.2 (ephemera) added the function:
*/

class NP_BlogInfo extends NucleusPlugin {
	function getName()      {return 'BlogInfo';}
	function getEventList() {return array();}
	function getAuthor()    {return 'Taka + cha_cya + ava + ephemera + yamamoto';}
	function getURL()       {return 'http://japan.nucleuscms.org/bb/viewtopic.php?t=4185';}
	function getVersion()   {return '0.2';}
	function supportsFeature($what) {return in_array($what,array('SqlTablePrefix'));}

	function getDescription() {
		// include language file for this plugin
		$language = str_replace( array('/','\\'), '', getLanguageName());
		$plg_path = $this->getDirectory();
		if (is_file($plg_path.$language.'.php')) include_once($plg_path.$language.'.php');
		else                                     include_once($plg_path.'english.php');
		return _BLOGINFO_Description;
	}

	function doSkinVar($skinType, $key, $other_blogid='', $option='')  {
		global $blogid;
		
		if($other_blogid) $value = $this->getValue($key,$other_blogid);
		else              $value = $this->getValue($key,$blogid);
		
		if($option) $value = $this->applyFilter($value,$option);
		
		echo $value;
	}
	function doTemplateVar(&$item, $key, $other_blogid='', $option='') {
		if($other_blogid) $value = $this->getValue($key,$other_blogid);
		else              $value = $this->getValue($key,getBlogIDFromItemID($item->itemid));
		
		if($option) $value = $this->applyFilter($value,$option);
		
		echo $value;
	}

	function getValue($key,$blogid,$option='') {
		global $manager;
		
		$blog = $manager->getBlog($blogid);
		
		switch (strtolower($key)) {
			case 'blogid':
			case 'id'    : return $blog->getID();
			case 'name'  : return $blog->getName();
			case 'description':
			case 'desc'  : return $blog->getDescription();
			case 'short' : return $blog->getShortName();
			case 'url'   : return $blog->getURL();
		}
	}
	
	
	function applyFilter($value,$option='') {
		switch($option) {
			case 'htmlspecialchars_decode':
			case 'hsc_decode':
				return htmlspecialchars_decode($value);
			default:
				return $value;
		}
		
	}
}
