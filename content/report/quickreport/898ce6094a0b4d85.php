<h1>Проблема с установками принтера</h1>
<div class="date">01.01.2007</div>


<p>Обнаружил, что компонент QReport никак не реагирует на установки принтера PrinterSetup диалога, вызываемого нажатием кнопочкисобственного Preview!</p>

<p>В QuickReport есть собственный объект TQRPrinter, установки которого он использует при печати, а стандартные установки принтеров на него не влияют. В диалоге PrinterSetup, вызываемом из Preview можно лишь выбрать принтер на который нужно печатать (если, конечно, установлено несколько принтеров).</p>

<p>Советую поставить обновление QReport на 2.0J с www.qusoft.com.</p>

<p>Перед печатью (не только из QReport) программно установите требуемый драйвер принтера текущим для Windows</p>
<pre>
function SetDefPrn(const stDriver : string) : boolean;
begin
  SetPrinter(nil).Free;
  Result := WriteProfileString('windows', device, PChar( stDriver));
end;
</pre>



<p>После печати восстановите установки.</p>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
