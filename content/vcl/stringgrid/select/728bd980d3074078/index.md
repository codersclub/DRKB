---
Title: TStringGrid без выделенной ячейки
Author: Jeff Fisher
Date: 01.01.2007
---


TStringGrid без выделенной ячейки
=================================

::: {.date}
01.01.2007
:::

Автор: Jeff Fisher

Я пытаюсь показать StringGrid без выделенной ячейки. Первая
нефиксированная ячейка всегда имеет состояние \"инвертированного\"
цвета. Я не хочу позволить пользователю редактировать сетку, но эта
выделенная ячейка производит впечатление того, что сетка имеет
возможность редактирования\...

Вам необходимо создать обработчик события OnDrawCell. Это легче чем вы
думаете. Вот образец кода, который сделает вас счастливым:

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
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
