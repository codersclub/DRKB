---
Title: Прибавить час
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Прибавить час
=============

Тип TDateTime, используемый для передачи даты и времени, это тип double,
у которого целая часть определяет день, а дробная время от полуночи. То
есть, если прибавить ко времени 1, то дата изменится на один день, а
время не изменится. Если прибавить 0.5, то прибавится 12 часов. Причем
этот метод работает даже в том случае, когда меняется дата, месяц или
год.

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      Label1.Caption := DateTimeToStr(Time);
      Label2.Caption := DateTimeToStr(Time + 1 / 24);
    end;


