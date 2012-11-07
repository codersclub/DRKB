<h1>Определение адреса во всех открытых Explorer</h1>
<div class="date">01.01.2007</div>


<pre>
uses SHDocVw;

 
procedure TForm1.Button1Click(Sender: TObject);
var
  I: Integer;
  Explorer: IShellWindows;
begin
  Explorer := CoShellWindows.Create;
  for I := 0 to Explorer.Count - 1 do
    Listbox1.Items.Add((Explorer.Item(I) as IWebbrowser2).LocationUrl);
end;
</pre>
<p> <br>
<div class="author">Автор: Александр (Rouse_) Багель</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
 <br>

