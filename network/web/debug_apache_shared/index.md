---
Title: How to debug an Apache Shared Module
Date: 01.01.2007
---


How to debug an Apache Shared Module
====================================

::: {.date}
01.01.2007
:::

I am running Apache on Windows and want to know how to debug Apache
Shared Modules?

     It is a straight forward task to debug Shared Modules in Delphi.
The only thing that needs to be done is to set the Host Application and
Parameters for the Shared Module\'s Project. From the Delphi menu bar go
to Run \| Parameters. Set the Host Application to point to Apache.exe,
and specify the following parameters: -X -w -f "c:\\path
tohttpd.conf".

     When you run the project be sure that IIS is not running. If you
need IIS to run while Apache is running then change the Port value
stored in httpd.conf.
