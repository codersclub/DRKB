<h1>Определение координат расположения TaskBar</h1>
<div class="date">01.01.2007</div>



<pre>
uses.., ShellApi;
 
var
  AppBarData: TAppBarData;
  bAlwaysOnTop: Boolean; {Поверх окон}
  bAutoHide: boolean; {Авт. убирать с экрана}
  ClRect: TRect; {Клиентские области}
  Rect: TRect;
  Edge: UInt; {Местоположение TaskBar}
 
procedure DetectTaskBar;
begin
  AppBarData.hWnd := FindWindow('Shell_TrayWnd', nil);
  AppBarData.cbSize := sizeof(AppBarData);
  bAlwaysOnTop := (SHAppBarMessage(ABM_GETSTATE, AppBardata) and ABS_ALWAYSONTOP) &lt; &gt; 0;
  bAutoHide := (SHAppBarMessage(ABM_GETSTATE, AppBardata) and ABS_AUTOHIDE) &lt; &gt; 0;
  GetClientRect(AppBarData.hWnd, ClRect.rc);
  GetWindowRect(AppBarData.hwnd, rect);
  if (Rect.top &gt; 0) then
    Edge := ABE_BOTTOM
  else if (Rect.Bottom &lt; Screen.Height) then
    Edge := ABE_TOP
  else if Rect.Right &lt; Screen.Width then
    Edge := ABE_LEFT
  else
    Edge := ABE_RIGHT;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
{With SHAppBarMessage }
 
 uses
   ShellAPI;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   tabd: TAppBarData;
   PosString: string;
 begin
   FillChar(tabd, SizeOf(TAppBarData), 0);
   tabd.cbSize := SizeOf(TAppBarData);
   if SHAppBarMessage(ABM_GETTASKBARPOS, Tabd) = 0 then Exit;
   with Tabd.rc do
     PosString := Format(' (%d, %d);(%d, %d) ', [Left, Top, Right, Bottom]);
   case tabd.uEdge of
     ABE_LEFT: ShowMessage('Left Position' + PosString);
     ABE_TOP: ShowMessage('Top Position' + PosString);
     ABE_RIGHT: ShowMessage('Right Position' + PosString);
     ABE_BOTTOM: ShowMessage('Bottom Position' + PosString);
   end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
 {With FindWindow, GetWindowRect }
 
 type
   TTaskBarPos = (_TOP, _BOTTOM, _LEFT, _RIGHT, _NONE);
 
 function GetTaskBarPos: TTaskBarPos;
 var
   hTaskbar: HWND;
   T: TRect;
   scrW, scrH: integer;
 begin
   hTaskBar := FindWindow('Shell_TrayWnd', nil);
   if hTaskbar &lt;&gt; 0 then
   begin
     GetWindowRect(hTaskBar, T);
     ScrW := Screen.Width;
     ScrH := Screen.Height;
     if (T.Top &gt; scrH div 2) and (T.Right &gt;= scrW) then
       Result := _BOTTOM
     else if (T.Top &lt; scrH div 2) and (T.Bottom &lt;= scrW div 2) then
       Result := _TOP
     else if (T.Left &lt; scrW div 2) and (T.Top &lt;= 0) then
       Result := _LEFT
     else // the last "if" is not really needed 
    if T.Left &gt;= ScrW div 2 then
       Result := _RIGHT;
   end;
 end;
 
 procedure TForm1.Button5Click(Sender: TObject);
 var
   TaskBarPos: TTaskBarPos;
 begin
   TaskBarPos := GetTaskBarPos;
   case TaskBarPos of
     _LEFT: ShowMessage('Left Position');
     _TOP: ShowMessage('Top Position');
     _RIGHT: ShowMessage('Right Position');
     _BOTTOM: ShowMessage('Bottom Position');
   end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
