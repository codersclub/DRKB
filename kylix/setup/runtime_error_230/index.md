---
Title: Runtime error 230 when running Kylix application outside of the IDE
Date: 01.01.2007
---


Runtime error 230 when running Kylix application outside of the IDE
===================================================================

::: {.date}
01.01.2007
:::

Why am I getting runtime error 230 when running my application outside
of the Kylix IDE?

This error generally means your application cannot find a needed
library.

Tunning the command  source \\kylix\\bin\\kylixpath  in Linux should fix
this. See the file deploy.txt that comes with Kylix.
