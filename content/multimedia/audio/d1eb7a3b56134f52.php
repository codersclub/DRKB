<h1>Как проиграть wav из ресурса не сохраняя его в файл?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
var
  FindHandle, ResHandle: THandle;
  ResPtr: Pointer;
begin
  FindHandle := FindResource(HInstance, 'Name of your resource', 'WAVE');
  if FindHandle &lt;&gt; 0 then
  begin
    ResHandle := LoadResource(HInstance, FindHandle);
    if ResHandle &lt;&gt; 0 then
    begin
      ResPtr := LockResource(ResHandle);
      if ResPtr &lt;&gt; nil then
        SndPlaySound(PChar(ResPtr), snd_ASync or snd_Memory);
      UnlockResource(ResHandle);
    end;
    FreeResource(FindHandle);
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
