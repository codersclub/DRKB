<h1>Как обрабатывать ошибки в COM-объектах</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
TCustomBasePlugObject = class(TAutoObject, IUnknown, IDispatch)
...
protected
function SafeCallException(ExceptObject: TObject; ExceptAddr:
  Pointer): {$IFDEF _D4_}HResult{$ELSE}Integer{$ENDIF}; override;
...
 
function TCustomBasePlugObject.SafeCallException;
var
  ExMsg: string;
begin
  Result := inherited SafeCallException(ExceptObject, ExceptAddr);
  try
    if ExceptObject is EAbort then
      exit;
    ExMsg := 'Exception: PlugObject="' if ExceptObject is Exception then
    begin
      ExMsg := ExMsg + #13' Message: '#13' ' +
        Exception(ExceptObject).Message +
        #13' Module:' + GetModuleFileName +
        #13' Adress:' + Format('%p', [ExceptAddr]);
      if (ExceptObject is EOleSysError) and
        (EOleSysError(ExceptObject).ErrorCode &lt; 0) then
        ExMsg := ExMsg + #13'
          OleSysError.ErrorCode =
            '+IntToStr(EOleSysError(ExceptObject).ErrorCode);
    end;
    toLog(ExMsg);
  except
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

