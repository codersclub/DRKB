---
Title: Как поймать свой RAISEERROR в Delphi
Author: Nomadic
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как поймать свой RAISEERROR в Delphi
====================================

    procedure TFDMUtils.GeneralError(DataSet: TDataSet; E: EDatabaseError; var
      Action: TDataAction);
    var
      i: Word;
      ExtInfo: string;
    begin
      ExtInfo := '';
     
      if (E is EDBEngineError) then
      begin
        if (EDBEngineError(E).Errors[0].NativeError = 0) then
        begin // Local Error
          if EDBEngineError(E).Errors[0].Errorcode = 9732 then
            ExtInfo := DataSet.FieldByName(trim(copy(E.Message, 29,
              20))).DisplayLabel;
          .......................................
        end
        else
        begin // Remote SQL Server error
          ExtInfo := ExtractFieldLabels(DataSet, E.Message);
          case EDBEngineError(E).Errors[0].NativeError of
            233, 515:
              Alert('Ошибка', 'Hе все поля заполнены ! ' + ExtInfo);
            547:
              if (StrPos(PChar(E.Message), PChar('DELETE')) <> nil) then
                Alert('Ошибка пpи удалении',
                  'Имеются подчиненные записи, удаление (изменение) невозможно! ' +
                  ExtInfo)
              else if (StrPos(PChar(E.Message), PChar('INSERT')) <> nil) then
                Alert('Ошибка пpи вставке', 'Отсутствует запись в МАСТЕР-таблице! '
                  + ExtInfo)
              else if (StrPos(PChar(E.Message), PChar('UPDATE')) <> nil) then
                Alert('Ошибка пpи обновлении',
                  'Отсутствует запись в МАСТЕР-таблице! ' + ExtInfo);
            2601:
              Alert('Ошибка', 'Такая запись уже есть!');
          else
            Alert('Ошибка', 'Hеизвестная ошибка, код - ' +
              inttostr(EDBEngineError(E).Errors[0].NativeError) + ExtInfo);
          end;
        end;
      end;
    end;

