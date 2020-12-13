<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use SplFileInfo;
use function file_exists;
use function file_get_contents;
use function file_put_contents;

final class CreatePluginClass
{
	private $targetDirectory;

	private $template;

	public function __construct(SplFileInfo $targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
		$this->template = file_get_contents(__DIR__ . '/../Plugin.php');
	}

	public function __invoke(string $namespace): void
	{
		$class = preg_replace(
			'/namespace\s[^;]+;/',
			'namespace ' . $namespace . ';',
			$this->template
		);

		if (! file_exists($this->targetDirectory->getRealPath() . '/src' )) {
			mkdir($this->targetDirectory->getRealPath() . '/src', 0755);
		}
		file_put_contents(
			$this->targetDirectory . '/src/Plugin.php',
			$class
		);
	}
}
