# System Modules

CommandBox can be extended by modules installed from external locations. When you install a CommandBox module, it will automatically be placed in the correct modules location (inside your CommandBox installation) regardless of where you run the `install` command from.

```
install commandbox-fusionreactor
```

Later, if you want to view, uninstall, update, or otherwise interact with these system modules, you can just use the standard package management commands, but add the `--system` flag to them. Any time you add that flag, the current working directory will be ignored, and you'll be interacting with the core modules installed into CommandBox.

```
package list --system
package update --system
package uninstall commandbox-fusionreactor --system
```

The package commands that accept a `--system` flag are as follows:

* package install
* package uninstall
* package outdated
* package list
* package update
* package show
* package set
* package clear
