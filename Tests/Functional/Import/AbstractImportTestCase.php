<?php
namespace TYPO3\CMS\Impexp\Tests\Functional\Import;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Marc Bastian Heinrichs <typo3@mbh-software.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;

require_once __DIR__ . '/../../../../core/Tests/Functional/DataHandling/AbstractDataHandlerActionTestCase.php';

/**
 * Functional test for the ImportExport
 */
abstract class AbstractImportTestCase extends \TYPO3\CMS\Core\Tests\Functional\DataHandling\AbstractDataHandlerActionTestCase {

	/**
	 * @var array
	 */
	protected $coreExtensionsToLoad = array('impexp');

	/**
	 * @var \TYPO3\CMS\Impexp\ImportExport
	 */
	protected $import;

	/**
	 * Absolute path to files that must be removed
	 * after a test - handled in tearDown
	 *
	 * @var array
	 */
	protected $testFilesToDelete = array();

	/**
	 * Set up for initialization of the ImportExport instance
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->import = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Impexp\\ImportExport');
		$this->import->init(0, 'import');
	}

	/**
	 * Tear down for remove of the test files
	 */
	public function tearDown() {
		foreach ($this->testFilesToDelete as $absoluteFileName) {
			if (@is_file($absoluteFileName)) {
				unlink($absoluteFileName);
			}
		}
		parent::tearDown();
	}

	/**
	 * Test if the local filesystem is case sensitive
	 *
	 * @return boolean
	 */
	protected function isCaseSensitiveFilesystem() {
		$caseSensitive = TRUE;
		$path = GeneralUtility::tempnam('aAbB');

		// do the actual sensitivity check
		if (@file_exists(strtoupper($path)) && @file_exists(strtolower($path))) {
			$caseSensitive = FALSE;
		}

		// clean filesystem
		unlink($path);
		return $caseSensitive;
	}

}