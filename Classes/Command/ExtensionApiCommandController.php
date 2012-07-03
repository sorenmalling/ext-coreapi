<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Georg Ringer <georg.ringer@cyberhouse.at>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Extension API Command Controller
 *
 * @package TYPO3
 * @subpackage tx_coreapi
 */
class Tx_Coreapi_Command_ExtensionApiCommandController extends Tx_Extbase_MVC_Controller_CommandController {

	/**
	 * List all installed extensions
	 *
	 * @param string $type Extension type, can either be L for local, S for system or G for global. Leave it empty for all
	 * @return void
	 */
	public function listInstalledCommand($type = '') {
		$type = strtoupper($type);
		if (!empty($type) && $type !== 'L' && $type !== 'G' && $type !== 'S') {
			$this->outputLine('Only "L", "S" and "G" are supported as type (or nothing)');
			$this->quit();
		}

		$extensions = $GLOBALS['TYPO3_LOADED_EXT'];

		$list = array();
		foreach ($extensions as $key => $extension) {
			if (!empty($type) && $type !== $extension['type']) {
				continue;
			}
			$list[$key] = $extension['ext_tables.sql'];
		}

		ksort($list);

		foreach ($list as $key => $description) {
			include_once(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
			$title = $key . ' - ' . $EM_CONF['']['version'] . '/' . $EM_CONF['']['state'];
			$description = $EM_CONF['']['title'];
			$description = wordwrap($description, self::MAXIMUM_LINE_LENGTH - 43, PHP_EOL . str_repeat(' ', 43), TRUE);
			$this->outputLine('%-2s%-40s %s', array(' ', $title, $description));
		}
	}

	/**
	 * Update list
	 *
	 * @return void
	 */
	public function updateListCommand() {
	}

}

?>