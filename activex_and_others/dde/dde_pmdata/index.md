---
Title: Получение данных из Program Manager через DDE
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Получение данных из Program Manager через DDE
=============================================

Установите соединение DDEClientConv с сервером и установите обоим
DdeTopic в \'ProgMan\'. Вызовите RequestData и передайте \'Groups\' как
элемент (item); обратно вы получите список имен групп. Вызовите
RequestData с одним из имен групп и вы получите детальную информцию о
группе. Вероятно дальше вы захотите передать полученные данные в
ListBox, т.к. сразу можно увидеть что мы имеем и как затем это можно
обработать, например:

    VAR P : PChar;
    ...
    P := DdeClientConv1.RequestData('Groups');
    ListBox1.Items.SetText(P);
    StrDispose(P);
    ...
    WITH ListBox1 DO
    P := DdeClientConv1.RequestData(Items[ItemIndex]);
    ListBox2.Items.SetText(P);
    StrDispose(P);
    ...


