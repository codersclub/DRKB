---
Title: My Kylix application won\'t run outside the IDE
Date: 01.01.2007
---


My Kylix application won\'t run outside the IDE
===============================================

::: {.date}
01.01.2007
:::

Why is it when I try to run my Kylix App outside the IDE I get this
message:

"error loading shared libraries: libqtintf.so: cannot open shared file:
No such file or directory"?

This message and similar ones occur when ../kylix/bin is not included in
your path when trying to use CLX components. Running
/usr/kylix/bin/kylixpath is a short fix, but you can also add the line
to your .bashrc file to set the paths whenever you start a shell. Be
sure to change the appropriate .bashrc (ie. for user jbrown
/home/jbrown/.bashrc).

Example .bashrc:

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

#.bashrc

..

source /usr/kylix/bin/kylixpath

..

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--  
