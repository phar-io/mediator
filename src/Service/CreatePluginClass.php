<?php

declare(strict_types=1);

namespace PharIo\Mediator\Service;

use SplFileInfo;
use function file_exists;
use function file_put_contents;

final class CreatePluginClass
{
	private $targetDirectory;

	public function __construct(SplFileInfo $targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function __invoke(string $namespace): void
	{
		$class = <<<EOF
<?php

declare(strict_types=1);

namespace $namespace;

use PharIo\ComposerDistributor\ConfiguredMediator;

final class Plugin extends ConfiguredMediator
{
    public function getDistributorConfig(): string
    {
        return __DIR__ . '/../mediator.xml';
    }
}

EOF;

		if (! file_exists($this->targetDirectory->getRealPath() . '/src' )) {
			mkdir($this->targetDirectory->getRealPath() . '/src', 0755);
		}
		file_put_contents(
			$this->targetDirectory . '/src/Plugin.php',
			$class
		);
	}
}
