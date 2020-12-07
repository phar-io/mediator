<?php

namespace PharIo\MediatorTest\Service;

use DOMDocument;
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
		$config = new Configuration(
			'namespace/name',
			'pharName',
			'https://example.com/file.phar',
			'https://example.com/file.phar.asc'
		);

		$creator = new CreateConfigurationFile(new SplFileInfo(sys_get_temp_dir()));
		$creator($config);

		self::assertFileExists(sys_get_temp_dir() . '/mediator.xml');

		$doc = new DOMDocument();
		$doc->load(sys_get_temp_dir() . '/mediator.xml');
		self::assertTrue($doc->schemaValidate(__DIR__ . '/distributor.xsd'));
	}
}
