---
Title: Как определить день недели?
Author: Vit
Date: 01.01.2007
---


Как определить день недели?
===========================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      d: TDateTime;
    begin
      d := StrToDate(Edit1.Text);
      ShowMessage(FormatDateTime('dddd',d));
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

 

Функции DayOfTheWeek и DayOfWeek (см. справку по Дельфи)

Автор: Vit

 

 
