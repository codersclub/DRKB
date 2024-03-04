---
Title: Как экспортировать таблицу базы данных в ASCII-файл?
Date: 01.01.2007
---


Как экспортировать таблицу базы данных в ASCII-файл?
====================================================

    procedure TMyTable.ExportToASCII;
     
    var
      I: Integer;
      Dlg: TSaveDialog;
      ASCIIFile: TextFile;
      Res: Boolean;
     
    begin
      if Active then
        if (FieldCount > 0) and (RecordCount > 0) then
          begin
            Dlg := TSaveDialog.Create(Application);
            Dlg.FileName := FASCIIFileName;
            Dlg.Filter := 'ASCII-Fiels (*.asc)|*.asc';
            Dlg.Options := Dlg.Options+[ofPathMustExist, 
              ofOverwritePrompt, ofHideReadOnly];
            Dlg.Title := 'Экспоритровать данные в ASCII-файл';
            try
              Res := Dlg.Execute;
              if Res then
                FASCIIFileName := Dlg.FileName;
            finally
              Dlg.Free;
            end;
            if Res then
              begin
                AssignFile(ASCIIFile, FASCIIFileName);
                Rewrite(ASCIIFile);
                First;
                if FASCIIFieldNames then
                  begin
                    for I := 0 to FieldCount-1 do
                      begin
                        Write(ASCIIFile, Fields[I].FieldName);
                        if I <> FieldCount-1 then
                          Write(ASCIIFile, FASCIISeparator);
                      end;
                    Write(ASCIIFile, #13#10);
                  end;
                while not EOF do
                  begin
                    for I := 0 to FieldCount-1 do
                      begin
                        Write(ASCIIFile, Fields[I].Text);
                        if I <> FieldCount-1 then
                          Write(ASCIIFile, FASCIISeparator);
                      end;
                    Next;
                    if not EOF then
                      Write(ASCIIFile, #13#10);
                  end;
                CloseFile(ASCIIFile);
                if IOResult <> 0 then
                  MessageDlg('Ошибка при создании или переписывании '+
                    'в ASCII-файл', mtError, [mbOK], 0);
              end;
          end
        else
          MessageDlg('Нет данных для экспортирования.',
            mtInformation, [mbOK], 0)
      else
        MessageDlg('Таблица должна быть открытой, чтобы данные '+
          'можно было экспортировать в ASCII-формат.', mtError,
          [mbOK], 0);
      end;
