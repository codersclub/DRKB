---
Title: Получить диапазон, прокручиваемый колесиком мышки
Date: 01.01.2007
---


Получить диапазон, прокручиваемый колесиком мышки
=================================================

::: {.date}
01.01.2007
:::

    //Not supported on Windows 95 
    //result = -1: scroll whole page 
     
    function GetNumScrollLines: Integer;
     begin
       SystemParametersInfo(SPI_GETWHEELSCROLLLINES, 0, @Result, 0);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(IntToStr(GetNumScrollLines));
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
