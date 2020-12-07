<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use DOMDocument;
use Exception;
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

	public function __invoke(Configuration $configuration): void
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
		$distributor->setAttribute('packageName', $configuration->pluginName());
		$distributor->setAttribute('keyDirectory', 'keys');
		$document->appendChild($distributor);

		$phar = $document->createElement('phar');
		$distributor->appendChild($phar);

		$phar->setAttribute('name', $configuration->pharName());
		$phar->setAttribute('file', $configuration->pharDownloadLocation());
		if ('' !== $configuration->pharSignatureDownloadLocation()) {
			$phar->setAttribute('signature', $configuration->pharSignatureDownloadLocation());
		}

		file_put_contents(
			$this->targetDirectory . '/mediator.xml',
		    $document->saveXML()
		);
	}
}
