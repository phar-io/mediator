<?php
/**
 * Copyright The ComposerDistributor-Team
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

declare(strict_types=1);

namespace PharIo\Mediator;

use Composer\Installer\PackageEvent;
use PharIo\ComposerDistributor\File;
use PharIo\ComposerDistributor\FileList;
use PharIo\ComposerDistributor\PluginBase;
use PharIo\ComposerDistributor\Url;

class Plugin extends PluginBase
{
    public function installOrUpdateFunction(PackageEvent $event): void
    {
        $installer = $this->createInstaller(
            // Replace this with the name of your plugin
            'org_heigl/single-phar-plugin',
            // replace this with the path to your key directory
            __DIR__ . '/../keys/',
            // needs to be passed on!
            $event
        );

        $installer->install(new FileList(
        	new File(
	            // Replace this with the name of the binary that you want to use within the folder vendor/bin/
	            'junitdiff',
	            Url::fromString(
	                // replace this with the path to the phar file. Replacements are described in the
	                // [README.md](https://)
	                'https://github.com/heiglandreas/JUnitDiff/releases/download/%version%/junitdiff.phar'
	            ),
	            Url::fromString(
	                // replace this with the path to the signature-file for the phar. Replacements are described in the
	                // [README.md](https://)
	                'https://github.com/heiglandreas/JUnitDiff/releases/download/%version%/junitdiff.phar.asc'
	            )
	        ),
        ));
    }
}
