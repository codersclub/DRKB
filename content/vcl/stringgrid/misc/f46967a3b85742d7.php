<h1>TStringGrid, печать в ячейку</h1>
<div class="date">01.01.2007</div>


<pre>unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Grids;
 
type
  TForm1 = class(TForm)
    StringGrid: TStringGrid;
    procedure FormCreate(Sender: TObject);
    procedure StringGridDrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.FormCreate(Sender: TObject);
var
  C, R: Integer;
begin
  for C := 0 to StringGrid.ColCount - 1 do
    for R := 0 to StringGrid.RowCount - 1 do
      StringGrid.Cells[C, R] := 'A very very very long string';
end;
 
procedure TForm1.StringGridDrawCell(Sender: TObject; ACol, ARow: Integer;
  Rect: TRect; State: TGridDrawState);
begin
  if not (Sender is TStringGrid) then Exit;
 
  with TStringGrid(Sender) do
  begin
    Canvas.FillRect(Rect);
    DrawText(Canvas.Handle, PChar(Cells[ACol, ARow]), -1, Rect, DT_WORDBREAK);
  end;
end;
 
end.
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Smike</div>

