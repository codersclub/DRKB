---
Title: Преобразование координат в параметрах событий OnDragOver и OnDragDrop в координаты формы
Author: Neil
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Преобразование координат в параметрах событий OnDragOver и OnDragDrop в координаты формы
========================================================================================

Поверьте, достаточно просто преобразовать X,Y координаты, передаваемые в
параметрах событий OnDragOver и OnDragDrop, в координаты формы.

Работайте со свойствами Left и Top компонента, над которым перемещается
курсор. Приведу простой пример. Поместите на форму компонент Memo и
присвойте свойству Align значение alTop. Поместите на форму панель,
также присвойсте свойству Align значение alTop и задайте небольшое
значение свойству Height, скажем 6 или 7 пикселей. Установите DragMode
на dmAutomatica и DragCursor на crVSplit. Поместите другой
Memo-компонент и установите Align на alClient. Одновременно выберите оба
Memo-компонента, панель и создайте общий обработчик события OnDragOver
как показано ниже:

    procedure TForm1.Memo1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    begin
      if Source = Panel1 then
        with Sender as TControl do
        begin
          Accept := True;
          Memo1.Height := Y + Top;
        end
      else
        Accept := False;
    end;



 
