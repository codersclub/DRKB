<h1>Цвет неактивной ячейки TStringGrid</h1>
<div class="date">01.01.2007</div>

Автор: Neil J. Rubenking </p>
<p>...если я щелкаю на любой ячейке StringGrid2, последняя выбранная ячейка в StringGrid1 становится синей...</p>
<p>Создайте обработчик (если он отсутствует) события сетки OnDrawCell и включите в него следующий код:</p>
<pre>procedure TForm1.StringGrid3DrawCell(Sender: TObject; vCol,
  vRow: Longint; Rect: TRect; State: TGridDrawState);
begin
  if Sender = ActiveControl then
    Exit;
  if not (gdSelected in State) then
    Exit;
  with Sender as TStringGrid do
  begin
    Canvas.Brush.Color := Color;
    Canvas.Font.Color := Font.Color;
    Canvas.TextRect(Rect, Rect.Left + 2, Rect.Top + 2,
      Cells[vCol, vRow]);
  end;
end;
</pre>
<p>Имейте в виду, что в обработчике события OnDrawCell я переименовал параметры Col и Row на vCol и vRow, чтобы избежать путаницы со свойствами StringGrid, имеющими те же имена. Данный метод выполняется немедленно после того, как сетка становится неактивной, и после того как запрошенная ячейка становится НЕвыбранной. В любом из этих случаев вы должны нарисовать невыбранную ячейку для НЕАКТИВНОЙ сетки - т.е. в тех случаях, когда у вас получается "неправильный" цвет. Вы просто берете работу Delphi по закрашиванию ячеек на себя, пропуская defaultDrawing (отрисовку по умолчанию), для таких ячеек, но в то же время разрешая Delphi поработать за вас во всех остальных случаях.</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
