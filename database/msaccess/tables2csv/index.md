---
Title: Как экспортировать все таблицы в CSV файл?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как экспортировать все таблицы в CSV файл?
==========================================

    procedure TMainForm.SaveAllTablesToCSV(DBFileName: string);
    var
      InfoStr,
        FileName,
        RecString,
        WorkingDirectory: string;
      OutFileList,
        TableNameList: TStringList;
      TableNum,
        FieldNum: integer;
      VT: TVarType;
    begin
      ADOTable1.Active := false;
      WorkingDirectory := ExtractFileDir(DBFileName);
      TableNameList := TStringList.Create;
      OutFileList := TStringList.Create;
      InfoStr := 'The following files were created' + #13#13;
     
      ADOConnection1.GetTableNames(TableNameList, false);
      for TableNum := 0 to TableNameList.Count - 1 do
      begin
        FileName := WorkingDirectory + '\' +
          TableNameList.Strings[TableNum] + '.CSV';
        Caption := 'Saving "' + ExtractFileName(FileName) + '"';
        ADOTable1.TableName := TableNameList.Strings[TableNum];
        ADOTable1.Active := true;
        OutFileList.Clear;
     
        ADOTable1.First;
        while not ADOTable1.Eof do
        begin
     
          RecString := '';
          for FieldNum := 0 to ADOTable1.FieldCount - 1 do
          begin
            VT := VarType(ADOTable1.Fields[FieldNum].Value);
            case VT of
              // just write the field if not a string
              vtInteger, vtExtended, vtCurrency, vtInt64:
                RecString := RecString + ADOTable1.Fields[FieldNum].AsString
            else
              // it IS a string so put quotes around it
              RecString := RecString + '"' +
                ADOTable1.Fields[FieldNum].AsString + '"';
            end; { case }
     
            // if not the last field then use a field separator
            if FieldNum < (ADOTable1.FieldCount - 1) then
              RecString := RecString + ',';
          end; { for FieldNum }
          OutFileList.Add(RecString);
     
          ADOTable1.Next;
        end; { while }
     
        OutFileList.SaveToFile(FileName);
        InfoStr := InfoStr + FileName + #13;
        ADOTable1.Active := false;
     
      end; { for  TableNum }
      TableNameList.Free;
      OutFileList.Free;
      Caption := 'Done';
      ShowMessage(InfoStr);
    end;
     
    procedure TMainForm.Button1Click(Sender: TObject);
    const
      ConnStrA = 'Provider=Microsoft.Jet.OLEDB.4.0;Data Source=';
      ConnStrC = ';Persist Security Info=False';
      ProvStr = 'Microsoft.Jet.OLEDB.4.0';
    begin
      OpenDialog1.InitialDir := ExtractFileDir(ParamStr(0));
      if OpenDialog1.Execute then
     
      try
        ADOConnection1.ConnectionString :=
          ConnStrA + OpenDialog1.FileName + ConnStrC;
        ADOConnection1.Provider := ProvStr;
        ADOConnection1.Connected := true;
        ADOTable1.Connection := ADOConnection1;
        SaveAllTablesToCSV(OpenDialog1.FileName);
      except
        ShowMessage('Could not Connect to ' + #13 +
          '"' + OpenDialog1.FileName + '"');
        Close;
      end;
     
    end;

