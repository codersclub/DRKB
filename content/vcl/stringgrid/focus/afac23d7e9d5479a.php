<h1>TStringGrid с фокусом (OnDrawCell)</h1>
<div class="date">01.01.2007</div>

Если вы создаете собственный обработчик компонента TStringGrid OnDrawCell, то вы можете нарисовать все, что вам заблагорассудится. Попробуйте, к примеру, это:</p>
<pre>procedure TForm1.DrawCell(Sender: TObject;
  Col: Longint;
  Row: Longint;
  Rect: TRect;
  State: TGridDrawState);
var
  lRow, lCol: LongInt;
  S: string;
begin
  lRow := Row;
  lCol := Col;
  with Sender as TStringGrid, Canvas do
  begin
    if (gdSelected in State) then
    begin
      Brush.Color := clHighlight; { *** }
    end
    else if (lRow &lt; FixedRows) or (lCol &lt; FixedCols) then
    begin
      Brush.Color := FixedColor;
    end
    else
    begin
      Brush.Color := Color;
    end;
    FillRect(Rect);
    SetBkMode(Handle, TRANSPARENT);
    TextOut(Rect.Left + 2, Rect.Top + 2, Cells[lCol, lRow]);
  end;
end;
</pre>
<p>Строка с комментарием { *** } в данном контексте ключевая. Она "сообщает" о том, что если мы рисуем ячейку, которая имеет фокус, то мы ее рисуем с применением цвета подсветки (highlight) (хотя вы бы могли здесь использовать любой другой нравящийся вам цвет), хотя никто нам специально о необходимости подкрашивания области сфокусированной ячейки и не говорил. Единственная проблема возникает со шрифтом, но в конечном счете я обнаружил, что она решается сама собой, если установить свойство компонента TStringGrid DefaultDrawing в TRUE (я потерял немало времени, решая проблему цвета шрифта со значением FALSE!). Попробуйте также поиграться с другими настройками цветов, может вам повезет и вы добъетесь неописуемой красоты компонента TStringGrid.</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
