<h1>Как получить эффект тени для hint?</h1>
<div class="date">01.01.2007</div>


<pre>
type 
  TXPHintWindow = class(THintWindow) 
  protected 
    procedure CreateParams(var Params: TCreateParams); override; 
    procedure WMNCPaint(var msg: TMessage); message WM_NCPAINT; 
  end; 
 
function IsWinXP: Boolean; 
begin 
  Result := (Win32Platform = VER_PLATFORM_WIN32_NT) and 
    (Win32MajorVersion &gt;= 5) and (Win32MinorVersion &gt;= 1); 
end; 
 
procedure TXPHintWindow.CreateParams(var Params: TCreateParams); 
const 
  CS_DROPSHADOW = $00020000; 
begin 
  inherited; 
  if IsWinXP then 
    Params.WindowClass.Style := Params.WindowClass.Style or CS_DROPSHADOW; 
end; 
 
procedure TXPHintWindow.WMNCPaint(var msg: TMessage); 
var 
  R: TRect; 
  DC: HDC; 
begin 
  DC := GetWindowDC(Handle); 
  try 
    R := Rect(0, 0, Width, Height); 
    DrawEdge(DC, R, EDGE_ETCHED, BF_RECT or BF_MONO); 
  finally 
    ReleaseDC(Handle, DC); 
  end; 
end; 
 
initialization 
  HintWindowClass := TXPHintWindow; 
  Application.ShowHint := False; 
  Application.ShowHint := True; 
end.
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

