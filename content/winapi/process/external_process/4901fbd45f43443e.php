<h1>Как передать строку другому приложению?</h1>
<div class="date">01.01.2007</div>

получатель:</p>
<pre>
procedure ReceiveMessage (var Msg: TMessage);
message WM_COPYDATA;
...
procedure TFormReceive.ReceiveMessage;
var
  pcd: PCopyDataStruct;
begin
  pcd := PCopyDataStruct(Msg.LParam);
  Caption := PChar(pcd.lpData);
end;
</pre>
<p>отправитель:</p>
<pre>
procedure TFormXXX.Button1Click(Sender: TObject);
var
  cd: TCopyDataStruct;
begin
  cd.cbData := Length(Edit1.Text) + 1;
  cd.lpData := PChar(Edit1.Text);
  SendMessage(FindWindow('TFormReceive', nil), WM_COPYDATA, 0, LParam(@cd));
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

