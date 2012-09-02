<h1>Бегущая строка</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Timer1Timer(Sender: TObject);
const
  LengthGoString = 10;
  Gostring = 'Этот код был взят с проекта Delphi World'+
  ' Выпуск 2002 - 2003! Этот код б';
  // Повторить столько символов - сколько в LengthGoString
const
  i: Integer = 1;
begin
  Label1.Caption := Copy(GoString, i, LengthGoString);
  Inc(i);
  if Length(GoString) - LengthGostring &lt; i then
    i:=1;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
