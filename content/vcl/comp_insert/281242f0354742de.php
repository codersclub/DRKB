<h1>Как поместить TCheckBox внутри TRichEdit?</h1>
<div class="date">01.01.2007</div>


<p>Для использования следующего примера, необходимо создать новую форму, перетащить на неё TRichEdit (RichEdit1) и создать checkbox (acb) в событии FormCreate().</p>

<pre>
procedure TForm1.FormCreate(Sender: TObject);

var
  Acb: TCheckBox;
begin
  RichEdit1.Left := 20;
  Acb := TCheckBox.Create(RichEdit1);
  Acb.Left := 30;
  Acb.Top := 30;
  Acb.Caption := 'my checkbox';
  Acb.Parent := RichEdit1;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

