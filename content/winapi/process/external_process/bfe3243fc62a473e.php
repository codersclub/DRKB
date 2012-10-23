<h1>Как найти окно по неполному названию?</h1>
<div class="date">01.01.2007</div>


<p>Код не мой, взят где-то из интернета, авторство не помню, я его работоспособность проверял, но почему-то работает не в 100% случаев, копать дальше не было времени, но может кому пригодится и в таком варианте.</p>
<pre>
type
  PFindWindowStruct = ^TFindWindowStruct;
  TFindWindowStruct = record
    Caption: string;
    ClassName: string;
    WindowHandle: THandle;
  end;
 
function EnumWindowsProc(hWindow: hWnd; lParam: LongInt): Bool; stdcall;
var
  lpBuffer: PChar;
  WindowCaptionFound: bool;
  ClassNameFound: bool;
begin
  GetMem(lpBuffer, 255);
  Result := True;
  WindowCaptionFound := False;
  ClassNameFound := False;
  try
    if GetWindowText(hWindow, lpBuffer, 255) &gt; 0 then
      if Pos(PFindWindowStruct(lParam).Caption, StrPas(lpBuffer)) &gt; 0 then WindowCaptionFound := true;
    if PFindWindowStruct(lParam).ClassName = '' then
      ClassNameFound := True
    else if GetClassName(hWindow, lpBuffer, 255) &gt; 0 then
      if Pos(PFindWindowStruct(lParam).ClassName, StrPas(lpBuffer)) &gt; 0 then ClassNameFound := True;
    if (WindowCaptionFound and ClassNameFound) then
      begin
        PFindWindowStruct(lParam).WindowHandle := hWindow;
        Result := False;
      end;
  finally
    FreeMem(lpBuffer, sizeof(lpBuffer^));
  end;
end;
 
function FindAWindow(Caption: string; ClassName: string): THandle;
var WindowInfo: TFindWindowStruct;
begin
  WindowInfo.Caption := Caption;
  WindowInfo.ClassName := ClassName;
  WindowInfo.WindowHandle := 0;
  EnumWindows(@EnumWindowsProc, LongInt(@WindowInfo));
  FindAWindow := WindowInfo.WindowHandle;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var TheWindowHandle: THandle;
begin
  TheWindowHandle := FindAWindow('Opera', '');
  if TheWindowHandle &lt;&gt; 0 then
    begin
      Showwindow(TheWindowHandle, sw_restore);
      BringWindowToTop(TheWindowHandle);
    end
  else
    ShowMessage('Window Not Found!');
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
function TForm1.Find(s: string): hWnd;
var Wnd: hWnd;
  buff: array[0..127] of Char;
begin
  Find := 0;
  Wnd := GetWindow(Handle, gw_HWndFirst);
  while Wnd &lt;&gt; 0 do
    begin
      if (Wnd &lt;&gt; Application.Handle) and
        IsWindowVisible(Wnd) and
        (GetWindow(Wnd, gw_Owner) = 0) and
        (GetWindowText(Wnd, buff, sizeof(buff)) &lt;&gt; 0) then
        begin
          GetWindowText(Wnd, buff, sizeof(buff));
          if pos(s, StrPas(buff)) &gt; 0 then
            begin
              Find := Wnd;
              Break;
            end;
        end;
      Wnd := GetWindow(Wnd, gw_hWndNext);
    end;
end;
</pre>

<div class="author">Автор: Mikel</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
