<h1>Как определить, установлена ли звуковая карта?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
if WaveOutGetNumDevs &gt; 0 then
  ShowMessage('Wave-Device present')
else
  ShowMessage('No Wave-Device present');
{ ... }
</pre>

<hr />
<pre>
function IsSoundCardInstalled: Boolean;
type
  SCFunc = function: UInt; stdcall;
var
  LibInst: LongInt;
  EntryPoint: SCFunc;
begin
  Result := False;
  LibInst := LoadLibrary(PChar('winmm.dll'));
  try
    if LibInst &lt;&gt; 0 then
    begin
      EntryPoint := GetProcAddress(LibInst, 'waveOutGetNumDevs');
      if (EntryPoint &lt;&gt; 0) then
        Result := True;
    end;
  finally
    if (LibInst &lt;&gt; 0) then
      FreeLibrary(LibInst);
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
