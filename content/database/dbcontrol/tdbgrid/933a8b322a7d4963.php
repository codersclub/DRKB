<h1>TDBGrid с номером строки</h1>
<div class="date">01.01.2007</div>


<pre>
unit RowGrid;
 
interface
 
uses
  WinTypes, WinProcs, Classes, Grids, DBGrids;
 
type
  TRowDBGrid = class(TDBGrid)
  public
    property Row;
    property RowCount;
    property VisibleRowCount;
  end;
 
procedure Register;
 
implementation
 
procedure Register;
begin
  RegisterComponents('Data Controls', [TRowDBGrid]);
end;
 
end.
 
 
 
{вот небольшой испытательный демо-проект.. мы
поместили на форму нашу сетку-наследницу, 3 компонента
EditBox и поместили следующий код в обработчик события
ondrawdatacell вашего TRowGrid}
procedure TForm1.RowDBGrid1DrawDataCell(Sender: TObject; const Rect:
  TRect; Field: TField; State: TGridDrawState);
begin
  eb_row.text := inttostr(rowdbgrid1.row);
  eb_rowcount.text := inttostr(rowdbgrid1.rowcount);
  eb_visiblerowcount.text := inttostr(rowdbgrid1.visiblerowcount);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

