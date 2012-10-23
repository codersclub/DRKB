<h1>Как установить разрешение экрана?</h1>
<div class="date">01.01.2007</div>


<p>ChangeDisplaySettings</p>
<div class="author">Автор: cpu </div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
function SetFullscreenMode:Boolean;
var DeviceMode : TDevMode;
begin
 with DeviceMode do begin
  dmSize:=SizeOf(DeviceMode);
  dmBitsPerPel:=16;
  dmPelsWidth:=640;
  dmPelsHeight:=480;
  dmFields:=DM_BITSPERPEL or DM_PELSWIDTH or DM_PELSHEIGHT;
  result:=False;
  if ChangeDisplaySettings(DeviceMode,CDS_TEST or CDS_FULLSCREEN) &lt;&gt; DISP_CHANGE_SUCCESSFUL 
   then Exit;
  Result:=ChangeDisplaySettings(DeviceMode,CDS_FULLSCREEN) = DISP_CHANGE_SUCCESSFUL;
 end;
end;
 
procedure RestoreDefaultMode;
var T : TDevMode absolute 0;
begin
 ChangeDisplaySettings(T,CDS_FULLSCREEN);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
 if setFullScreenMode then begin
  sleep(7000);
  RestoreDefaultMode;
 end;
end;
</pre>
<p>Зайцев О.В.</p>
<p>Владимиров А.М.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
procedure ChangeDisplayResolution(x, y: word);
var
  dm: TDEVMODE;
begin
  ZeroMemory(@dm, sizeof(TDEVMODE));
  dm.dmSize := sizeof(TDEVMODE);
  dm.dmPelsWidth := x;
  dm.dmPelsHeight := y;
  dm.dmFields := DM_PELSWIDTH or DM_PELSHEIGHT;
  ChangeDisplaySettings(dm, 0);
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
