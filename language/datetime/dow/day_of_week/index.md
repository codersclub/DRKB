---
Title: Как определить день недели?
Author: Vit
Date: 01.01.2007
---


Как определить день недели?
===========================

Вариант 1: 

Author: Vit

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.Button1Click(Sender: TObject);
    var
      d: TDateTime;
    begin
      d := StrToDate(Edit1.Text);
      ShowMessage(FormatDateTime('dddd',d));
    end;


------------------------------------------------------------------------

Вариант 2: 

Author: Vit

Функции `DayOfTheWeek` и `DayOfWeek` (см. справку по Дельфи)


 

 
