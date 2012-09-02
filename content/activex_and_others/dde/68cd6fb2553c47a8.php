<h1>DDE &ndash; передача текста</h1>
<div class="date">01.01.2007</div>

Вот я как работаю с Excel:</p>
<pre>
type
  DDEClientConv1.SetLink('Excel', 'Sheet1');
try
  DDEClientConv1.OpenLink;
  DDEClientItem1.DDEItem := 'R1C1';
  DDEClientConv1.PokeData(DDEClientItem1.DDEItem,
    StrPCopy(P, SomeString)));
finally
  DDEClientConv1.CloseLink;
end;
</pre>
<p>Как вы можете здесь видеть, свойство DDEItem определяется сервером. Если ваш сервер является приложением Delphi, то DDEItem - имя DDEServerItem. На вашем месте я бы не стал так долго заниматься отладкой DDE-программ. Воспользуйтесь синхронизацией, позволяющей понять при отладке правильность действий</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
