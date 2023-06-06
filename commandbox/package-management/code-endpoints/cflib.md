# CFLib

CommandBox can install UDFs from the popular site CFLib.org. Each project on CFLib is a single CFML function. You can find UDFs via the web site and copy the URL slug for a given UDF to use in your installation.

For example, if the URL to a given UDF is `http://www.cflib.org/udf/CalculateWindChill`, the slug you'll want to use would be `CalculateWindChill`.

## Standard Installation

To install a package from CFLib, use the slug from the website's URL like so:

```bash
install cflib:AreaParallelogram
```

This will create a folder in your installation directory named after the UDF containing a `.cfm` file of the same name. The above command would create the following folder:

```
AreaParallelogram/AreaParallelogram.cfm
```

That file contains a single function that you can call. It is up to you to include that file where ever you want to use the UDF.

```javascript
include '/AreaParallelogram/AreaParallelogram.cfm';
var area = AreaParallelogram( base, height );
```

## ColdBox Installation

If you're using ColBox, you can use a slightly different version of the CFLib endpoint called `CFLib-ColdBox` which will wrap up the UDF inside a CFC and place it in an ad-hoc module which automatically registers the model with WireBox.

```bash
install cflib-coldbox:AreaParallelogram
```

This frees you up from needing to manually include the file. Once you install the module, you can immediately ask WireBox for the UDF using the convention `UDFName@cflib`. WireBox will register this mapping by convention so there is no additional setup required to use the UDF.

```javascript
var area = getInstance( `AreaParallelogram@cflib` ).AreaParallelogram( base, height );
```

Or inject the wrapped UDF to use in your handlers or models.

```javascript
component {
    // Inject the UDF wrapped in a CFC
    property name='areaHelper' inject='AreaParallelogram@cflib';

    function onDIComplete() {
        var area = areaHelper.AreaParallelogram( base, height );
    }
}
```

## Package Metadata

Packages installed from the CFLib endpoint don't have any way to get new version information. They will always show as outdated using the `outdated` or `update` commands and their downloads will not get stored in the artifact cache.

## In box.json

You can specify packages from the CFLib endpoint as dependencies in your `box.json` in this format.

```javascript
{
    "dependencies" : {
        "AreaParallelogram" : "cflib:AreaParallelogram"
        "FahrenheitToCelsius" : "cflib-coldbox:FahrenheitToCelsius"
    }
}
```
