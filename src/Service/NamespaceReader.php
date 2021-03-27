<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use Composer\IO\IOInterface;
use function implode;
use function sprintf;
use function strlen;
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

			if (strpos($answer, '\\') === 0) {
				$this->io->write('<error>A namespace is not allowed to start with a backslash</error>');
				continue;
			}

			if (strrpos($answer, '\\') === strlen($answer) - 1) {
				$this->io->write('<error>A namespace is not allowed to end with a backslash</error>');
				continue;
			}

			if (! preg_match('/^([a-zA-Z]+[a-zA-Z0-9]*)+(\\\[a-zA-Z]+[a-zA-Z0-9]*)*$/', $answer)) {
				$this->io->write('<error>This is not a valid namespace name.</error>');
				continue;
			}

			return $answer;
		}
	}
}
