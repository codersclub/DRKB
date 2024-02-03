---
Title: Error: RPC Server is unavailable
Date: 01.01.2007
---


Error: RPC Server is unavailable
================================

::: {.date}
01.01.2007
:::

The error is usually caused because the server can\'t be located.  Make
sure you can ping the server machine using the string you typed into the
ComputerName property of the TRemoteServer.   You might also want to try
using an IP address instead in case there is some problem with your DNS
configuration or the hosts file.  Try setting the "Default
Authentication Level" to  (Run DCOMCNFG on the server to do this.) 
Lastly, check the Microsoft Developer\'s Network on the Web for the
latest information on this Microsoft transport.  The MSDN can be located
at the time of the writing at www.microsoft.com/msdn.
