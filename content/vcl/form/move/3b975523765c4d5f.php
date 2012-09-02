<h1>Как запретить перемещение формы?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TyourForm = class(TForm)
  private
    { Private declarations }
    procedure WMNCHitTest(var Message: TWMNCHitTest); message WM_NCHITTEST;
  end;
 
procedure TyourForm.WMNCHitTest(var Message: TWMNCHitTest);
begin
  inherited;
 
  with Message do
    if Result = HTCAPTION then
      Result := HTNOWHERE;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
