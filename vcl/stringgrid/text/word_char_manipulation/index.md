---
Title: Манипуляция словами в TStringGrid
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Манипуляция словами в TStringGrid
=================================

    procedure TForm1.StringGrid1KeyPress(Sender: TObject; var Key: Char);
    var
      s: string;
      c: Byte;
    begin
      with StringGrid1 do
        s := Cells[Col, Row];
      if Length(s) = 0 then
      begin
        if Key in ['a'..'z'] then
        begin
          c := Ord(Key) - 32;
          Key := Chr(c);
        end;
        exit;
      end;
      if s[Length(s)] = ' ' then
        if Key in ['a'..'z'] then
        begin
          c := Ord(Key) - 32;
          Key := Chr(c);
        end;
    end;
    
    
    //В обработчике события onKeyPress сделайте следующее:
     
    if length(field.text) = 0 then
      key := upCase (key);


