---
Title: Как проверять корректность доступа к базе данных?
Date: 01.01.2007
---


Как проверять корректность доступа к базе данных?
=================================================

Следующая функция проверяет доступ к базе данных и выдает возможные
причины, если доступ не удается осуществить. Функция возвращает значение
True в случае успешной операции и False в противном случае.

    function TBDEDirect.CheckDatabase: Boolean;
    var DS: TDataSource;
    begin
      Result := False;
      DS := GetDataSource;
      if DS = nil then
        begin
          MessageDlg('Не установлена связь с элементом-источником данных.'+
            'Проверьте установку свойства DataSource.',
            mtError, [mbOK], 0);
          Exit;
        end;
      if DS.DataSet = nil then
        begin
          MessageDlg('Доступ к базе данных невозможен.', mtError,[mbOK], 0);
          Exit;
        end;
      if TDBDataSet(DS.DataSet).Database = nil then
        begin
          MessageDlg('Доступ к базе данных невозможен.', mtError,[mbOK], 0);
          Exit;
        end;
      if TDBDataSet(DS.DataSet).Database.Handle = nil then
        begin
          MessageDlg('Дескриптор (Handle) БД недоступен.', mtError,[mbOK], 0);
          Exit;
        end;
      if DS.DataSet.Handle = nil then
        begin
          MessageDlg('Дескриптор курсора (Cursor-Handle) недоступен.', mtError, mbOK], 0);
          Exit;
        end;
      Result := True;
    end;
