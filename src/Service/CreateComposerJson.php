<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use PharIo\ComposerDistributor\Config\Config;
use PharIo\Mediator\Configuration;
use SplFileInfo;
use function file_put_contents;
use function json_encode;

class CreateComposerJson
{
	private $targetDirectory;

	public function __construct(SplFileInfo $targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function __invoke(Config $configuration, string $namespace): void
	{
		$composerJson = [
			'name' => $configuration->package(),
			'type' => 'composer-plugin',
			'require' => [
				'composer-plugin-api' => '^2.0',
				'phar-io/composer-distributor' => '~0.5'

			],
			'extra' => [
				'class' => $namespace . '\Plugin'
			],
			'autoload' => [
				'psr-4' => [
					$namespace . '\\' => 'src/'
				]
			]
		];

		file_put_contents(
			$this->targetDirectory->getPathname() . '/composer.json',
			json_encode($composerJson, JSON_PRETTY_PRINT)
		);
	}
}
