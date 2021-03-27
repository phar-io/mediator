# Mediator

This is a template project to create a Composer plugin that installs a PHAR file instead of a sh*tload of sourcecode

## Usage

Create your own copy of this project by running and following the instructions.

```bash
$ composer create-project phar-io/mediator /path/to/your/source/path
```

### Adding your public signing keys

If you are signing your releases you can add the public key to your plugin.
Export your public key like this.

```bash
$ gpg --export -a mykey > keys/mykey.key
```

This will export the key with the ID `mykey` into a file `mykey.key` inside
the `keys` directory.

You can add more than one key to that keys-folder and each of the keys will be
used to check for a verification for the signature. So for projects that have
more than one person signing builds you can add all their public keys to this
folder.

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
