---
Title: Как передвинуть колонку в TDBGrid?
Date: 01.01.2007
---


Как передвинуть колонку в TDBGrid?
==================================

::: {.date}
01.01.2007
:::

    type
      THackAccess = class(TCustomGrid);
     
    {
      THackAccess Is needed because TCustomGrid.MoveColumn is
      protected and you can't access it directly.
    }
     
    // In the implementation-Section:
     
    procedure MoveDBGridColumns(DBGrid: TDBGrid; FromColumn, ToColumn: Integer);
    begin
      THackAccess(DBGrid).MoveColumn(FromColumn, ToColumn);
    end;
     
     
    {Example}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      MoveDBGridColumns(DBGrid1, 1, 2)
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
