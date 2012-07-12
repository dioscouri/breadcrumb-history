<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';
// Get the breadcrumbs
$list	= modHistoryHelper::getList($params);
$count	= count($list);
// Set the default separator
$separator = modHistoryHelper::setSeparator($params->get('separator'));	


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));



require JModuleHelper::getLayoutPath('mod_history', $params->get('layout', 'default'));
