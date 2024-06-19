---
Title: Получить и установить системные цвета
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Получить и установить системные цвета
=====================================

    var 
      OldColor: TColor; 
      Element: TColor = COLOR_BTNFACE; 
      {....} 
     
    { 
      Set the color for a system element. SetSysColors function 
      changes the current Windows session only. 
      The new colors are not saved when Windows terminates. 
      For a list of color elements see  Win32 API Help - Function GetSysColor 
     
      Open the ColorDialog - and set the new color systemwide 
    } 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if ColorDialog1.Execute then 
      begin 
        SetSysColors(1, Element, ColorDialog1.Color); 
      end; 
    end; 
     
    { 
      Save the old color value of the element COLOR_BTNFACE to restore on Button2 click 
    } 
     
    procedure TForm1.FormShow(Sender: TObject); 
    begin 
      OldColor := GetSysColor(COLOR_BTNFACE); 
    end; 
     
    { 
      Restore the old color value 
      Stellt den alten Farbwert wieder her 
    } 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      SetSysColors(1, Element, OldColor); 
    end;

