<h1>Как определить наличие сопроцессора?</h1>
<div class="date">01.01.2007</div>



<p>В отличие от общепринятого мнения не всее клоны 486/586/686/ и Pentium имеют сопроцессор для вычислений с плавающей запятой. В примере определяется наличие сопроцессора и под Win16 и под Win32.</p>
<p>Пример:</p>
<pre>
{$IFDEF WIN32}
 
uses Registry;
 
{$ENDIF}
 
function HasCoProcesser : bool;
{$IFDEF WIN32}
var
        TheKey : hKey;
{$ENDIF}
begin
        Result := true;
        {$IFNDEF WIN32}
        if GetWinFlags and Wf_80x87 = 0 then
        Result := false;
        {$ELSE}
        if RegOpenKeyEx(HKEY_LOCAL_MACHINE,
        'HARDWARE\DESCRIPTION\System\FloatingPointProcessor',0,
        KEY_EXECUTE, TheKey) &lt;&gt; ERROR_SUCCESS then result := false;
        RegCloseKey(TheKey);
{$ENDIF}
        end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
        if HasCoProcesser then
                ShowMessage('Has CoProcessor') 
        else
                ShowMessage('No CoProcessor - Windows Emulation Mode');
end;
</pre>

<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского       
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>

