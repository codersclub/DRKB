<h1>Область данных диаграммы</h1>
<div class="date">01.01.2007</div>

<p>Область данных диаграммы</p>
Данные для построения диаграммы должны быть расположены на любом листе рабочей книги и представлять собой прямоугольную область. Для определения рабочей области данных используется метод SetSourceData, первый аргумент которого - ссылка на лист и область ячеек, второй - определяет способ использования данных (по строкам/столбцам).</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function SetSourceData(Name,Sheet:variant;
  Range:string;XlRowCol:integer):boolean;
begin
 SetSourceData:=true;
 try
  E.ActiveWorkbook.Charts.Item[name].SetSourceData
 &nbsp; (Source:=E.ActiveWorkbook.Sheets.Item [Sheet].Range[Range],PlotBy:=XlRowCol);
 except
  SetSourceData:=false;
 end;
End;
</pre>
&nbsp;</p>

