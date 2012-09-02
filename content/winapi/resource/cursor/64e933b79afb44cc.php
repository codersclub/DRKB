<h1>Как отключить курсор мыши?</h1>
<div class="date">01.01.2007</div>


<pre>
//Выключение курсора
procedure TForm1.Button1Click(Sender: TObject);
var
  CState: Integer;
begin
  CState := ShowCursor(True);
  while Cstate &gt;= 0 do
    Cstate := ShowCursor(False);
end;
 
//Включение курсора
procedure TForm1.Button2Click(Sender: TObject);
var
  Cstate: Integer;
begin
  Cstate := ShowCursor(True);
  while CState &lt; 0 do
    CState := ShowCursor(True);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
