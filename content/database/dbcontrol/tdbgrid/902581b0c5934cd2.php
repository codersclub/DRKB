<h1>TDBGrid.DefaultDrawDataCell</h1>
<div class="date">01.01.2007</div>


<p>TDBGrid имеет недокументированный в электронной справке метод DefaultDrawDataCell. </p>
<p>Вот пример его использования:</p>
<pre>
procedure TForm1.DBGrid1DrawDataCell(Sender: TObject;
const Rect: TRect; Field: TField; State: TGridDrawState);
begin
  with Sender as TDBGrid do
  begin
    Canvas.Font.Color := clRed;
    DefaultDrawDataCell(Rect, Field, State);
  end;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
