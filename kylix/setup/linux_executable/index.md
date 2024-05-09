---
Title: How to run executables created in Kylix
Date: 01.01.2007
---


How to run executables created in Kylix
=======================================

::: {.date}
01.01.2007
:::

Kylix produces ELF binaries so in order to run them outside the IDE you
need to first run `source kylixpath` in the kylix2/bin directory.

This sets up the necessary environment variables.

Then, in a command window, go the directory where your compiled binary is
and enter `./Project1`  if your executable is called "Project1".
