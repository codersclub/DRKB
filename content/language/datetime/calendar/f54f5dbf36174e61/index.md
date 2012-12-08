---
Title: Получить номер дня в году
Date: 01.01.2007
---


Получить номер дня в году
=========================

::: {.date}
01.01.2007
:::

    function GetDays(ADate: TDate): Extended;
     var
       FirstOfYear: TDateTime;
     begin
       FirstOfYear := EncodeDate(StrToInt(FormatDateTime('yyyy', now)) - 1, 12, 31);
       Result      := ADate - FirstOfYear;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       label1.Caption := 'Today is the ' + FloatToStr(GetDays(Date)) + '. day of the year';
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 
