<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use Composer\IO\IOInterface;
use function implode;
use function sprintf;
use function strpos;

final class NamespaceReader
{
	private $io;

	public function __construct(IOInterface $io)
	{
		$this->io = $io;
	}

	public function getNamespace(): string
	{
		return $this->readNamespace();
	}

	private function readNamespace(): string
	{
		$query = [
			'',
			sprintf(
				"  <question>%s</question>",
				'What is the PHP-Namespace for your plugin'
			),
			'  <comment>This is in the form "namespace\subnamespace"</comment>',
			'  # ',
		];

		while (true) {
			$answer = $this->io->ask(implode("\n", $query));

			if (false !== strpos($answer, '\\')) {
				return $answer;
			}
			$this->io->write('<error>This does not seem to be a valid namespace name</error>');
		}
	}
}
