<h1>Как получить сообщение об изменении стиля?</h1>
<div class="date">01.01.2007</div>


<pre>
const
  WM_THEMECHANGED = $031A;
 
type
  TForm1 = class(TForm)
    {...}
  private
  public
    procedure WMTHEMECHANGED(var Msg: TMessage); message WM_THEMECHANGED;
  end;
 
{...}
 
implementation
 
{...}
 
procedure TForm1.WMTHEMECHANGED(var Msg: TMessage);
begin
  Label1.Caption := 'Theme changed';
  Msg.Result := 0;
end;
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
