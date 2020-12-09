<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use DOMDocument;
use Exception;
use PharIo\ComposerDistributor\Config\Config;
use PharIo\ComposerDistributor\File;
use PharIo\Mediator\Configuration;
use SplFileInfo;
use function file_put_contents;

final class CreateConfigurationFile
{
	private $targetDirectory;

	public function __construct(SplFileInfo  $targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function __invoke(Config $configuration): void
	{
		$document = new DOMDocument('1.0', 'UTF-8');
		$document->formatOutput = true;
		$distributor = $document->createElementNS(
			'https://phar.io/composer-distributor',
			'distributor',
		);
		$distributor->setAttributeNS(
			'http://www.w3.org/2001/XMLSchema-instance',
			'xsi:schemaLocation',
			'https://phar.io/xml/distributor/1.0/schema.xsd'
		);
		$distributor->setAttribute('packageName', $configuration->package());
		if ($configuration->keyDirectory() !== null) {
			$distributor->setAttribute('keyDirectory', $configuration->keyDirectory());
		}
		$document->appendChild($distributor);

		/** @var File $pharConfig */
		foreach ($configuration->phars()->getList() as $pharConfig) {
			$phar = $document->createElement('phar');
			$distributor->appendChild($phar);

			$phar->setAttribute('name', $pharConfig->pharName());
			$phar->setAttribute('file', $pharConfig->pharUrl()->toString());
			if ($pharConfig->signatureUrl() !== null) {
				$phar->setAttribute('signature', $pharConfig->signatureUrl()->toString());
			}
		}

		file_put_contents(
			$this->targetDirectory . '/mediator.xml',
		    $document->saveXML()
		);
	}
}
