<h1>Подключен ли в своем компе протокол TCP/IP?</h1>
<div class="date">01.01.2007</div>


<p>Думаю что надёжнее всего "ping 127.0.0.1" потому что другие методы не дадут уверенности что протокол работает нормально. </p>
<p>Почему именно ping 127.0.0.1?</p>
<p>127.0.0.1 - или по другому localhost - это предопределённый протоколом TCP/IP собственный (внутренний) адрес компьютера, так что если TCP/IP установлен и работает, то этот адрес точно есть и должен пинговаться без проблем, кроме того он пингуется без выхода в сеть, и удобен если надо отличить неработоспособность протокола (драйвера) от поломок вне компьютера(хаб, свич, разъёмы, провода, сервера, другие компьютеры).</p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
uses Registry;
 
function TCPIPInstalled: boolean;
var 
  Reg:   TRegistry; 
  RKeys: TStrings; 
begin 
 Result:=False; 
 try 
  Reg := TRegistry.Create; 
  RKeys := TStringList.Create; 
  Reg.RootKey:=HKEY_LOCAL_MACHINE; 
  if Reg.OpenKey('\Enum\Network\MSTCP', False) Then 
   begin 
     reg.GetKeyNames(RKeys); 
     Result := RKeys.Count &gt; 0; 
   end; 
 finally 
  Reg.free; 
  RKeys.free; 
 end; 
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
