<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use Composer\IO\IOInterface;
use PharIo\Mediator\Configuration;
use function implode;
use function sprintf;
use function strpos;

final class ConfigurationReader
{
	private $io;

	public function __construct(IOInterface $io)
	{
		$this->io = $io;
	}

	public function getConfiguration(): Configuration
	{
		return new Configuration(
			$this->readPluginName(),
			$this->readPharName(),
			$this->readPharFileUrl(),
			$this->readSignatureUrl()
		);
	}

	private function readPluginName(): string
	{
		$query = [
			'',
			sprintf(
				"  <question>%s</question>",
				'What is the composer-identifier for your plugin'
			),
			'  <comment>This is in the form "namespace/name"</comment>',
			'  # ',
		];

		while (true) {
			$answer = $this->io->ask(implode("\n", $query));

			if (false !== strpos($answer, '/')) {
				return $answer;
			}
			$this->io->write('<error>This does not seem to be a valid composer-package name</error>');
		}
	}

	private function readPharName(): string
	{
		$query = [
			'',
			sprintf(
				"  <question>%s</question>",
				'What shall be the name of the binary to be executed'
			),
			'  # ',
		];

		while (true) {
			$answer = $this->io->ask(implode("\n", $query));

			return $answer;
		}
	}

	private function readPharFileUrl(): string
	{
		$query = [
			'',
			sprintf(
				"  <question>%s</question>",
				'Where can the PHAR file be downloaded'
			),
			'  <comment>Note that you can replace the actual version-number using replacements</comment>',
			'  <comment>For more information regarding those replacements have a look at</comment>',
			'      <comment>https://github.com/phar-io/mediator#replacements</comment>',
			'  # ',
		];

		while (true) {
			$answer = $this->io->ask(implode("\n", $query));

			if (0 === strpos($answer, 'https://')) {
				return $answer;
			}
			$this->io->write('<error>This does not seem to be a valid URL</error>');
		}
	}

	private function readSignatureUrl(): string
	{
		$query = [
			'',
			sprintf(
				"  <question>%s</question>",
				'Where can the Signature for the PHAR file be downloaded'
			),
			'  <comment>Note that you can replace the actual version-number using replacements</comment>',
			'  <comment>For more information regarding those replacements have a look at</comment>',
			'      <comment>https://github.com/phar-io/mediator#replacements</comment>',
			'  <comment>If you do not have signature files, leave this field empty</comment>',
			'  # ',
		];

		while (true) {
			$answer = $this->io->ask(implode("\n", $query));

			if ('' === $answer) {
				return '';
			}
			if (0 === strpos($answer, 'https://')) {
				return $answer;
			}
			$this->io->write('<error>This does not seem to be a valid URL</error>');
		}
	}
}
