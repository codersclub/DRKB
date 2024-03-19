---
Title: Как запустить Access
Date: 01.01.2007
---


Как запустить Access
============

Если у вас есть патч D5, вы можете использовать компонент TAccessApplication для запуска Access.
Бросьте одну форму, и если ее свойство AutoConnect имеет значение true,
Access запустится автоматически при запуске вашей программы;
если свойство AutoConnect = ложь, то просто сделайте следующий вызов для запуска приложения:

    AccessApplication1.Connect;

Чтобы использовать работающий экземпляр Access, если он есть,
установите для свойства ConnectKind приложения TAccessApplication
значение ckRunningOrNew;
либо значение ckRunningInstance если вы не хотите запускать новый экземпляр, если Access не запущен.

После запуска Access вы можете подключить другие компоненты, такие как TAccessReport,
используя их методы ConnectTo:

      AccessApplication1.Connect;
      AccessApplication1.Visible := True;
      AccessApplication1.OpenCurrentDatabase('C:\Office\Samples\Northwind.mdb', True);
      AccessApplication1.DoCmd.OpenReport('Sales by Year', acViewDesign, EmptyParam, EmptyParam);
      AccessReport1.ConnectTo(AccessApplication1.Reports['Sales by Year']);
      AccessReport1.Caption := 'Annual sales - from bad to worse';

Обратите внимание, что книга или лист должны быть открыты,
прежде чем вы сможете к ним подключиться.

Если у вас нет патча для D5, запуск Access немного отличается,
поскольку в нем нет компонента TAccessApplication.
(Это связано с тем, что Microsoft объявила объект Application скрытым в библиотеке типов.)

Однако вы можете создать объект «Приложение» так же, как это было сделано в D4 (см. ниже),
а затем подключить к нему компоненты Access.
Пример см. в разделе «Доступ — распространенные проблемы».
