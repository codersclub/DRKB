---
Title: Множественный выбор в TStringGrid
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Множественный выбор в TStringGrid
=================================

То же самое я проделывал и с DBGrid. (Пока не реализован
Shift-MouseDown, только Ctrl-MouseDown).

Для TStringGrid вам нужно выполнить следующие шаги:

Заполните сетку, связывая `Objects[0, ARow]` с некоторым логическим
объектом типа:

    TBooleanObject = class(TObject)
    public
      Flag: Boolean;
    end;

В обработчике события OnMouseDown и OnKeyDown измените флаг, как того
требует ситуация.

В обработчике события OnDrawCell отрисуйте строку согласно флагу
`Objects[0,ARow]`.


