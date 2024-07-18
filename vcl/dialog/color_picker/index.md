---
Title: Открытие сокращенного или полного диалога выбора цвета
Author: Igor Kovalevsky, pc-ambulance@mail.ru
Date: 01.06.2002
---


Открытие сокращенного или полного диалога выбора цвета
======================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Открытие сокращённого или полного диалога выбора цвета
     
    Вид диалога зависит от того, можно ли показать начальный цвет (C : TColor) 
    в сокращённом диалоге или нужно раскрывать его полностью. 
    Возвращает выбранный пользователем цвет.
     
    Зависимости: Windows, Messages, SysUtils, Classes, DIALOGS;
    Автор:       Igor Kovalevsky, pc-ambulance@mail.ru, Владикавказ
    Copyright:   Igor Kovalevsky
    Дата:        1 июня 2002 г.
    ********************************************** }
     
    function SelectColor(C : TColor) : TColor;
    const
         BasicColors = [ $00, $40, $80, $A0, $C0, $FF ];
    begin
         with TColorDialog.Create(Application) do
              begin
                   Color := C;
                   if (GetRValue(Color) in BasicColors) and
                      (GetGValue(Color) in BasicColors) and
                      (GetBValue(Color) in BasicColors) then
                      begin
                           Options := Options - [ cdFullOpen ];
                      end
                   else
                       begin
                            Options := Options + [ cdFullOpen ];
                       end;
                   if Execute then
                      begin
                           Result := Color
                      end
                   else
                       begin
                            Result := clNone;
                       end;
                   Free;
              end;
    end; 

Пример использования:

    Form1.Color := SelectColor( Form1.Color ); 
