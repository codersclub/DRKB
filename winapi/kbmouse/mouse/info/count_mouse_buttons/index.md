---
Title: Определить количество кнопок мышки
Date: 01.01.2007
---


Определить количество кнопок мышки
==================================

::: {.date}
01.01.2007
:::

    // if the result is 0, no mouse is present 
     
    function GetNumberOfMouseButtons: Integer;
     begin
       Result := GetSysTemMetrics(SM_CMOUSEBUTTONS);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage('Your mouse has ' + IntToStr(GetNumberOfMouseButtons) + ' buttons.');
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
