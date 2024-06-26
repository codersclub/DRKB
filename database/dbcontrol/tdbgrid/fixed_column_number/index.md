---
Title: Как изменить число фиксированных колонок в TDBGrid?
Date: 01.01.2007
---


Как изменить число фиксированных колонок в TDBGrid?
===================================================

Вариант 1.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TStringGrid(DbGrid1).FixedCols := 2;
    end;

Source: <https://forum.sources.ru>

------------------------------------------------------------------------

Вариант 2.

Это маленькая вставка в Ваш наследник от TCustomDBGrid, которая решает
данную задачу.

    // DBGRIDEX.PAS
    // ----------------------------------------------------------------------------
     
    destructor TDbGridEx.Destroy;
    begin
     
      _HideColumnsValues.Free;
      _HideColumns.Free;
     
      inherited Destroy;
    end;
     
    // ----------------------------------------------------------------------------
     
    constructor TDbGridEx.Create(Component: TComponent);
    begin
     
      inherited Create(Component);
     
      FFreezeCols := ?;
     
      _HideColumnsValues := TList.Create;
      _HideColumns := TList.Create;
    end;
     
    // ----------------------------------------------------------------------------
     
    procedure TDbGridEx.KeyDown(var Key: Word; Shift: TShiftState);
    begin
     
      if (Key = VK_LEFT) then
        ColBeforeEnter(-1);
      if (Key = VK_RIGHT) then
        ColBeforeEnter(1);
     
      inherited;
    end;
     
    // ----------------------------------------------------------------------------
     
    procedure TDbGridEx.SetFreezeColor(AColor: TColor);
    begin
     
      InvalidateRow(0);
    end;
     
    // ----------------------------------------------------------------------------
     
    procedure TDbGridEx.SetFreezeCols(AFreezeCols: Integer);
    begin
     
      FFreezeCols := AFreezeCols;
      InvalidateRow(0);
    end;
     
    // ----------------------------------------------------------------------------
     
    procedure TDbGridEx.ColEnter;
    begin
     
      ColBeforeEnter(0);
     
      if Assigned(OnColEnter) then
        OnColEnter(Self);
    end;
     
    // ----------------------------------------------------------------------------
     
    procedure TDbGridEx.ColBeforeEnter(ADelta: Integer);
    var
     
      nIndex: Integer;
     
      function ReadWidth: Integer;
      var
     
        i: Integer;
     
      begin
     
        i := _HideColumns.IndexOf(Columns[nIndex]);
     
        if i = -1 then
          result := 120
        else
          result := Integer(_HideColumnsValues[i]);
      end;
     
      procedure SaveWidth;
      var
     
        i: Integer;
     
      begin
     
        i := _HideColumns.IndexOf(Columns[nIndex]);
        if i <> -1 then
        begin
          _HideColumnsValues[i] := Pointer(Columns[nIndex].Width);
        end
        else
        begin
          _HideColumns.Add(Columns[nIndex]);
          _HideColumnsValues.Add(Pointer(Columns[nIndex].Width));
        end;
      end;
     
    begin
     
      for nIndex := 0 to Columns.Count - 1 do
      begin
        if (Columns[nIndex].Width = 0) then
        begin
          if (nIndex + 1 <= FreezeCols) or (nIndex >= SelectedIndex + ADelta) then
            Columns[nIndex].Width := ReadWidth;
        end
        else
        begin
          SaveWidth;
          if (nIndex + 1 > FreezeCols) and
            (nIndex < SelectedIndex + ADelta) and
            (nIndex + 1 < Columns.Count) and
            (FreezeCols > 0) then
            Columns[nIndex].Width := 0;
        end;
      end;
    end;

Source: <https://delphiworld.narod.ru>
