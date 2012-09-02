<h1>Как снять выделение в TStringGrid?</h1>
<div class="date">01.01.2007</div>


<p>Если Вы хотете избавиться от выделенных ячеек TStringGrid, которые не имеют фокуса либо используются только для отображения данных, то попробуйте воспользоваться следующей небольшой процедурой.</p>
<pre>
procedure TForm1.GridClean(Sender: TObject); 
var hGridRect: TGridRect; 
begin 
   hGridRect.Top := -1; 
   hGridRect.Left := -1; 
   hGridRect.Right := -1; 
   hGridRect.Bottom := -1; 
   (Sender as TStringgrid).Selection := hGridRect; 
end; 
</pre>

<p>Следующий код можно использовать например в событии грида OnExit:</p>
<pre>
var MyGrid: TStringGrid; 
... 
GridClean(MyGrid);
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

