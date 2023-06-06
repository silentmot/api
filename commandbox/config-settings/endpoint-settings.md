# Endpoint Settings

These settings are used to configure CommandBox's endpoints.

**Whenever possible, use the `forgebox endpoint` namespace unless you are setting things manually when those settings not supported by those commands.**

## Default ForgeBox Endpoint

### endpoints.forgebox.APIToken

**string**

The API Token provided to you when you signed up for [ForgeBox.io](https://www.forgebox.io/). This will be set for you automatically when you use the `forgebox register` or `forgebox login` commands. This token will be sent to ForgeBox to authenticate you. Please do not share this secret token with others as it will give them permission to edit your packages!

```bash
config set endpoints.forgebox.APIToken=my-very-long-secret-key
config show endpoints.forgebox.APIToken
```

### endpoints.forgebox.APIURL

**string**

This is the URL of the ForgeBox REST API. Remove this setting to use the default. If you wish change the default Forgebox entry to point to your ForgeBox Enterprise you can do that here. Note, this will funnel ALL ForgeBox calls to the enterprise server where your APIToken may be different. We recommend custom endpoints as an alternative to overriding the default.

```bash
forgebox endpoint register forgebox https://mycompany.forgebox.io/api/v1 --force 
# or
config set endpoints.forgebox.APIURL=https://mycompany.forgebox.io/api/v1
config show endpoints.forgebox.APIURL
```

## Custom Endpoint Settings

You can create your own endpoints usually when you have an [ForgeBox Enterprise](https://www.ortussolutions.com/products/forgebox/enterprise) appliance, and change the default from ForgeBox to your own if desired. All commands will assume the endpoint is the default unless override with the `forgebox publish endpointName=MYENDPOINT` or `forgebox whoami endpointName=MYENDPOINT` for example.

You can register a new endpoint with `forgebox endpoint register myEndpoint "https://forge.intranet.local/api/v1"`

You can see all of your current endpoints with `forgebox endpoint list` which will list out all of your endpoints, including indicating the default endpoint.

```bash
Endpoint: forgebox (Default)
  API URL: https://www.forgebox.io/api/v1/

Endpoint: mycompany
  API URL: https://mycompany.forgebox.io/api/v1
```

To view this as JSON we can run `config show endpoints` and you'll see what this looks like in the config structure.

```bash
{
    "forgebox":{
        "APIToken":"YOUR-API-TOKEN-HERE"
    },
    "forgebox-mycompany":{
        "APIURL":"https://forgebox.stg.ortushq.com/",
        "APIToken":"YOUR-COMPANY-FORGEBOX-API-TOKEN-HERE"
    }
}
```

When setting `APIToken` and `APIURL` for Custom Endpoints, it is a little different, you must use `ForgeBox-YOURENDPOINTNAME` in the commands to match the data structure.

### endpoints.forgebox-MYENDPOINTNAME.APIToken

**string**

The API Token provided to you when you signed up for your Custom ForgeBox Site/Appliance. This will be set for you automatically when you use the `forgebox register` or `forgebox login` commands if this endpoint is the default, or if you use `forgebox login endpointName=mycompany` if mycompany is not the default. This token will be sent to the ForgeBox endpoint to authenticate you. Please do not share this secret token with others as it will give them permission to edit your packages!

```bash
config set endpoints.forgebox-mycompany.APIToken=my-very-long-secret-key
config show endpoints.forgebox-mycompany.APIToken
```

### endpoints.forgebox-MYENDPOINTNAME.APIURL

**string**

This is the URL of the ForgeBox REST API for your custom endpoint. Note, this will funnel ALL ForgeBox calls to this URL if this endpoint is the default, or if you use `forgebox publish endpointName=mycompany` if mycompany is not the default.

```bash
forgebox endpoint register mycompany https://mycompany.forgebox.io/api/v1 --force 
# or
config set endpoints.forgebox-mycompany.APIURL=https://mycompany.forgebox.io/api/v1
config show endpoints.forgebox-mycompany.APIURL
```
