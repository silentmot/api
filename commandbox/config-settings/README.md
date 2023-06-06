# Config Settings

CommandBox has a global configuration file that stores user settings. It is located in `~/.CommandBox/CommandBox.json` and can be used to customize core CommandBox behaviors as well as overriding module settings. Config settings are managed by the `config set`, `config show`, and `config clear` commands.

## Set Config Settings

```bash
config set name=mySetting
```

Nested attributes may be set by specifying dot-delimited names or using array notation. If the set value is JSON, it will be stored as a complex value in the commandbox.json.

Set module setting

```bash
config set modules.myModule.mySetting=foo
```

Set item in an array

```bash
config set myArraySetting[1]="value"
```

Set multiple params at once

```bash
config set setting1=value1 setting2=value2 setting3=value3
```

Override a complex value as JSON

```bash
config set myArraySeting="[ 'test@test.com', 'me@example.com' ]"
```

Structs and arrays can be appended to using the "append" parameter. Add an additional settings to the existing list. This only works if the property and incoming value are both of the same complex type.

```bash
config set myArraySetting="[ 'another value' ]" --append
```

## Show Config Settings

Output a setting:

```bash
config show settingName
```

Nested attributes may be accessed by specifying dot-delimited names or using array notation. If the accessed property is a complex value, the JSON representation will be displayed

```bash
config show modules.myModule.settingName
config show mySettingArray[1]
```

using JMESPath filter on the config show command

```bash
#normal selections like above just appended with the special `jq:` filter key
config show jq:modules.myModule.settingName
config show jq:mySettingArray[1]

# filter struct to just show name and modules values
config show 'jq:{name:name, modules:modules}'

# return all the key names from modules
config show 'jq:keys(modules)' 

# return all the key names from modules where key contains the string 'book'
config show "jq:key_contains(modules,'book')"

# get command aliases and assign they key and value to {key: keyname, value: value}
config show 'jq:to_entries(command.aliases)'
[
    {
        "key":"git ",
        "value":"!git "
    }
]
```

## Clear Config Setting

To Remove a setting out of the `CommandBox.json` use the `config clear` command. Nested attributes may be set by specifying dot-delimited names or using array notation.

```bash
config clear description
```
