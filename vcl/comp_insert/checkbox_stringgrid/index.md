---
Title: Как добавить TCheckBox в TStringGrid?
Author: Joel E. Cant.
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как добавить TCheckBox в TStringGrid?
=====================================

Пример демонстрирует добавление любого количества чекбоксов в
StringGrid. В этом примере необходимо добавить TPanel, а в саму панель
включить TstringGrid. Так же необходимо добавить невидимый TcheckBox на
форму. Затем добавьте5 колонок и 4 строки в объект StringGrid.

    procedure TForm1.CheckBox1Click(Sender: TObject);
    begin
      ShowMessage('There it is!!');
    end;
     
    // Заполняем заголовок StringGrid
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     StringGrid1.Cells[0,0] := 'A Simple';
     StringGrid1.Cells[1,0] := 'Way';
     StringGrid1.Cells[2,0] := 'To';
     StringGrid1.Cells[3,0] := 'Do It';
     StringGrid1.Cells[4,0] := 'Check !!';
     AddCheckBoxes; // добавляем чекбоксы...
    end;
     
    procedure TForm1.AddCheckBoxes;
     var i: Integer;
         NewCheckBox: TCheckBox;
    begin
      clean_previus_buffer; // очищаем неиспользуемые чекбоксы...
      for i := 1 to 4 do
      begin
        StringGrid1.Cells[0,i] := 'a';
        StringGrid1.Cells[1,i] := 'b';
        StringGrid1.Cells[2,i] := 'c';
        StringGrid1.Cells[3,i] := 'd';
        NewCheckBox := TCheckBox.Create(Application);
        NewCheckBox.Width := 0;
        NewCheckBox.Visible := false;
        NewCheckBox.Caption := 'OK';
        NewCheckBox.Color := clWindow;
        NewCheckBox.Tag := i;
        NewCheckBox.OnClick := CheckBox1.OnClick; //Связываем предыдущее событие OnClick
                                                  // с существующим TCheckBox
        NewCheckBox.Parent := Panel1;
        StringGrid1.Objects[4,i] := NewCheckBox;
        StringGrid1.RowCount := i;
      end;
      set_checkbox_alignment; // расположение чекбоксов в ячейках таблицы...
    end;
     
    Procedure TForm1.clean_previus_buffer;
      var NewCheckBox: TCheckBox;
          i: Integer;
    begin
      for i := 1 to StringGrid1.RowCount do
        begin
        NewCheckBox := (StringGrid1.Objects[4,i] as TCheckBox);
        if NewCheckBox <> nil then
          begin
            NewCheckBox.Visible := false;
            StringGrid1.Objects[4,i] := nil;
          end;
        end;
    end;
     
    Procedure TForm1.set_checkbox_alignment;
      var NewCheckBox: TCheckBox;
          Rect: TRect;
          i: Integer;
    begin
      for i := 1 to StringGrid1.RowCount do
        begin
          NewCheckBox := (StringGrid1.Objects[4,i] as TCheckBox);
          if NewCheckBox <> nil then
            begin
              Rect := StringGrid1.CellRect(4,i); // получаем размер ячейки для чекбокса
              NewCheckBox.Left := StringGrid1.Left + Rect.Left+2;
              NewCheckBox.Top := StringGrid1.Top + Rect.Top+2;
              NewCheckBox.Width := Rect.Right - Rect.Left;
              NewCheckBox.Height := Rect.Bottom - Rect.Top;
              NewCheckBox.Visible := True;
            end;
        end;
    end;
     
    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
    Rect: TRect; State: TGridDrawState);
    begin
      if not (gdFixed in State) then set_checkbox_alignment;
    end;

