---
Title: Why can\'t I run my Kylix application outside of the IDE?
Date: 01.01.2007
---


Why can\'t I run my Kylix application outside of the IDE?
=========================================================

::: {.date}
01.01.2007
:::

What do I need to do to run a Kylix application outside of the IDE?

You need to have your LD\_LIBRARY\_PATH variable set to your bin
directory. Your bin directory is located under your Kylix directory. You
can set this by sourcing the kylixpath script. From an xterm window go
to the Kylix bin directory and enter

source kylixpath

See the README file for more details.
