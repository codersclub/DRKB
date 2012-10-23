<h1>Как изменить стандартный цвет TProgressBar?</h1>
<div class="date">01.01.2007</div>


<p>Самый простой способ, это изменить цветовую схему в свойствах экрана...</p>

<p>А вот при помощи следующей команды можно разукрасить ProgressBar не изменяя системных настроек:</p>
<pre>
PostMessage(ProgressBar1.Handle, $0409, 0, clGreen); 
</pre>


<p>Вуаля! Теперь Progress Bar зелёный. Это всего лишь простой пример чёрной магии ;)</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
uses 
  CommCtrl; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  // Set the Background color to teal 
  Progressbar1.Brush.Color := clTeal; 
  // Set bar color to yellow 
  SendMessage(ProgressBar1.Handle, PBM_SETBARCOLOR, 0, clYellow); 
end;
 
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
