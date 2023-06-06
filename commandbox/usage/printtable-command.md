# printTable Command

CommandBox has a helper for printing ASCII Art tables in your custom commands and task runners called `print.table()`. We've taken this a step further and wrapped the table printer utility in a new command so you can use it from the CLI directly. The `printTable` command will accept ANY data in as JSON and it will marshal it into a query for you. This means it can be a query, an array of structs, an array or arrays, and more. You can now get quick and easy visualization of any data right from the CLI or in builds.

## Parameters

* `data` - JSON serialized query, array of structs, or array of arrays to represent in table form
* `includeHeaders` - A list of headers to include.&#x20;
* `headerNames` - A list/array of column headers to use instead of the default specifically for array of arrays
* `debug` - Only print out the names of the columns and the first row values

When using an array of arrays and not specifying `headerNames`, the columns will be named `col_1`, `col_2`, `col_3`, etc...

## Examples



```bash
# array of structs
printTable [{a:1,b:2},{a:3,b:4},{a:5,b:6}]

╔═══╤═══╗
║ a │ b ║
╠═══╪═══╣
║ 1 │ 2 ║
╟───┼───╢
║ 3 │ 4 ║
╟───┼───╢
║ 5 │ 6 ║
╚═══╧═══╝
```

```bash
# array of arrays
printTable data=[[1,2],[3,4],[5,6]] headerNames=foo,bar

╔═════╤═════╗
║ foo │bar ║
╠═════╪═════╣
║ 1   │2   ║
╟─────┼─────╢
║ 3   │4   ║
╟─────┼─────╢
║ 5   │6   ║
╚═════╧═════╝
```

```bash
# Query object
#extensionlist | printTable name,version

╔═════════════════════════════════════════╤═══════════════════╗
║ name                                 │ version         ║
╠═════════════════════════════════════════╪═══════════════════╣
║ MySQL                                │ 8.0.19          ║
╟─────────────────────────────────────────┼───────────────────╢
║ Microsoft SQL Server                 │ 6.5.4           ║
╟─────────────────────────────────────────┼───────────────────╢
║ PostgreSQL                           │ 9.4.1212        ║
╟─────────────────────────────────────────┼───────────────────╢
║ Ajax Extension                       │ 1.0.0.3         ║
╚═════════════════════════════════════════╧═══════════════════╝
```

```bash
# JSON list of all servers
server list --json | printTable name,host,port,status

╔══════════════════════════════╤═════════════════════════════╤═══════╤══════════╗
║ name                       │ host                     │ port  │ status  ║
╠══════════════════════════════╪═════════════════════════════╪═══════╪══════════╣
║ servicetest                │ 127.0.0.1                │ 54427 │ stopped ║
╟──────────────────────────────┼─────────────────────────────┼───────┼──────────╢
║ servicetest2               │ 127.0.0.1                │ 52919 │ stopped ║
╟──────────────────────────────┼─────────────────────────────┼───────┼──────────╢
║ FRDemos                    │ 127.0.0.1                │ 50458 │ stopped ║
╚══════════════════════════════╧═════════════════════════════╧═══════╧══════════╝
```

## Terminal Width

If you are running inside a build server, the terminal width will use a default setting, which may be smaller than you wish.  Terminal width can be overridden for entire CLI

```
config set terminalWidth=150
```

or for a specific `printTable` command

```
#extensionlist | printTable width=150
```

or for a specific `print.table()` call

```
print.table( data=qry, width=150 )
```
