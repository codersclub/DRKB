<h1>TDBGrid со свойствами Col и Row</h1>
<div class="date">01.01.2007</div>


<pre>
{
Код улучшенного TDBGrid, имеющего свойства Col,
Row и Canvas и метод CellRect. Это чрезвычайно
полезно в случае, если вы, к примеру, хотите
получить выпадающий список на месте редактируемой
пользователем ячейки.
}
 
unit VUBComps;
 
interface
 
uses
 
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, Grids, DBGrids, DB, Menus;
 
type
 
  TDBGridVUB = class(TDBGrid)
  private
    { Private declarations }
  protected
    { Protected declarations }
  public
    property Canvas;
    function CellRect(ACol, ARow: Longint): TRect;
    property Col;
    property Row;
 
    procedure Register;
 
implementation
 
procedure Register;
begin
 
  RegisterComponents('VUBudget', [TDBGridVUB]);
end;
 
function TDBGridVUB.CellRect(ACol, ARow: Longint): TRect;
begin
 
  Result := inherited CellRect(ACol, ARow);
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
