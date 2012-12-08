---
Title: Ошибка: lock manager out of room
Date: 01.01.2007
---


Ошибка: lock manager out of room
================================

::: {.date}
01.01.2007
:::

Go to the interbase/bin directory (Windows) or /usr/interbase (Unix) and
locate the configuration file isc\_config. By default your configuration
file will look like this:

\#V4\_LOCK\_MEM\_SIZE                       98304

\#ANY\_LOCK\_MEM\_SIZE              98304

\#V4\_LOCK\_SEM\_COUNT              32

\#ANY\_LOCK\_SEM\_COUNT          32

\#V4\_LOCK\_SIGNAL                        16

\#ANY\_LOCK\_SIGNAL                        16

\#V4\_EVENT\_MEM\_SIZE                      32768

\#ANY\_EVENT\_MEM\_SIZE             32768

I increased the V4\_LOCK\_MEM\_SIZE entry from 98304 to 198304 and
things were fine then.

!!! Important !!!

By default all lines in the config file are commented out with the
leading \# sign. Make sure to remove the \# sign in any line that you
change - the default config file just shows the default parameters.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
