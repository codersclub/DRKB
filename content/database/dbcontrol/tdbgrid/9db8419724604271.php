<h1>Кам при прокрутке зафиксировать левое поле сетки?</h1>
<div class="date">01.01.2007</div>


<pre>
unit Fcdgrid;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, Grids, DBGrids, DBCtrls, DB, Menus;
 
type
  TFixedColDBGrid = class(TDBGrid)
  private
    FUserFixedCols: Integer;
  protected
    procedure LayoutChanged; override;
    procedure SetUserFixedCols(I: Integer);
 
  published
    property UserFixedCols: Integer read FUserFixedCols write SetUserFixedCols;
  end;
 
procedure Register;
 
implementation
 
procedure Register;
begin
  RegisterComponents('Data Controls', [TFixedColDBGrid]);
end;
 
procedure TFixedColDBGrid.LayoutChanged;
begin
  inherited LayoutChanged; {   присваиваем FixedCols 1 если индикатор, иначе 0 }
  if ((inherited FixedCols + FUserFixedCols) &lt; inherited ColCount) then
    inherited FixedCols := (FUserFixedCols + inherited FixedCols);
end;
 
procedure TFixedColDBGrid.SetUserFixedCols(I: Integer);
begin
  FUserFixedCols := I;
  LayoutChanged;
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
