# Developing For CommandBox

CommandBox is written in CFML, which puts any CFML developer in a position to easily build upon it for their own needs. CommandBox is not only a CLI tool and collection of pre-built commands, but also an extensible framework for building your own CFML-based automations. The core is modular such that anyone can extend it themselves or via the help of community modules hosted on ForgeBox, or any other installation endpoint.

## Modularity

The unit of re-use in CommandBox is the module. A module is nothing more than a folder containing some settings and code that follows a convention. Modules mean that you can develop your own additions and customizations to the tool without needing to modify the core code.

[Read about **Developing Modules** here.](modules/)

## Custom Commands

CommandBox's expressive CLI gets its power from commands. You can create your own commands by packaging simple CFCs inside of modules. This is a powerful way to create custom, reusable CFML scripts that interact with the user, automate hard tasks, and can be shared with other developers. Commands are better than stand alone CFML files because they have very well-defined parameters, validation, and WireBox DI.

[Read about **Developing Commands** here.](commands/)

## Event Model

Customizing the internals of CommandBox is achieved via an event model known as interceptors. What this means is that at pre-defined points in the lifecycle of the shell, command execution, or web server starting, the CLI broadcasts events that you can listen to. This lets you provide custom error handling, special server handling, or modify command output. Interceptors are packaged up in modules and can be combined with custom commands and config settings for fully-configurable shell add-ons.

[Read about **Developing Interceptors** here.](interceptors/)

## Developer Mode

The `developerMode` setting reloads shell before each command to help testing changes to CommandBox core or modules.

```
config set developerMode=true
```

It will prevent you from needing to use the `reload` command, but it will cause a delay before each command.  Don't forget to turn this back off when you're done.
