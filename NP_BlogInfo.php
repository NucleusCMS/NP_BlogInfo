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
	function getAuthor()    {return 'Taka + cha_cya + ava + ephemera';}
	function getURL()       {return 'http://japan.nucleuscms.org/bb/viewtopic.php?p=23237';}
	function getVersion()   {return '0.2';}

	function getDescription() {
		// include language file for this plugin
		$language = str_replace( array('/','\\'), '', getLanguageName());
		$plg_path = $this->getDirectory();
		if (is_file($plg_path.$language.'.php')) include_once($plg_path.$language.'.php');
		else                                     include_once($plg_path.'english.php');
		return _BLOGINFO_Description;
	}

	function doSkinVar($skinType, $mode, $m_blogid='')  {$this->ModeSelect($skinType, $mode, $m_blogid, 1);}
	function doTemplateVar(&$item, $mode, $m_blogid='') {$this->ModeSelect($item, $mode, $m_blogid, 0);}

	function ModeSelect($item, $mode, $m_blogid, $st) {
	
		global $CONF, $blogid, $manager, $member;

		if($st) $bid = $blogid;
		else {
			$itemid = $item->itemid;
			$bid = getBlogIDFromItemID($itemid);
		}
		
		if($m_blogid) $bid = intval($m_blogid);

		// blog infomation ----------
		$b =& $manager->getBlog($bid);
		switch ($mode) {
			case 'id'   : echo $bid;break;
			case 'name' : echo $b->getName();       break;
			case 'desc' : echo $b->getDescription();break;
			case 'short': echo $b->getShortName();  break;
			case 'url'  : echo $b->getURL();        break;
			default     : break;
		}

		// member infomation ----------
		$m = new MEMBER;
		$m->readFromID($bid);
		if ($m){
			switch ($mode) {
				case 'mname'    : echo $m->getDisplayName();break;
				case 'mrealname': echo $m->getRealName();   break;
				case 'mnotes'   : echo $m->getNotes();      break;
				case 'murl'     : echo $m->getURL();        break;
				case 'memail'   : echo $m->getEmail();      break;
				case 'mid'      : echo $m;                  break;
			}
		}
	}
}
