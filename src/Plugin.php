<?php

declare(strict_types=1);

/**
 * Copyright Andrea Heigl <andreas@heigl.org>
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

namespace Org_Heigl\SinglePharPlugin;

use Composer\Installer\PackageEvent;
use PharIo\SinglePharPluginBase\File;
use PharIo\SinglePharPluginBase\FileList;
use PharIo\SinglePharPluginBase\PluginBase;
use PharIo\SinglePharPluginBase\Url;
use function var_dump;

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

        var_dump(get_class($installer));

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
    	var_dump('tet');exit();
    }
}
