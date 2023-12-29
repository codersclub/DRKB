---
Title: How to turn off ISAPI DLL caching on Windows 2000 and IIS5
Date: 01.01.2007
---


How to turn off ISAPI DLL caching on Windows 2000 and IIS5
==========================================================

::: {.date}
01.01.2007
:::

You may want to turn off DLL caching to allow you to better debug ISAPI
DLL\'s. Note that if you do turn it off, it is best to turn it back on
when you are ready to use your DLL as it greatly improves performance.

Click on Start-\>Settings-\>Control Panel-\>Administrative
Tools-\>Internet Services Manager. Right click on your website and
select Properties:

\[IIS Manager Screen Shot\]

Select the \"Home Directory\" tab, and click on Configuration...:

\[Configuration\]

Uncheck \"Cache ISAPI applications\":

\[uncheck cache extensions\]
