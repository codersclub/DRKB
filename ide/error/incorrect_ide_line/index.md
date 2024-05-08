---
Title: IDE highlighting the incorrect line
Date: 01.01.2007
---


IDE highlighting the incorrect line
===================================

> On one project, the IDE insists on highlighting the incorrect line
> for different conditions. For example, when a syntax error is
> highlighted, the line above the error is highlighted or when I set
> breakpoints by choosing a blue dot in the gutter, it does not
> "line up" with the text line. How can I fix this?

This condition is usually caused by opening the file in a different
editor than the editor provided by the IDE. If a line of code is
somehow modified and then saved back to the disk using only a carriage
return for a line terminating character (instead of a carriage return
+ line feed sequence), the IDE may get confused. To fix the problem,
load the file into an editor that will save each line with a carriage
return + line feed sequence.

**Примечание от Vit:**

ошибка исправлена в Дельфи 7.
