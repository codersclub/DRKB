---
Title: Перемещение на страницу TabSet по имени
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перемещение на страницу TabSet по имени
=======================================

> Как переместиться на страницу TabSet по имени?

Разместите компоненты Tabset(TabSet1) и Edit (Edit1) на вашей форме.
Измените свойство компонента Tabset Tabs для размещения в списке строк
следующих четерёх закладок:

- Hello
- World
- Of
- Delphi

Создайте обработчик события onChange компонента Edit1 как показано ниже:

    procedure TForm1.Edit1Change(Sender: TObject);
    var
      I: Integer;
    begin
      for  I:= 0 to tabset1.tabs.count-1 do
        if  edit1.text = tabset1.tabs[I] then
          tabset1.tabindex:=I;
    end;

Теперь при наборе любого из существующих имен в edit1 соотвутствующая
закладка будет выведена на передний план.


