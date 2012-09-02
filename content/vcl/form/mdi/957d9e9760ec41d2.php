<h1>Как узнать, что MDI-форма изменила статус?</h1>
<div class="date">01.01.2007</div>


<pre>
 private
   Procedure WMSize( Var msg: TWMSize ); Message WM_SIZE;
...
Procedure TChildForm.WMSize( Var msg: TWMSize );
Begin
  inherited;
  If msg.SizeType = SIZE_MINIMIZED Then
    ...
End;
</pre>

