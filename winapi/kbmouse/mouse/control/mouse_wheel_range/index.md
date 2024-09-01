---
Title: Получить диапазон, прокручиваемый колесиком мышки
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить диапазон, прокручиваемый колесиком мышки
=================================================

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

