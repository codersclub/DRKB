<h1>TStringGrid без выделенной ячейки</h1>
<div class="date">01.01.2007</div>

Автор: Jeff Fisher</p>
<p>Я пытаюсь показать StringGrid без выделенной ячейки. Первая нефиксированная ячейка всегда имеет состояние "инвертированного" цвета. Я не хочу позволить пользователю редактировать сетку, но эта выделенная ячейка производит впечатление того, что сетка имеет возможность редактирования...</p>
<p>Вам необходимо создать обработчик события OnDrawCell. Это легче чем вы думаете. Вот образец кода, который сделает вас счастливым:</p>
<pre>
procedure TForm.sgrDrawCells(Sender: TObject; Col, Row: Longint; Rect: TRect;
  State: TGridDrawState);
var
  ACol: longint absolute Col;
  ARow: longint absolute Row;
  Buf: array[byte] of char;
begin
  if State = gdFixed then
    Exit;
 
  with sgrGrid do
  begin
    Canvas.Font := Font;
    Canvas.Font.Color := clWindowText;
    Canvas.Brush.Color := clWindow;
 
    Canvas.FillRect(Rect);
    StrPCopy(Buf, Cells[ACol, ARow]);
    DrawText(Canvas.Handle, Buf, -1, Rect,
      DT_SINGLELINE or DT_VCENTER or DT_NOCLIP or DT_LEFT);
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
