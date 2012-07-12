<?php
/**
 * @version	1.5
 * @package	History Plugin
 * @subpackage	System.remember
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die;

class plgSystemHistory extends JPlugin
{
	
	//using onBeforeRender because it is first event to enable getDocument
	function onBeforeRender()
	{
		$app = JFactory::getApplication();
		
		//no tracking for admin
		if ($app->isAdmin()) {
			return;
		}
		//check if already set if not make one
		$historyObject = $app->getUserState( "history");
		$historyObject = $this->makehistory($historyObject);
		$app->setUserState('history', $historyObject);
		
	}
	
	
	
	function makehistory($hisObj) {
		$doc = JFactory::getDocument(); 
		//create current history for page
		$array = array();
		$array['link'] = JFactory::getURI()->toString();
		$array['name'] = $doc->getTitle();
		
		if(empty($hisObj)) {
			//if the history object is new create an empty array to hold arrays, encode so  next decode is always decoding
			$hisObj = array();
			$hisObj = json_encode($hisObj);
		}
		//decode object, and new object and return
		$newhistory =  json_decode($hisObj);
	
		$count = count($newhistory);
		if(!$this->params->get('duplicates')) {
		//check for and destroy duplicates, since our array is full of objects use a for statement for the loop and slice out our arrays we don't want.
		for ($i = 0; $i < $count; $i ++)
		{
			if($array['name'] == $newhistory[$i]->name) {
					unset($newhistory[$i]);
			}
	
		}
		$newhistory = array_values($newhistory);
		}
		// we need to rebuild our array because it could be missing keys now
		
		//lets keep the number of items in the session small
		
		if(count($newhistory) >= $this->params->get('amount')){
			//add array to the end
			array_push($newhistory,$array);
			//remove the first/oldest one
			array_shift($newhistory);
		} else {
			array_push($newhistory,$array);
		}
		$newhistory = json_encode($newhistory);		
		
		return $newhistory;		
	}
}
