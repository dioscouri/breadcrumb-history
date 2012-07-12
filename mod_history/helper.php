<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_breadcrumbs
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modHistoryHelper
{
	public static function getList(&$params)
	{
		// Get the PathWay object from the application
		$app		= JFactory::getApplication();
		$json	= $app->getUserState( "history");
		$items		= json_decode($json);

		$count = count($items);
		$amount = $params->get('amount', 0 );
		for ($i = 0; $i < $count; $i ++)
		{
			$items[$i]->name = stripslashes(htmlspecialchars($items[$i]->name, ENT_COMPAT, 'UTF-8'));
		}

		$done = array();
		$urls = array();
		$new_array = array();
		
		if ($params->get('showHome', 1))
		{
		    // remove any HOME links from the history, then after the array_slice, prepend the home link
			$urls[] = JRoute::_('index.php?Itemid='.$app->getMenu()->getDefault()->id, true, 2); // 2 results in a full http link
			$done[] = strtolower($params->get('homeText', JText::_('MOD_BREADCRUMBS_HOME')));
		}

		foreach ($items as $key=>$item) 
		{
		    if (in_array(strtolower($item->name), $done) || in_array($item->link, $urls)) 
		    {
    		    unset($items[$key]);
		    }
		    else
		    {
		        $done[] = strtolower( $item->name );
		        $urls[] = $item->link;
		        $new_array[] = $item; 
		    }
		}
		
		$items = $new_array;
		$count = count($items);

		if ($amount < $count )
		{
			$items = array_slice($items, -$amount);			
		}
		
		if ($params->get('showHome', 1))
		{
		    $item = new stdClass();
		    $item->name = htmlspecialchars($params->get('homeText', JText::_('MOD_BREADCRUMBS_HOME')));
		    $item->link = JRoute::_('index.php?Itemid='.$app->getMenu()->getDefault()->id);
		    array_unshift($items, $item);
		}
		
		return $items;
	}

	/**
	 * Set the breadcrumbs separator for the breadcrumbs display.
	 *
	 * @param	string	$custom	Custom xhtml complient string to separate the
	 * items of the breadcrumbs
	 * @return	string	Separator string
	 * @since	1.5
	 */
	public static function setSeparator($custom = null)
	{
		$lang = JFactory::getLanguage();

		// If a custom separator has not been provided we try to load a template
		// specific one first, and if that is not present we load the default separator
		if ($custom == null) {
			if ($lang->isRTL()){
				$_separator = JHtml::_('image', 'system/arrow_rtl.png', NULL, NULL, true);
			}
			else{
				$_separator = JHtml::_('image', 'system/arrow.png', NULL, NULL, true);
			}
		} else {
			$_separator = htmlspecialchars($custom);
		}

		return $_separator;
	}
}
