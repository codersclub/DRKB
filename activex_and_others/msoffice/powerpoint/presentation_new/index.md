---
Title: How to start a new presentation
Date: 01.01.2007
---


How to start a new presentation
===============================

::: {.date}
01.01.2007
:::

```
PowerPoint.Presentations.Open(\'PresName.ppt\', msoFalse, msoFalse, msoTrue);
```
 

The second parameter specifies whether the presentation should be opened
in read-only mode. If the third parameter is True, an untitled copy of
the file is made. The last parameter specifies whether the opened
presentation should be visible. You can miss these parameters out in
late binding if you\'re happy with the defaults (False, False, True,
respectively, as in the code shown.)
