<h1>Назначение цвета для каждой строки</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TFormHistory.ListHistoryDrawCell(Sender: TObject; Col, Row: Integer;
          Rect: TRect; State: TGridDrawState);
var
  S: string;
  DrawRect: TRect;
  CurrentColor: TColor;
begin
  // Определяем цвет строки в зависимости типа Imcoming
  if (Sender as TStrinGgrid).Cells[COLUMN_INCOMING , Row ] = '1' then
    CurrentColor:=clBlue
  else
    CurrentColor:=clMaroon;
 
  if (Sender as TStrinGgrid).Row = Row then
    CurrentColor := clHighlightText;
 
  (Sender as TStrinGgrid).Canvas.font.color := CurrentColor;
  S:= (Sender as TStrinGgrid).Cells[ Col, Row ];
  if (Col = COLUMN_MESSAGE ) and (Row &lt;&gt; ROW_HEADER) then
  begin
    if Length(S) &gt; 0 then
    begin
      DrawRect:=Rect;
      DrawText((Sender as TStrinGgrid).Canvas.Handle, Pchar(S), Length(S),
      DrawRect, dt_calcrect or dt_wordbreak or dt_left );
      if (DrawRect.bottom - DrawRect.top) &gt; (Sender as TStrinGgrid).RowHeights[Row] then
        (Sender as TStrinGgrid).RowHeights[row] :=(DrawRect.bottom - DrawRect.top)
      else
      begin
        DrawRect.Right:=Rect.Right;
        (Sender as TStrinGgrid).Canvas.FillRect( DrawRect );
        DrawText((Sender as TStrinGgrid).Canvas.Handle, Pchar(S),
                  Length(S), DrawRect, dt_wordbreak or dt_left);
      end;
    end;
  end
  else
    if Row &lt;&gt; ROW_HEADER then
      (Sender as TStrinGgrid).Canvas.Textout(rect.left+3, rect.top+3 , S );
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
