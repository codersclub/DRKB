---
Title: Идея стандартизации элементов клиента базы данных
Author: Пенов Сергей, spenov@narod.ru
Date: 07.05.2002
---


Идея стандартизации элементов клиента базы данных
=================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Идея стандартизации элементов клиента базы данных.
     
    Компонент доступа к данным,потомок TADOStoredProc.
    Предназначен для написания клиента для MS SQL Server 2000 (можно использовать и
    для более ранних версий, но придется поработать над шаблоном хранимой
    процедуры).
    Позволяет управлять операциями добавления, редактирования и
    удаления (и некоторыми другими)на клиенте со стороны сервера однообразно для
    всех данных. Тем самым достигается некоторая стандартизация клиента и при
    изменении серверной части не придется изменять клиента(конечно же в разумных
    пределах).
    Для большей красоты не помешает создать некоторые другие прибамбасы, например,
    форму, исходную для всех форм проекта.
    Но это уже не относится к данному разделу.
     
    Зависимости: Windows, Messages, SysUtils, Classes, DB, ADODB
    Автор:       Пенов Сергей, spenov@narod.ru, ICQ:122597033, Москва
    Copyright:   Пенов Сергей
    Дата:        07 мая 2002 г.
    ***************************************************** }
     
    //Шаблон хранимой процедуры
    {
    CREATE PROCEDURE [upTemplateProcedure]
       @KeyValue INT = NULL -- требуется для обновления измененной записи в клиенте.
    AS
    -- Data (Требуемая информация)
    SELECT ColumnList
      FROM TheTable
      WHERE @KeyValue IS NULL OR TheKey=@KeyValue -- возвращаем либо все(операция
    открытия), либо конкретную запись (операция обновления)
     
    IF @KeyValue IS NULL BEGIN -- если операция открытия, то возвращаем необходимую
    дополнительную информацию для настройки клиента
       -- Properties -- динамические свойства TADOStoredProc, список формируется
    таким образом. В большинстве случаев изменять его не приходится.
       SELECT 'Property'='Unique Table', 'Value'='TheTable' UNION
       SELECT 'Property'='Resync Command', 'Value'='EXEC upTemplateProcedure ?'
       -- !!! команда обновления измененной записи !!!
       -- Table Operations
          -- Здесь формируется набор данных, возвращающий какие операции может
    совершать текущий пользователь с этими данными. Это, естественно, простейший
    пример и возможно под конкретную ситуацию его надо будет изменить (запрос)
       SELECT DISTINCT PRIVILEGE_TYPE AS [Operation], 1 AS [Value] -- 1 - можно, 0
    (или нет записи) - нельзя. Operation = INSERT,UPDATE,DELETE
         FROM INFORMATION_SCHEMA.TABLE_PRIVILEGES
         WHERE TABLE_NAME = 'TheTable'
       -- Columns Operations -- возможность редактирования столбцов пользователем
       SELECT DISTINCT COLUMN_NAME AS [Column], 0 AS [ReadOnly] 0 - может
    редактировать, 1 ( или нет записи) - не может.
         FROM INFORMATION_SCHEMA.COLUMN_PRIVILEGES
         WHERE TABLE_NAME = 'TheTable'
           AND PRIVILEGE_TYPE = 'UPDATE'
     
       -- Далее можно добавлять свои дополнительные данные для более детальной
    настройки клиета. В клиенте к ним доступ через свойство
    TADOApostrofStoredProc .Recordsets.
     
    END
    }
     
    unit Un_TApostrofStoredProc;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, DB, ADODB;
     
    type
      TADOApostrofStoredProc = class(TADOStoredProc)
      private
        FCanINSERT: Boolean;
        FCanUPDATE: Boolean;
        FCanDELETE: Boolean;
        FRecordsets: TInterfaceList;
        FOpenTime: TDateTime;
        function GetRecordset(I: Integer): _Recordset;
        function GetRecordsetCount: Integer;
      protected
        procedure DoBeforeOpen; override;
        procedure DoBeforeClose; override;
        procedure DoAfterOpen; override;
        procedure OpenCursor(InfoQuery: Boolean = False); override;
        procedure SetFieldData(Field: TField; Buffer: Pointer; NativeFormat:
          Boolean); override;
      public
        constructor Create(AOwner: TComponent); override;
        property CanINSERT: Boolean read FCanINSERT;
        property CanUPDATE: Boolean read FCanUPDATE;
        property CanDELETE: Boolean read FCanDELETE;
        property Recordsets[I: Integer]: _Recordset read
        GetRecordset; //Дополнительные наборы данных, возвращенные хранимой процедурой
        property RecordsetCount: Integer read GetRecordsetCount;
        property OpenTime: TDateTime read FOpenTime write FOpenTime; //Время
        открытия процедуры.
      end;
     
    procedure Register;
     
    implementation
     
    uses
      ADOint, DBConsts;
     
    procedure Register;
    begin
      RegisterComponents('ADOApostrof', [TADOApostrofStoredProc]);
    end;
     
    function TADOApostrofStoredProc.GetRecordset(I: Integer): _Recordset;
    begin
      Result := _Recordset(FRecordsets[I]);
    end;
     
    function TADOApostrofStoredProc.GetRecordsetCount: Integer;
    begin
      Result := FRecordsets.Count;
    end;
     
    constructor TADOApostrofStoredProc.Create(AOwner: TComponent);
    begin
      inherited;
      FRecordsets := TInterfaceList.Create;
    end;
     
    procedure TADOApostrofStoredProc.DoBeforeOpen;
    begin
      FCanINSERT := False;
      FCanUPDATE := False;
      FCanDELETE := False;
      inherited;
    end;
     
    procedure TADOApostrofStoredProc.DoBeforeClose;
    begin
      inherited;
      FRecordsets.Clear;
    end;
     
    procedure TADOApostrofStoredProc.DoAfterOpen;
    var
      R: _Recordset;
      RecordsAffected, I: Integer;
    begin
      //Все столбцы в ReadOnly!
      for I := 0 to Fields.Count - 1 do
        Fields[I].ReadOnly := True;
      //Установка некоторых свойств
      Properties['Update Criteria'].Value := adCriteriaKey;
      Properties['Update Resync'].Value := adResyncAll;
      //Свойства из базы
      R := NextRecordset(RecordsAffected);
      while Assigned(R) do
      begin
        FRecordsets.Add(R);
        if (R.Fields.Count = 2) and (UpperCase(R.Fields[0].Name) = 'PROPERTY') and
          (UpperCase(R.Fields[1].Name) = 'VALUE') then
        begin //Properties
          if R.RecordCount > 0 then
          begin
            R.MoveFirst;
            while not R.EOF do
            begin
              Properties[R.Fields[0].Value].Value := R.Fields[1].Value;
              R.MoveNext;
            end;
          end;
        end
        else if (R.Fields.Count = 2) and (UpperCase(R.Fields[0].Name) = 'OPERATION')
          and (UpperCase(R.Fields[1].Name) = 'VALUE') then
        begin //Операции над таблицей
          if R.RecordCount > 0 then
          begin
            R.MoveFirst;
            while not R.EOF do
            begin
              if R.Fields[0].Value = 'INSERT' then
                FCanINSERT := (R.Fields[1].Value = 1)
              else if R.Fields[0].Value = 'UPDATE' then
                FCanUPDATE := (R.Fields[1].Value = 1)
              else if R.Fields[0].Value = 'DELETE' then
                FCanDELETE := (R.Fields[1].Value = 1);
              R.MoveNext;
            end;
          end;
        end
        else if (R.Fields.Count = 2) and (UpperCase(R.Fields[0].Name) = 'COLUMN')
          and (UpperCase(R.Fields[1].Name) = 'READONLY') then
        begin //Операции над столбцами
          if R.RecordCount > 0 then
          begin
            R.MoveFirst;
            while not R.EOF do
            begin
              if Assigned(FindField(R.Fields[0].Value)) then
                FieldByName(R.Fields[0].Value).ReadOnly := (R.Fields
                  [1].Value = 1);
              R.MoveNext;
            end;
          end;
        end;
        R := NextRecordset(RecordsAffected);
      end;
      inherited;
    end;
     
    procedure TADOApostrofStoredProc.SetFieldData(Field: TField; Buffer: Pointer;
      NativeFormat: Boolean);
    var
      Buf: Boolean;
    begin
      Buf := Field.ReadOnly;
      Field.ReadOnly := Field.ReadOnly and (State <> dsInsert);
      try
        inherited;
      finally
        Field.ReadOnly := Buf;
      end;
    end;
     
    procedure TADOApostrofStoredProc.OpenCursor(InfoQuery: Boolean);
    var
      TheTime: TDateTime;
    begin
      TheTime := Time;
      inherited;
      FOpenTime := Time - TheTime;
    end;
     
    end.
