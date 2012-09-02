<h1>Как ограничить длинну вводимого текста шириной TEdit'а?</h1>
<div class="date">01.01.2007</div>


<p>Как ограничить длинну текста, вводимого в TEdit, так чтобы ширина текста не превышала</p>
<p>ширину TEdit'а?</p>

<p>В примере приведено два способа ограничить длинну текста в TEdit так чтобы она не превышала ширину клиентской области окна TEdit'а и не появлялась прокрутка текста. Первый способ устанавливает свойство TEdit'а MaxLength равным числу букв "W", которые поместятся в TEdit. "W" выбрана потому, что является, наверное, самой широкой буквой в любом шрифте. Этот метод сносно работает для шрифтов с фиксированной шириной букв, но для шрифтов с переменной шириной букв вряд ли сгодится. Второй способ перхватывает событие KeyPress TEdit'а и измеряет ширину уже введенного текста и ширину нового символа. Если ширина больше чем клиентская область TEdit'а новый символ отбрасывается и вызывается MessageBeep. </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  cRect: TRect;
  bm: TBitmap;
  s: string;
begin
  Windows.GetClientRect(Edit1.Handle, cRect);
  bm := TBitmap.Create;
  bm.Width := cRect.Right;
  bm.Height := cRect.Bottom;
  bm.Canvas.Font := Edit1.Font;
  s := 'W';
  while bm.Canvas.TextWidth(s) &lt; CRect.Right do
    s := s + 'W';
  if length(s) &gt; 1 then
    begin
      Delete(s, 1, 1);
      Edit1.MaxLength := Length(s);
    end;
end;
</pre>
<p>{Другой вариант}</p>

<pre>
procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
var
  cRect: TRect;
  bm: TBitmap;
begin
  if ((Ord(Key) &lt;&gt; VK_TAB) and (Ord(Key) &lt;&gt; VK_RETURN) and
    (Ord(Key) &lt;&gt; VK_LEFT) and (Ord(Key) &lt;&gt; VK_BACK)) then
    begin
      Windows.GetClientRect(Edit1.Handle, cRect);
      bm := TBitmap.Create;
      bm.Width := cRect.Right;
      bm.Height := cRect.Bottom;
      bm.Canvas.Font := Edit1.Font;
      if bm.Canvas.TextWidth(Edit1.Text + Key) &gt; CRect.Right then
        begin
          Key := #0;
          MessageBeep(-1);
        end;
      bm.Free;
    end;
end;
</pre>

