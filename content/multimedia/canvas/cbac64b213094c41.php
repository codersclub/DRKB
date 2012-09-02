<h1>TCanvas и освобождение дескрипторов</h1>
<div class="date">01.01.2007</div>


<p>TCanvas автоматически ReleaseDC не вызывает. При создании холста с WindowDC в качестве дескриптора, лучшей идеей будет создание потомка TCanvas (моделированного с TControlCanvas):</p>

<pre>
type
  TWindowCanvas = class(TCanvas)
  private
    FWinControl: TWinControl;
    FDeviceContext: HDC;
    procedure SetWinControl(AControl: TWinControl);
  protected
    procedure CreateHandle; override;
  public
    destructor Destroy; override;
    procedure FreeHandle;
    property WinControl: TWinControl read FWinControl write SetWinControl;
  end;
 
implementation
 
destructor TWindowCanvas.Destroy;
begin
  FreeHandle;
  inherited Destroy;
end;
 
procedure TWindowCanvas.CreateHandle;
begin
  if FControl = nil then
    inherited CreateHandle
  else
  begin
    if FDeviceContext = 0 then
      FDeviceContext := GetWindowDC(WinControl.Handle);
    Handle := FDeviceContext;
  end;
end;
 
procedure TControlCanvas.FreeHandle;
begin
  if FDeviceContext &lt;&gt; 0 then
  begin
    Handle := 0;
    ReleaseDC(WinControl.Handle, FDeviceContext);
    FDeviceContext := 0;
  end;
end;
 
procedure TControlCanvas.SetWinControl(AControl: TWinControl);
begin
  if FWinControl &lt;&gt; AControl then
  begin
    FreeHandle;
    FWinControl := AControl;
  end;
end;
</pre>


<p>Очевидно, вы должны должны следить за ситуацией, и разрушать TWindowCanvas (или освобождать дескриптор) перед тем, как уничтожить элемент управления, связанный с ним. Также, имейте в виду, что дескриптор DeviceContext не освобождается автоматически после обработки каждого сообщения (как это происходит с дескрипторами TControlCanvas); для освобождения дескриптора вы должны явно вызвать FreeHandle (или разрушить Canvas). И, наконец, имейте в виду, что "WindowCanvas.Handle:= 0" не освобождает десктиптор, для его освобождения вы должны вызывать FreeHandle. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
