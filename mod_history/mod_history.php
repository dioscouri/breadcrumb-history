<?php
/**
 * @version	1.5
 * @package	History Module
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die ;

require_once dirname(__FILE__) . '/helper.php';
// Get the breadcrumbs
$list = modHistoryHelper::getList($params);
$count = count($list);
// Set the default separator
$separator = modHistoryHelper::setSeparator($params -> get('separator'));

$moduleclass_sfx = htmlspecialchars($params -> get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_history', $params -> get('layout', 'default'));
