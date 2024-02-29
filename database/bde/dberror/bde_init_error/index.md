---
Title: ISAPI and CGI Applications get Errors Initializing the BDE
Date: 01.01.2007
---


ISAPI and CGI Applications get Errors Initializing the BDE
==========================================================

**Scenario:**  When my ISAPI or CGI Applications try to access the BDE they
get an error when the BDE tries to initialize. The BDE appears to be
installed correctly since regular desktop applications operate without
any problems.

**Suggestion:**  The user that runs under IIS may not have proper
permissions set on the system Temp directory. One suggestions is to
change the security settings to Full Control for the USERS user. Full
Control must be set on Temp in addition to the directory having read,
write permissions. 
