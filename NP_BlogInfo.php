<?php

/*
	2004-07-22 NP_BlogSetting Ver.0.1.0 (Taka) released the first source: http://japan.nucleuscms.org/bb/viewtopic.php?p=2765
	2005-10-23 NP_BlogInfo Ver.0.1.0 (ava) released the first source: http://japan.nucleuscms.org/bb/viewtopic.php?p=9382
	2006-03-01 NP_BlogSetting Ver.0.1.1 (cha_cya) added the function: http://japan.nucleuscms.org/bb/viewtopic.php?p=11252
	2008-08-19 NP_BlogInfo Ver.0.1.1 (ephemera) united NP_Info with NP_BlogSetting: http://japan.nucleuscms.org/bb/viewtopic.php?p=23237
	2008-11-11 NP_BlogInfo Ver.0.1.2 (ephemera) added the function:
*/

class NP_BlogInfo extends NucleusPlugin {
	function getName() {
		return 'BlogInfo';
	}

	function getEventList() {
		return array();
	}

	function getAuthor() {
		return 'Taka + cha_cya + ava + ephemera';
	}

	function getURL() {
		return 'http://japan.nucleuscms.org/bb/viewtopic.php?p=23237';
	}

	function getVersion() {
		return '0.1.2';
	}

	function init() { 
		// include language file for this plugin
		$language = str_replace( array('/','\\'), '', getLanguageName());
		if (file_exists($this->getDirectory().$language.'.php')) {
			include_once($this->getDirectory().$language.'.php');
		} else {
			include_once($this->getDirectory().'english.php');
		}
	}

	function getDescription() {
		return _BLOGINFO_Description;
	}

	function install() {
	
	}

	function supportsFeature($what) {
		switch($what){
			case 'SqlTablePrefix':
				return 1;
			default:
				return 0;
		}
	}

	function doTemplateVar(&$item, $mode, $m_blogid='') {
		$this->ModeSelect($item, $mode, $m_blogid, 0);
	}

	function doSkinVar($skinType, $mode, $m_blogid='') {
		$this->ModeSelect($skinType, $mode, $m_blogid, 1);
	}

	function ModeSelect($item, $mode, $m_blogid, $st){
	
		global $CONF, $blogid, $manager, $member;

		if($st){
			$bid = $blogid;
		}else{
			$itemid = $item->itemid;
			$bid = getBlogIDFromItemID($itemid);
		}

		if($m_blogid){
			$bid = intval($m_blogid);
		}

// blog infomation ----------
		$b =& $manager->getBlog($bid);
		switch ($mode) {
			case 'id':
				echo $bid;
				break;
			case 'name':
				echo $b->getName();
				break;
			case 'desc':
				echo $b->getDescription();
				break;
			case 'short':
				echo $b->getShortName();
				break;
			case 'url':
				echo $b->getURL();
				break;
/*
			case 'url':
				if ($CONF['URLMode'] == 'pathinfo'){
					$link = $CONF['BlogURL'] . '/blog/' . $blogid;
				}else{
					$blogurl = $b->getURL();
					if(!$blogurl){
						$blogurl = $CONF['BlogURL'];
					}
					if(substr($blogurl, -4) != '.php'){
						if(substr($blogurl, -1) != '/')	$blogurl .= '/';
						$blogurl .= 'index.php';
					}
					$link = $blogurl . '?blogid=' .$b->getID();
				}
				echo $link;
				break;
*/
			default:
				break;
		}

// member infomation ----------
		$m = new MEMBER;
		$m->readFromID($bid);
		if ($m){
			switch ($mode) {
				case 'mname':
					echo $m->getDisplayName();
					break;
				case 'mrealname':
					echo $m->getRealName();
					break;
				case 'mnotes':
					echo $m->getNotes();
					break;
				case 'murl':
					echo $m->getURL();
					break;
				case 'memail':
					echo $m->getEmail();
					break;
				case 'mid':
					echo $m;
//					echo $m->getID();
					break;
			}
		}

	}
}
?>
