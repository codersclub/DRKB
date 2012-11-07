<h1>Увеличение ячейки TStringGrid при увеличении числа строк</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Пётр Соболь</div>

<pre>procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow:
  Integer; Rect: TRect; State: TGridDrawState);
var
  Format: Word;
  C: array[0..255] of Char;
  r: integer;
begin
  C := '';
  Format := DT_LEFT or DT_WORDBREAK;
  (Sender as TStringGrid).Canvas.FillRect(Rect);
  StrPCopy(C, (Sender as TStringGrid).Cells[ACol, ARow]);
  if c &lt;&gt; '' then //если есть значения
  begin
    r := WinProcs.DrawText((Sender as TStringGrid).Canvas.Handle, C,
      StrLen(C), Rect, Format);
    if r &gt; (Sender as TStringGrid).RowHeights[Arow] then
      //если высота колонки меньше
      (Sender as TStringGrid).RowHeights[Arow] := r;
  end;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
