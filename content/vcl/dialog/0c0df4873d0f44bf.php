<h1>Как вызвать Shutdown Windows диалог?</h1>
<div class="date">01.01.2007</div>


<pre>
uses ComObj;
 
{....}
 
procedure TForm1.Button1Click(Sender: TObject);
var
  shell: Variant;
begin
  shell := CreateOleObject('Shell.Application');
  shell.ShutdownWindows;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />
<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Открытие диалогового окна "Завершение работы Windows"
 
Зависимости: Windows,Messages
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Gua
Дата:        18 июля 2002 г.
********************************************** }
 
procedure ShutDownWindow;
begin
  SendMessage(FindWindow('Progman','Program Manager'),WM_CLOSE,0,0);
end;
</pre>

