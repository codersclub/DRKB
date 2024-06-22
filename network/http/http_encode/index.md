---
Title: HTTP кодирование строки
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


HTTP кодирование строки
=======================

    function HTTPEncode(const AStr: string): string;
     const
       NoConversion = ['A'..'Z', 'a'..'z', '*', '@', '.', '_', '-'];
     var
       Sp, Rp: PChar;
     begin
       SetLength(Result, Length(AStr) * 3);
       Sp := PChar(AStr);
       Rp := PChar(Result);
       while Sp^ <> #0 do
       begin
         if Sp^ in NoConversion then
           Rp^ := Sp^
         else if Sp^ = ' ' then
           Rp^ := '+'
         else
         begin
           FormatBuf(Rp^, 3, '%%%.2x', 6, [Ord(Sp^)]);
           Inc(Rp, 2);
         end;
         Inc(Rp);
         Inc(Sp);
       end;
       SetLength(Result, Rp - PChar(Result));
     end;
     
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       Edit1.Text := HTTPEncode(Edit1.Text);
     end;

