<h1>Позиция курсора в TRichEdit</h1>
<div class="date">01.01.2007</div>


<p>Так как вопрос давольно часто поднимается в форумах, то хотелось бы привести ответ на него. Итак, как же получить текущие координаты курсора (Row и Col) в TRichEdit ?</p>

<p>Вот пример решения данной проблемы:</p>
<pre>
Procedure TForm1.GetPosition(Sender: TRichEdit);
var
  iX,iY  : Integer;
  TheRichEdit : TRichEdit;
begin
  iX := 0; iY := 0;
  TheRichEdit := TRichEdit(Sender);
  iY := SendMessage(TheRichEdit.Handle, EM_LINEFROMCHAR, TheRichEdit.SelStart,
  0);
  iX := TheRichEdit.SelStart - SendMessage(TheRichEdit.Handle, EM_LINEINDEX,
  iY, 0);
  Panel1.Caption := IntToStr(iY + 1) + ':' + IntToStr(iX + 1) ;
end;
 
procedure TForm1.RichEditMouseDown(Sender: TObject;
  Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
begin
  GetPosition(RichEdit);
end;
 
procedure TForm1.RichEditKeyUp(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  GetPosition(RichEdit);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

