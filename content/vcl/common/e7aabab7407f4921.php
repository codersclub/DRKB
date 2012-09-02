<h1>Как разделить обработку OnClick и OnDblClick? Ведь OnClick будет вызываться всегда, и перед DblClick</h1>
<div class="date">01.01.2007</div>


<p>Именно так и происходит в Windows - посылаются оба сообщения. Для того чтобы обработать только какое-то одно событие необходимо чуть "задержать" выполнение OnClick. Сделать это можно следующим способом: </p>
<pre>
procedure TForm1.ListBox1Click(Sender: TObject);
var
  Msg: TMsg;
  TargetTime: Longint;
begin
 { get the maximum time to wait for a double-click message }
  TargetTime := GetTickCount + GetDoubleClickTime;
 { cycle until DblClick received or wait time run out }
  while GetTickCount &lt; TargetTime do
    if PeekMessage(Msg, ListBox1.Handle, WM_LBUTTONDBLCLK, WM_LBUTTONDBLCLK, WM_NOREMOVE)
      then Exit; { Double click }
  MessageDlg('Single clicked', mtInformation, [mbOK], 0);
end;
</pre>

