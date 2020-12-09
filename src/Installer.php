<?php

declare(strict_types=1);

namespace PharIo\Mediator;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Script\Event;
use PharIo\Mediator\Service\ConfigurationReader;
use PharIo\Mediator\Service\CreateComposerJson;
use PharIo\Mediator\Service\CreateConfigurationFile;
use PharIo\Mediator\Service\CreatePluginClass;
use PharIo\Mediator\Service\DeleteFiles;
use PharIo\Mediator\Service\NamespaceReader;
use SplFileInfo;
use function realpath;

final class Installer
{
	private $io;

	private $composer;

	private function __construct(IOInterface $io, Composer $composer)
	{
		$this->io = $io;
		$this->composer = $composer;
	}

	public function install(Event $event): void
	{
		$installer = new self($event->getIO(), $event->getComposer());

		$installer->runInstallation();
	}

	public function runInstallation(): void
	{
		$configReader = new ConfigurationReader($this->io);
		$namespaceReader = new NamespaceReader($this->io);
		$config = $configReader->getConfiguration();
		$namespace = $namespaceReader->getNamespace();

		$rootDir = realpath(__DIR__ . '/..');

		$composerJson = new CreateComposerJson(new SplFileInfo($rootDir));
		$composerJson($config, $namespace);

		$mediatorXml = new CreateConfigurationFile(new SplFileInfo($rootDir));
		$mediatorXml($config);

		$pluginPhp = new CreatePluginClass(new SplFileInfo($rootDir));

		$deletor = new DeleteFiles(
			new SplFileInfo($rootDir . '/keys/junitdiff.key'),
			new SplFileInfo($rootDir . '/src'),
			new SplFileInfo($rootDir . '/tests'),
			new SplFileInfo($rootDir . '/.git'),
			new SplFileInfo($rootDir . '/.gitignore'),
			new SplFileInfo($rootDir . '/composer.lock'),
			new SplFileInfo($rootDir . '/LICENSE'),
			new SplFileInfo($rootDir . '/phive.xml'),
			new SplFileInfo($rootDir . '/phpunit.xml'),
			new SplFileInfo($rootDir . '/README.md')
		);
		$deletor();

		$pluginPhp($namespace);
	}
}
