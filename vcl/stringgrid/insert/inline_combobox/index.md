---
Title: Встроенный редактор TComboBox в ячейке TStringGrid
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Встроенный редактор TComboBox в ячейке TStringGrid
==================================================

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {Высоту combobox'а не изменишь, так что вместо combobox'а
      будем изменять высоту строки grid'а !}
      StringGrid1.DefaultRowHeight := ComboBox1.Height; {Спрятать combobox}
      ComboBox1.Visible := False; ComboBox1.Items.Add('Delphi Kingdom');
      ComboBox1.Items.Add('Королевство Дельфи');
    end;
     
    procedure TForm1.ComboBox1Change(Sender: TObject);
    begin
      {Перебросим выбранное в значение из ComboBox в grid}
      StringGrid1.Cells[StringGrid1.Col,
      StringGrid1.Row] := ComboBox1.Items[ComboBox1.ItemIndex];
      ComboBox1.Visible := False; StringGrid1.SetFocus;
    end;
     
    procedure TForm1.ComboBox1Exit(Sender: TObject);
    begin
      {Перебросим выбранное в значение из ComboBox в grid}
      StringGrid1.Cells[StringGrid1.Col,
      StringGrid1.Row] := ComboBox1.Items[ComboBox1.ItemIndex];
      ComboBox1.Visible := False; StringGrid1.SetFocus;
    end;
     
    procedure TForm1.StringGrid1SelectCell(Sender: TObject; ACol,
    ARow: Integer; var CanSelect: Boolean);
    var
      R: TRect;
    begin
      if ((ACol = 3) and (ARow <> 0)) then
      begin
        {Ширина и положение ComboBox должно соответствовать ячейке StringGrid}
        R := StringGrid1.CellRect(ACol, ARow); R.Left := R.Left + StringGrid1.Left;
        R.Right := R.Right + StringGrid1.Left; R.Top := R.Top + StringGrid1.Top;
        R.Bottom := R.Bottom + StringGrid1.Top; ComboBox1.Left := R.Left + 1;
        ComboBox1.Top := R.Top + 1; ComboBox1.Width := (R.Right + 1) - R.Left;
        ComboBox1.Height := (R.Bottom + 1) - R.Top; {Покажем combobox}
        ComboBox1.Visible := True; ComboBox1.SetFocus;
      end;
      CanSelect := True;
    end;

