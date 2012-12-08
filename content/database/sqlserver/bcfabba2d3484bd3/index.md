---
Title: Вернуть только время без части даты
Author: Vit
Date: 01.01.2007
---


Вернуть только время без части даты
===================================

::: {.date}
01.01.2007
:::

    cast(cast(@Date as float)-floor(cast(@Date as float)) as datetime)

Автор: Vit
