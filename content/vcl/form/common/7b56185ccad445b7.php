<h1>Как сделать форму всегда позади всех окон?</h1>
<div class="date">01.01.2007</div>


<pre>
protected
  procedure CreateParams(var Params: TCreateParams); override;
 
//...
 
procedure TForm.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams(Params);
  if Assigned(Application.MainForm) then
  begin
    Params.WndParent := GetDesktopWindow;
    Params.Style := WS_CHILD;
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
