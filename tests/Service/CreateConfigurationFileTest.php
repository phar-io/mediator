<?php

namespace PharIo\MediatorTest\Service;

use DOMDocument;
use PharIo\ComposerDistributor\Config\Config;
use PharIo\ComposerDistributor\File;
use PharIo\ComposerDistributor\FileList;
use PharIo\ComposerDistributor\Url;
use PharIo\Mediator\Configuration;
use PharIo\Mediator\Service\CreateConfigurationFile;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use function sys_get_temp_dir;
use function tmpfile;

class CreateConfigurationFileTest extends TestCase
{
	/**
	 * @covers \PharIo\Mediator\Service\CreateConfigurationFile::__invoke
	 */
	public function testThatXmlCreationWorks(): void
	{
		$config = new Config(
			'namespace/name',
			new FileList(new File(
				'pharName',
				Url::fromString('https://example.com/file.phar'),
				Url::fromString('https://example.com/file.phar.asc')
			)),
			'keys'
		);

		$creator = new CreateConfigurationFile(new SplFileInfo(sys_get_temp_dir()));
		$creator($config);

		self::assertFileExists(sys_get_temp_dir() . '/mediator.xml');

		$doc = new DOMDocument();
		$doc->load(sys_get_temp_dir() . '/mediator.xml');
		self::assertTrue($doc->schemaValidate(__DIR__ . '/../../vendor/phar-io/composer-distributor/distributor.xsd'));
	}
}
