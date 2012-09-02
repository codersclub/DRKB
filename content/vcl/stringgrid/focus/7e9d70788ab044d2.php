<h1>Фокус ячейки TStringGrid</h1>
<div class="date">01.01.2007</div>

Автор: Simon </p>
<pre>
procedure SetGridFocus(SGrid: TStringGrid; r, c: integer);
var
  SRect: TGridRect;
begin
  with SGrid do
  begin
    SetFocus; {Передаем фокус сетке}
    Row := r; {Устанавливаем Row/Col}
    Col := c;
    SRect.Top := r; {Определяем выбранную область}
    SRect.Left := c;
    SRect.Bottom := r;
    SRect.Right := c;
    Selection := SRect; {Устанавливаем выбор}
  end;
end;
 
 
 
//Для вызова процедуры:
 
 
SetGridFocus(StringGrid1, 10, 2);
</pre>
<p>Это всегда срабатывает в случае, если никакая ячейка не выбрана или фокус имеет другой элемент управления. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
