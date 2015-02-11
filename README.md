# appserver.io Magento CRON Implementation

[![Build Status](https://travis-ci.org/appserver-io-app/magento-cron.png)](https://travis-ci.org/appserver-io-app/magento-cron) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/appserver-io-app/magento-cron/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/appserver-io-app/magento-cron/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/appserver-io-app/magento-cron/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/appserver-io-app/magento-cron/?branch=master)

This example describes how to execute Magento CRON jobs with a system CRON.

Why should/can i do this? When you run Magento on a Debian Linux for example, you've to register the `cron.sh`
in your systems CRON table to be executed periodically. This is for sure **NO** big deal, but maybe come
together with some handicaps like missing permissions to do this. If you run Magento inside [appserver.io](http://appserver.io),
life will a bit less complicated, because you're able to execute the Magento CRON by a `Stateless` session bean.

## Installation

To do this, assumed you've installed appserver.io and your Magento instance will be delivered by appserver.io,
you have two installation options.

For both options, you need the sources of this repository. So clone it, open a commandline, change into your 
working  directory, which can be `/tmp` for example, and enter

```
$ git clone https://github.com/appserver-io-apps/magento-cron
```

### Copy SLSB into your Magento installation

The first option is pretty simple. Copy the SFSB into your Magento application folder. Given, you've installed
Magento in a folder `/opt/appserver/webapps/magento-cron` in the application servers document root, do the 
following:

```
$ cd /opt/appserver/webapps/magento-cron
$ mkdir META-INF/classes/AppserverIo/Apps/Magento/Cron/SessionBeans
$ cp /tmp/magento-cron/src/app/META-INF/classes/AppserverIo/Apps/Magento/Cron/SessionBeans/CronSessionBean.php \
     META-INF/classes/AppserverIo/Apps/Magento/Cron/SessionBeans
```

Then [restart](http://appserver.io/get-started/documentation/basic-usage.html) the application server, open `http://127.0.0.1:9080/magento-cron/admin` in your favorite browser, login to the Magento backend and clear the Magento cache. The Magento CRON jobs will now be invoked every minute.

### Deploy the SLSB/Servlet together with a dummy extension

The second option is a bit more complicated, as it uses [ANT](http://ant.apache.org/) to deploy the `SLSB`, a
Servlet, that allows you to invoke the Magento CRON in your browser, and a dummy Magento extension, that will
be invoked by the application servers [Timer-Service](http://appserver.io/get-started/documentation/timer-service.html) the `SLSB` is bound to.

Change into the working copy with `$ cd /tmp/magento-cron`, then invoke `ANT` with `ant deploy`, restart the application server and finally clear the Magento cache. The Magento extension, the `SLSB` and the `Servlet` are now ready. The dummy extensions purpose is simple to log a message whenever the CRON invokes the method declared in the extensions `config.xml`.

You also have the possibility to invoke the CRON process manually. Simple use your favorite browser, request
`http://127.0.0.1:9080/magento-cron//invokeCron.do`, and check the Magento `system.log`, assumed you've activated
logging in Magento backend.

## Summary

Keep in mind, that this is only a simple example and **MUST*** be tested before think of using in production!
