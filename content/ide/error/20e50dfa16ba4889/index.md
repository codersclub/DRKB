---
Title: Error: Interface not supported
Date: 01.01.2007
---


Error: Interface not supported
==============================

::: {.date}
01.01.2007
:::

I receive an \"Interface is not supported\" error when trying to use an
interface.

Verify that STDVCL32.DLL and your type library are registered.  If
casting an interface, you must be using DCOM and the type library must
be registered on the client.
