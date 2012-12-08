---
Title: Kylix 3 encounters declaration syntax errors in TIME.H
Date: 01.01.2007
---


Kylix 3 encounters declaration syntax errors in TIME.H
======================================================

::: {.date}
01.01.2007
:::

I am using Kylix 3, and get declaration syntax errors in TIME.H when
attempting to compile any project. How can I solve this problem?     

The TIME.H declaration syntax errors can be resolved by going into the
Project Options and moving the reference to /usr/include up in the
Include path. Preferably, /usr/include should be moved to the very first
position in the ordered Include path.

The exact cause of this problem is not yet known, but it could be
related to Kylix 3 finding a different version of TIME.H elsewhere on
the system. For reference, Kylix 3 contains four instances of TIME.H, in
the following locations:

/usr/include/linux

/usr/include/bits

/usr/include/sys

/usr/include     
