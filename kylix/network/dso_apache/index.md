---
Title: Using a DSO on Apache 2.0.43, created with Kylix 3
Date: 01.01.2007
---


Using a DSO on Apache 2.0.43, created with Kylix 3
==================================================

::: {.date}
01.01.2007
:::

After compiling and installing Apache 2.0.39 with DSO support, deploying
an .so file built with Kylix 3 doesn\'t work.

You need to change MODULE\_MAGIC\_NUMBER\_MAJOR in HTTPD.pas file to the
following: MODULE\_MAGIC\_NUMBER\_MAJOR = 20020903;
