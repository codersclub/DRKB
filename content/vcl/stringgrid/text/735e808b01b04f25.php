<h1>Манипуляция словами в TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
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
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
