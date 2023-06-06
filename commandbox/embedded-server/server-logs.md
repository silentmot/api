# Server Logs

Your CF engine (Lucee, Adobe, etc) or Java app may have application logs of its own and their locations will vary based on what you have running. In any case, they will most likely be located under the server home directory.

## CF App server logs

You can find out where your server home is by running:

```
server info property=serverHomeDirectory
```

You can also get the full path to your servlet's "out" log with this command:

```
server info property=consolelogPath
```

This log file is the equivalent of your **catalina.out** file on a typical Lucee/Tomcat install or the equivalent of your **coldfusion-out.log** file on a typical ColdFusion install.

The Servlet's "out" log can be tailed with this command:

```
server log --follow
server log myServerName --follow
```

Your console "out" log will auto-rotate every 10MB to keep it from getting too big. Don't use the `--debug` or `--trace` flag on a production server or you'll get a lot of logging information! Without those flags, the "out" log doesn't log anything for each request. With debug enabled, you'll get basic information for each request that comes in as well as whether a rewrite rule fired, and with trace, you'll get a ton of information about every request as well as every local path resolution by the path resource manager.

### Lucee Server's Log Files

There are many log files for Lucee. For the guide below, I'm assuming you haven't set a custom **serverConfigDir** or **webConfigDir** for your servers. If you have, adjust the paths for the server and web context to be whatever it is you've configured. Here are the three locations you'll find log file and is pretty much the same for Lucee 4 and Lucee 5.

1. **Lucee's server context log files** - The server context is located under the server home which you can find with the command **server info property=serverHomeDirectory**.  Open that directory and then navigate to **WEB-INF/lucee-server/context/logs/**.
2. **Lucee's web context log files** - The web context is also located under the server home.  Open that directory and then navigate to **WEB-INF/lucee-web/logs/**.

So, to give real examples-- a Lucee server I just looked at on my machine has the three folders of log files I just covered above in these locations:

```
C:/users/brad/.CommandBox/server/{hash}-cfconfig/lucee-4.5.5.006/logs/server.out.txt

C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/application.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/datasource.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/deploy.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/gateway.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/mapping.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/memory.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/orm.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/remoteclient.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/rest.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/scope.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/search.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-server/context/logs/thread.log

C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/application.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/datasource.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/deploy.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/gateway.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/mapping.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/memory.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/orm.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/remoteclient.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/rest.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/scope.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/search.log
C:/users/brad/.CommandBox/server/{hash}cfconfig/lucee-4.5.5.006/WEB-INF/lucee-web/logs/thread.log
```

### Adobe ColdFusion's Log Files

Since Adobe doesn't have the separation of server and web contexts, it only has two log locations which are as follows on all versions.

1. **ColdFusion server log files** - The remaining log files are located under the server home which you can find with the command **server info property=serverHomeDirectory**.  Open that directory and then navigate to **WEB-INF\cfusion\logs/**.

So, to give real examples-- a ColdFusion server I just looked at on my machine has the two folders of log files I just covered above in these locations:

```
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/logs/server.out.txt

C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/application.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/audit.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/eventgateway.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/exception.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/monitor.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/scheduler.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/server.log
C:/users/brad/.CommandBox/server/{hash}-testSite/adobe-2016.0.03.300466/WEB-INF/cfusion/logs/websocket.log
```

## Access Log

CommandBox servers use a powerful Java-based web server which we've tested to have throughput just as good as Apache or IIS. You can enable "access" logs which output one line for each HTTP request (even for static assets like JS or image files) in the same "common" format that Apache web server uses.

```
server set web.accessLogEnable=true
```

View the location of this log or tail the log contents like so:

```
server info property=accessLogPath
server log --follow --access
server log myServername --follow --access
```

Your access log will be auto-rotated every day.

## Rewrite Log

CommandBox servers use the java-based Tuckey rewrite engine for easy URL rewriting. There's a lot of good debugging information available to help figure out why your rewrites aren't working. You can enable a separate rewrite log to view this information. Keep in mind this can generate a lot of logging output.

```
server set web.rewrites.logEnable=true
```

View the location of this log or tail the log contents like so:

```
server info property=rewritesLogPath
server log --follow --rewrites
server log myServername --follow --rewrites
```

Your rewrites log will be auto-rotated every 10MB. The amount of information that appears in the rewrites log will be affected by the `--debug` and `--trace` flags when you start the server.

## Request Dumping

There is a feature you can use to dump all the header details for an HTTP request and response in the form of an Undertow handler called `dump-request()`.  Just include the following server rule in your `server.json`

```javascript
{
  "web" : {
    "rules" : [
      "dump-request()"
    ]
  }
}
```

To fire only for certain requests, you can pair the handler with any predicate you wish:

```
{
  "web" : {
    "rules" : [
      "regex('(.*).cfm') -> dump-request()"
    ]
  }
}
```

Then start your server with the `--console` flag or tail the console with `server log --follow` and you'll see info like this for each request:

```
Request Dump:
----------------------------REQUEST---------------------------
               URI=/bar.cfm
 characterEncoding=null
     contentLength=-1
       contentType=null
            header=Accept=text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
            header=Accept-Language=en-US,en;q=0.9,nb;q=0.8,da;q=0.7
            header=Accept-Encoding=gzip, deflate, br
            header=User-Agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Safari/537.36
            header=Host=127.0.0.1:55599
            locale=[en_US, en, nb, da]
            method=GET
          protocol=HTTP/1.1
            scheme=http
              host=127.0.0.1:55599
        serverPort=55599
          isSecure=false
--------------------------RESPONSE--------------------------
     contentLength=3
       contentType=text/html;charset=UTF-8
            header=Connection=keep-alive
            header=Content-Type=text/html;charset=UTF-8
            header=Content-Length=3
            header=Date=Thu, 31 Mar 2022 22:55:19 GMT
            status=200

==============================================================
```
