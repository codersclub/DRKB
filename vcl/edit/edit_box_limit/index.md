---
Title: Ограничение ввода в текстовое поле
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Ограничение ввода в текстовое поле
==================================

    { 
      In this exemple, the only keys allowed are the 
      same allowed in e-mail adresses. 
    }
     
     procedure TForm1.Edit1KeyPress(Sender: TObject;
       var Key: Char);
     const
       AllowedChars: string = 'abcdefghijklmnopq' +
         'rstuvwxyz01234567_.@';
     var
       i: Integer;
       Ok: Boolean;
     begin
       i  := 0;
       Ok := False;
       { If you erase next line, user won't be able to type backspace }
       if Key = #8 then Ok := True;
       repeat
         i := i + 1;
         if Key = AllowedChars[i] then Ok := True;
       until (Ok) or (i = Length(AllowedChars));
       if not Ok then Key := #0;
     end;

