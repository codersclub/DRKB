<h1>Как получить Handle рабочего стола</h1>
<div class="date">01.01.2007</div>

Рабочий стол перекрыт сверху компонентом ListView. Вам просто необходимо взять хэндл этого органа управления. Пример:</p>
<pre>
function GetDesktopListViewHandle: THandle;
var
  S: string;
begin
  Result := FindWindow('ProgMan', nil);
  Result := GetWindow(Result, GW_CHILD);
  Result := GetWindow(Result, GW_CHILD);
  SetLength(S, 40);
  GetClassName(Result, PChar(S), 39);
  if PChar(S) &lt;&gt; 'SysListView32' then
    Result := 0;
end;
</pre>
<p>После того, как Вы взяли тот хэндл, Вы можете использовать API этого ListView, определенный в модуле CommCtrl, для того, чтобы манипулировать рабочим столом. Смотрите тему "LVM_xxxx messages" в оперативной справке по Win32.</p>
<p>К примеру, следующая строка кода:</p>
<pre>
SendMessage(GetDesktopListViewHandle, LVM_ALIGN, LVA_ALIGNLEFT, 0);
</pre>
<p>разместит иконки рабочего стола по левой стороне рабочего стола Windows.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
