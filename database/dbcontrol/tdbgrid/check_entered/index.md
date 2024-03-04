---
Title: Как узнать значения, которые пользователь вводит в TDBGrid?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать значения, которые пользователь вводит в TDBGrid?
===========================================================

    procedure TForm1.DBGrid1KeyUp(Sender: TObject; 
                                  var Key: Word; Shift: TShiftState); 
    var 
      B: byte; 
     
    begin 
      for B := 0 to DBGrid1.ControlCount - 1 do 
      if DBGrid1.Controls[B] is TInPlaceEdit then 
      begin 
        with DBGrid1.Controls[B] as TInPlaceEdit do 
        begin 
          Label1.Caption := 'Text = ' + Text; 
        end; 
      end; 
    end; 

