---
Title: Массив TEdit-компонентов
Date: 01.01.2007
---


Массив TEdit-компонентов
========================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure DoSomethingWithEditControls;
    var
      K: Integer;
      EditArray: array[0..99] of Tedit;
    begin
      try
        for K := 0 to 99 do
        begin
          EditArray[K] := TEdit.Create(Self);
          EditArray[K].Parent := Self;
          {Устанавливаем необходимые свойства TEdit}
          SetSomeOtherPropertiesOfTEdit;
          Left := 100;
          Top := K * 10;
          {Что-то делаем при перемещении мыши}
          OnMouseMove := WhatToDoWhenMouseIsMoved;
        end;
        {Делаем все что хотим с полученным массивом Edit-компонентов}
        DoWhateverYouWantToDoWithTheseEdits;
      finally
        for K := 0 to 99 do
          EditArray[K].Free;
      end;
    end;
     

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

>...массив ячеек TEdit будет просто замечательным, но я не могу понять
>как мне их создавать и делать видимыми.

Допустим, если они имеют имена с Edit1 по Edit 9, то можно попробовать
сделать так:

    var
      eds: array[1..3,1..3] of TEdit;
      ix: integer;
      ed: TEdit;
    begin
      for ix := 0 to 8 do 
      begin
        ed := FindComponent('Edit'+IntToStr(ix+1)) as TEdit;
        if ed <> nil then 
          eds[ix div 3 + 1,ix mod 3 + 1] := ed;
      end;
    end;


Затем, допустим, вам захотелось скопировать текст из строки 1 в строку 2:

    for ix := 1 to 3 do
      eds[2,ix].Text := eds[1,ix].Text;

