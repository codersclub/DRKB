---
Title: Sending a file via DCOM
Date: 01.01.2007
---


Sending a file via DCOM
=======================

I would like to send a file through DCOM however I can only send
standard types.  How can I send bytes across to a client?

You need to use a variant array (VarArrayLock should be useful as well).
