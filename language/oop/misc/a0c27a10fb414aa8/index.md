---
Title: Работа метода Assign
Date: 01.01.2007
---


Работа метода Assign
====================

::: {.date}
01.01.2007
:::

В общем случае, утверждение \"Destination := Source\" не идентично
утверждению \"Destination.Assign(Source)\".

Утверждение \"Destination := Source\" принуждает Destination ссылаться
на тот же объект, что и Source, а \"Destination.Assign(Source)\"
копирует содержание объектных ссылок Source в объектные ссылки
Destination.

Если Destination является свойством некоторого объекта (тем не менее, и
свойство не является ссылкой на другой объект, как, например, свойство
формы ActiveControl, или свойство DataSource элементов управления для
работы с базами данных), тогда утверждение \"Destination := Source\"
идентично утверждению \"Destination.Assign(Source)\". Это объясняет,
почему LB.Items := MemStr работает, когда MemStr := LB.Items нет.

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
