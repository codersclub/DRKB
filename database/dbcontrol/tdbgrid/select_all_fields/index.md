---
Title: Выделить все поля в TDBGrid?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Выделить все поля в TDBGrid?
============================

    function GridSelectAll(Grid: TDBGrid): Longint;
    begin
      Result := 0;
      Grid.SelectedRows.Clear;
      with Grid.DataSource.DataSet do
      begin
        First;
        DisableControls;
        try
          while not EOF do
          begin
            Grid.SelectedRows.CurrentRowSelected := True;
            Inc(Result);
            Next;
          end;
        finally
          EnableControls;
        end;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      GridSelectAll(DBGrid1);
    end;

