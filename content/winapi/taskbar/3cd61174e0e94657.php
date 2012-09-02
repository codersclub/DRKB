<h1>Как скрыть TaskBar?</h1>
<div class="date">01.01.2007</div>


<pre>
//Спрятать
procedure TForm1.Button1Click(Sender: TObject);
var
  hTaskBar : THandle;
begin
  hTaskbar := FindWindow('Shell_TrayWnd', Nil);
  ShowWindow(hTaskBar, SW_HIDE);
end;
 
 
//Показать
procedure TForm1.Button2Click(Sender: TObject);
var
  hTaskBar : THandle;
begin
  hTaskbar := FindWindow('Shell_TrayWnd', Nil);
  ShowWindow(hTaskBar, SW_SHOWNORMAL);
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
ShowWindow(FindWindow('Shell_TrayWnd', nil), sw_hide);
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

