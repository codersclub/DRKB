<h1>Как узнать, подключен ли компьютер к сети?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if GetSystemMetrics(SM_NETWORK) and $01 = $01 then 
    ShowMessage('Computer is attached to a network!') 
  else 
    ShowMessage('Computer is not attached to a network!'); 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
