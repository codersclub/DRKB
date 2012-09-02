<h1>Отключить реакцию на события мыши</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.ApplicationEvents1Message(var Msg: tagMSG;
  var Handled: Boolean);
begin
  Handled := (msg.wParam = vk_lButton) or
             (msg.wParam = vk_rButton) or
             (msg.wParam = vk_mButton);
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
