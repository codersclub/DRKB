<h1>Как реализовать визуальный отсчет времени?</h1>
<div class="date">01.01.2007</div>


<pre>
var Min3: integer;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  timer1.enabled:=true;
  Min3:=3*60;
end;
 
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  Label1.Caption:=Format('%d : %2d',[Min3 div 60, Min3 mod 60 ]);
  Dec(Min3);
  if Min3 &lt; 0 then
    // Что-то делаешь - 3 минуты закончились
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
