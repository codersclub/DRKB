---
Title: Получить номер дня в году
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить номер дня в году
=========================

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


 
