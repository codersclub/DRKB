---
Title: Problem generating font matrix in Kylix
Date: 01.01.2007
---


Problem generating font matrix in Kylix
=======================================

> My install of Kylix was successfull but after startup with
> "startkylix" I see the message "generating font matrix" forever.
> What should I do about this?

If you installed as root the font matrix will be created for each user
the first time they start Kylix. How long it takes depends on the number
of fonts that you have installed and the speed of your machine. If it
seems to freeze or last a long time you should still be able to run
Kylix even if you terminate the font matrix generation.

**Possible workarounds**

This problem could be caused by a bad truetype font. If you have any
Windows tt-fonts installed try removing them. Another thing to try is to
change the order of the font search path in XF86Config or in your
tt-fontserver. Try to put the tt-fonts at the end of the list.

Here is another suggestion from our newsgroups:

Rename the file "transdlg" located in your Kylix bin directory to
"transdlg.renamed" and then run Kylix.

This is an issue we are currently looking into. This document will be
updated when more information is available.
