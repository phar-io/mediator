# Mediator

This is a demo plugin that can be used to create your own Composer Plugin
that installs a PHAR file instead of a sh*tload of sourcecode

## Usage

Create your own copy of this project by running

```bash
$ composer create-project phar-io/mediator /path/to/your/source/path
```

After that you should replace or adapt the following informations in these
files:

### `src/Plugin.php`

* Line 11: replace `PharIo\Mediator` with a namespace for your Plugin
  Note: We need this same namespace later in line 16 of the `compposer.json`
  again
* Line 25: replace `JUnitDiff` with the name of your Package.
* Line 35: Replace `junitdiff` with the name of how you want to reference the
  phar-file you are downloading here.
* Line 39: replace the URL to the PHAR file that you want to download. For a
  Guide to replacement-variables see the section "Replacements" later in this
  document
* Line 44: replace the URl to the signature file that you want to use to verify
  the integrity of the downloaded PHAR-file. Again: See the section
  "Replacements" later in this doc for replacement variables.
* If you want to download more than one PHAR-file, duplicate the lines 33 to 46
  and add more `File`-objects to the `FileList`.
* (optional) Line 27: If you want to modify the keys directory, you can specify
  the path to your own key directory here.

### `keys/junitdiff.key`

Replace this key with the public key corresponding to the private key that you
are using to sign the PHAR file with. You can get that by using something like
this command

```bash
$ gpg --export -a junitdiff > keys/mykey.key
```

This will export the key with the ID `junitdiff` into a file `mykey.key` inside
the `keys` directory.

You can add more than one key to that keys-folder and each of the keys will be
used to check for a verification for the signature. So for projects that have
more than one person signing builds you can add all their public keys to this
folder.

### `composer.json`

* Line 2: replace the `name` with your ownn one
* Line 3: replace the `description` with your own one
* Line 5: replace the `licence` with the one you support
* Line 6 through 11: Replace the `authors` with the ones relevant for your
  project or the plugin, depending on your favours.
* Line 16: replace the Namespace of the `Plugin` class with the namespace of
  your `Plugin`-class (as defined above)
* Line 20: replace the namespace `\\Org_Heigl\\SinglePharPlugin` here as well
  with the namespace of your `Plugin`-class.

### LICENSE

Replace the license-file with the appropriate one

### README.md

Replace the README-File with one appropriate for your project

## Replacements

You can use different variables within the URLs that will be replaced with the
values from the current tag of the plugin. Note that this only works when your
versions follow [SemanticVersioning](https://semver.org)

To make it more visible: Let's assume we have a tag 1.2.3-RC04+build567

* *%version%* will be replaed with the full version constraint,
  _1.2.3-RC4+build567_ from the example
* *%major%* will be replaced with the major version, _1_ from the example
* *%minor%* will be replaced with the minor version, _2_ from the example
* *%patch%* will be replaced with the patch version, _3_ from the example
* *%release%* will be replaced with the release version, _RC04_ from the example
* *%build%* will be replaced with the build version, _build567_ from the example
