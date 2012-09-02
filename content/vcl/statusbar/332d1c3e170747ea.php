<h1>Установить размер шрифта для панели TStatusBar</h1>
<div class="date">01.01.2007</div>


<pre>
With StatusBar1.Panels[1] do
begin
  Text := Edit1.Text;
  Canvas.Font.Size := StatusBar1.Font.Size;
  Width := Canvas.TextWidth(Text) + 10;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
