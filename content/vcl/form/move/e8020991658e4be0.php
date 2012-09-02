<h1>Как узнать, была ли перемещена форма?</h1>
<div class="date">01.01.2007</div>


<pre>type
  TfrmMain = class(TForm)
  private
    procedure OnMove(var Msg: TWMMove); message WM_MOVE;
  end;
 
  (...)
 
procedure TfrmMain.OnMove(var Msg: TWMMove);
begin
  inherited;
  (...)
end;
 
(...)
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
