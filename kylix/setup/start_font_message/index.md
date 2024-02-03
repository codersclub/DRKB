---
Title: What is the message Generating font matrix when starting Kylix?
Date: 01.01.2007
---


What is the message Generating font matrix when starting Kylix?
===============================================================

::: {.date}
01.01.2007
:::

Why am I getting a message that says "Generating font matrix. Please
wait" when I start Kylix?

This should only happen the first time you start Kylix using the
startkyix script. The font matrix is used by the Wine implementation of
the Win32 API and you should wait until it finishes. There have been
reports of this appearing to take forever in some Linux versions. If it
seems to take too long you can try canceling it and Kylix should still
run okay.
