---
Title: Модуль, содержащий несколько удобств для работы с MS SQL посредством ADO
author: Delirium, Master_BRAIN@beep.ru
Date: 30.04.2002
---


Модуль, содержащий несколько удобств для работы с MS SQL посредством ADO
========================================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Модуль, содержащий несколько удобств для работы с MSSQL посредством ADO
     
    Зависимости: Windows, Classes, SysUtils, ADODB, ADOInt, ActiveX, Controls, Variants, ComObj
    Автор:       Delirium, Master_BRAIN@beep.ru, ICQ:118395746, Москва
    Copyright:   Delirium
    Дата:        30 апреля 2002 г.
    ***************************************************** }
     
    unit ThADO;
     
    interface
     
    uses Windows, Classes, SysUtils, ADODB, ADOInt, ActiveX, Controls, Variants,
      ComObj;
     
    type
      // Процедура для передачи событий
      TThreadADOQueryOnAfterWork = procedure(AHandle: THandle; RecordSet:
        _RecordSet; Active: Boolean) of object;
      // Вспомогательный класс
      TThADOQuery = class(TThread)
      private
        ADOQuery: TADOQuery;
        FAfterWork: TThreadADOQueryOnAfterWork;
     
      protected
        procedure DoWork;
        procedure Execute; override;
     
      public
        constructor Create;
     
      published
        property OnAfterWork: TThreadADOQueryOnAfterWork read FAfterWork write
          FAfterWork;
      end;
      // Класс для асинхронного получения информации посредством ADO
      TThreadADOQuery = class(TObject)
      private
        FAfterWork: TThreadADOQueryOnAfterWork;
        FActive: Boolean;
        FQuery: TThADOQuery;
        FHandle: THandle;
     
      protected
        procedure AfterWork(AHandle: THandle; RecordSet: _RecordSet; Active:
          Boolean);
     
      public
        constructor Create(aConnectionString: string);
     
        // Запустить запрос на исполнение
        // (если Batch=True - LockType=ltBatchOptimistic)
        procedure StartWork(aSQL: string; Batch: boolean = False);
        // Приостановить / продолжить исполнение запроса (True - если "на паузе")
        function PauseWork: boolean;
        // Остановить исполнение запроса (возможны потери памяти)
        procedure StopWork;
     
      published
        property Active: Boolean read FActive;
        property Handle: THandle read FHandle;
        property OnAfterWork: TThreadADOQueryOnAfterWork read FAfterWork write
          FAfterWork;
      end;
     
      // Интеграция рекордсета во временую или постоянную таблицу для MSSQL
    function RecordSetToTempTableForMSSQL(Connection: TADOConnection; RecordSet:
      _RecordSet; TableName: string): boolean;
    // Сохранение рекордсета в файл формата DBF, для организации локальной БД
    function RecordSetToDBF(RecordSet: _RecordSet; FileName: string): boolean;
    // "Физическое" клонирование рекордсетов
    function CopyRecordSet(RecordSet: _RecordSet): _RecordSet;
    //Функция, генерирует уникальное имя для таблиц (или файлов)
    function UniqueTableName: string;
     
    implementation
     
    var
      FConnectionString, FSQL: string;
      FBatch: boolean;
     
    constructor TThADOQuery.Create;
    begin
      inherited Create(True);
      FreeOnTerminate := True;
    end;
     
    procedure TThADOQuery.Execute;
    begin
      CoInitializeEx(nil, COINIT_MULTITHREADED);
      // Создал Query
      ADOQuery := TADOQuery.Create(nil);
      ADOQuery.CommandTimeout := 0;
      ADOQuery.ConnectionString := FConnectionString;
      // загружаю скрипт
      if Pos('FILE NAME=', AnsiUpperCase(FSQL)) = 1 then
        ADOQuery.SQL.LoadFromFile(Copy(FSQL, 11, Length(FSQL)))
      else
        ADOQuery.SQL.Text := FSQL;
      // Попытка исполнить запрос
      try
        if FBatch then
          ADOQuery.LockType := ltBatchOptimistic
        else
          ADOQuery.LockType := ltOptimistic;
        ADOQuery.Open;
      except
      end;
      // Обрабатываю событие
      Synchronize(DoWork);
      // Убиваю Query
      ADOQuery.Close;
      ADOQuery.Free;
      CoUninitialize;
    end;
     
    procedure TThADOQuery.DoWork;
    begin
      FAfterWork(Self.Handle, ADOQuery.Recordset, ADOQuery.Active);
    end;
     
    constructor TThreadADOQuery.Create(aConnectionString: string);
    begin
      inherited Create;
      FActive := False;
      FConnectionString := aConnectionString;
      FHandle := 0;
    end;
     
    procedure TThreadADOQuery.StartWork(aSQL: string; Batch: boolean = False);
    begin
      if not Assigned(Self) then
        exit;
      FActive := True;
      FQuery := TThADOQuery.Create;
      FHandle := FQuery.Handle;
      FQuery.OnAfterWork := AfterWork;
      FSQL := aSQL;
      FBatch := Batch;
      FQuery.ReSume;
    end;
     
    procedure TThreadADOQuery.AfterWork(AHandle: THandle; RecordSet: _RecordSet;
      Active: Boolean);
    begin
      if Assigned(Self) and Assigned(FAfterWork) then
        FAfterWork(FHandle, Recordset, Active);
      FActive := False;
    end;
     
    function TThreadADOQuery.PauseWork: boolean;
    begin
      if Assigned(Self) and FActive then
        FQuery.Suspended := not FQuery.Suspended;
      Result := FQuery.Suspended;
    end;
     
    procedure TThreadADOQuery.StopWork;
    var
      c: Cardinal;
    begin
      c := 0;
      if Assigned(Self) and FActive then
      begin
        TerminateThread(FHandle, c);
        FQuery.ADOQuery.Free;
        FQuery.Free;
      end;
      FActive := False;
    end;
     
    function RecordSetToTempTableForMSSQL(Connection: TADOConnection; RecordSet:
      _RecordSet; TableName: string): boolean;
    var
      i: integer;
      S, L: string;
      TempQuery: TADOQuery;
    begin
      Result := True;
      try
        S := '-- Script generated by Master BRAIN 2002 (C) --' + #13;
        S := S + 'IF OBJECT_ID(''TEMPDB..' + TableName +
          ''') IS NOT NULL DROP TABLE ' + TableName + #13;
        S := S + 'IF OBJECT_ID(''' + TableName + ''') IS NOT NULL DROP TABLE ' +
          TableName + #13;
        S := S + 'CREATE TABLE ' + TableName + ' (' + #13;
        for i := 0 to RecordSet.Fields.Count - 1 do
        begin
          case RecordSet.Fields.Item[i].Type_ of
            adSmallInt, adUnsignedSmallInt: L := 'SMALLINT';
            adTinyInt, adUnsignedTinyInt: L := 'TINYINT';
            adInteger, adUnsignedInt: L := 'INT';
            adBigInt, adUnsignedBigInt: L := 'BIGINT';
            adSingle, adDouble, adDecimal,
              adNumeric: L := 'NUMERIC(' +
                IntToStr(RecordSet.Fields.Item[i].Precision) + ',' +
              IntToStr(RecordSet.Fields.Item[i].NumericScale) + ')';
            adCurrency: L := 'MONEY';
            adBoolean: L := 'BIT';
            adGUID: L := 'UNIQUEIDENTIFIER';
            adDate, adDBDate, adDBTime,
              adDBTimeStamp: L := 'DATETIME';
            adChar: L := 'CHAR(' + IntToStr(RecordSet.Fields.Item[i].DefinedSize) +
              ')';
            adBSTR: L := 'NCHAR(' + IntToStr(RecordSet.Fields.Item[i].DefinedSize) +
              ')';
            adVarChar: L := 'VARCHAR(' +
              IntToStr(RecordSet.Fields.Item[i].DefinedSize) + ')';
            adVarWChar: L := 'NVARCHAR(' +
              IntToStr(RecordSet.Fields.Item[i].DefinedSize) + ')';
            adLongVarChar: L := 'TEXT';
            adLongVarWChar: L := 'NTEXT';
            adBinary: L := 'BINARY(' + IntToStr(RecordSet.Fields.Item[i].DefinedSize)
              + ')';
            adVarBinary: L := 'VARBINARY(' +
              IntToStr(RecordSet.Fields.Item[i].DefinedSize) + ')';
            adLongVarBinary: L := 'IMAGE';
            adFileTime, adDBFileTime: L := 'TIMESTAMP';
          else
            L := 'SQL_VARIANT';
          end;
          S := S + RecordSet.Fields.Item[i].Name + ' ' + L;
          if i < RecordSet.Fields.Count - 1 then
            S := S + ' ,' + #13
          else
            S := S + ' )' + #13;
        end;
        S := S + 'SELECT * FROM ' + TableName + #13;
        TempQuery := TADOQuery.Create(nil);
        TempQuery.Close;
        TempQuery.LockType := ltBatchOptimistic;
        TempQuery.SQL.Text := S;
        TempQuery.Connection := Connection;
        TempQuery.Open;
        RecordSet.MoveFirst;
        while not RecordSet.EOF do
        begin
          TempQuery.Append;
          for i := 0 to RecordSet.Fields.Count - 1 do
            TempQuery.FieldValues[RecordSet.Fields[i].Name] :=
              RecordSet.Fields[i].Value;
          TempQuery.Post;
          RecordSet.MoveNext;
        end;
        TempQuery.UpdateBatch;
        TempQuery.Close;
      except
        Result := False;
      end;
    end;
     
    function RecordSetToDBF(RecordSet: _RecordSet; FileName: string): boolean;
    var
      F_sv: TextFile;
      i, j, s, sl, iRowCount, iColCount: integer;
      l: string;
      Fields: array of record
        FieldType: Char;
        FieldSize, FieldDigits: byte;
      end;
      FieldType, tmpDC: Char;
      FieldSize, FieldDigits: byte;
     
      // Нестандартная конвертация - без глюков
      function Ansi2OEM(S: string): string;
      var
        Ansi_CODE, OEM_CODE: string;
        i: integer;
      begin
        OEM_CODE :=
          'ЂЃ‚ѓ„…†‡€‰Љ‹ЊЌЋЏђ‘’“”•–—?™љ›њќћџ ЎўЈ¤Ґ¦§Ё©Є«¬­®Їабвгдежзийклмнопьс';
        Ansi_CODE :=
          'АБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдежзийклмнопрстуфхцчшщъыьэюя№ё';
        Result := S;
        for i := 1 to Length(Result) do
          if Pos(Result[i], Ansi_CODE) > 0 then
            Result[i] := OEM_CODE[Pos(Result[i], Ansi_CODE)];
      end;
     
    begin
      Result := True;
      try
        AssignFile(F_sv, FileName);
        ReWrite(F_sv);
        iRowCount := RecordSet.RecordCount;
        iColCount := RecordSet.Fields.Count;
        // Формат dBASE III 2.0
        Write(F_sv, #3 + chr($63) + #4 + #4); // Заголовок 4 байта
        write(F_sv, Chr((((iRowCount) mod 16777216) mod 65536) mod 256) +
          Chr((((iRowCount) mod 16777216) mod 65536) div 256) +
          Chr(((iRowCount) mod 16777216) div 65536) +
          Chr((iRowCount) div 16777216)); // Word32 -> кол-во строк 5-8 байты
     
        i := (iColCount + 1) * 32 + 1; // Изврат
        write(F_sv, Chr(i mod 256) +
          Chr(i div 256)); // Word16 -> кол-во колонок с извратом 9-10 байты
     
        S := 1; // Считаем длинну загаловка
        for i := 0 to iColCount - 1 do
        begin
          if RecordSet.Fields[i].Precision = 255 then
            Sl := RecordSet.Fields[i].DefinedSize
          else
            Sl := RecordSet.Fields[i].Precision;
          if RecordSet.Fields.Item[i].Type_ in [adDate, adDBDate, adDBTime,
            adFileTime, adDBFileTime, adDBTimeStamp] then
            Sl := 8;
          S := S + Sl;
        end;
     
        write(F_sv, Chr(S mod 256) + Chr(S div 256)); { пишем длину заголовка 11-12}
        for i := 1 to 17 do
          write(F_sv, #0); // Пишем всякий хлам - 20 байт
        write(F_sv, chr($26) + #0 + #0); // Итого: 32 байта - базовый заголовок DBF
     
        SetLength(Fields, iColCount);
        for i := 0 to iColCount - 1 do
        begin // заполняем заголовок, а за одно и массив полей
          l := Copy(RecordSet.Fields[i].Name, 1, 10); // имя колонки
          while Length(l) < 11 do
            l := l + #0;
          write(F_sv, l);
          case RecordSet.Fields.Item[i].Type_ of
            adTinyInt, adSmallInt, adInteger, adBigInt, adUnsignedTinyInt,
              adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt,
              adDecimal, adNumeric, adVarNumeric, adSingle, adDouble: FieldType :=
                'N';
            adCurrency: FieldType := 'F';
            adDate, adDBDate, adDBTime, adFileTime, adDBFileTime, adDBTimeStamp:
              FieldType := 'D';
            adBoolean: FieldType := 'L';
          else
            FieldType := 'C';
          end;
          Fields[i].FieldType := FieldType;
     
          if RecordSet.Fields[i].Precision = 255 then
            FieldSize := RecordSet.Fields[i].DefinedSize
          else
            FieldSize := RecordSet.Fields[i].Precision;
     
          if Fields[i].FieldType = 'D' then
            Fields[i].FieldSize := 8
          else
            Fields[i].FieldSize := FieldSize;
     
          if RecordSet.Fields[i].NumericScale = 255 then
            FieldDigits := 0
          else
            FieldDigits := RecordSet.Fields[i].NumericScale;
          if (FieldType = 'F') and (FieldDigits < 2) then
            FieldDigits := 2;
          Fields[i].FieldDigits := FieldDigits;
     
          write(F_sv, FieldType + #0 + #0 + #0 + #0); // теперь размер
          write(F_sv, Chr(FieldSize) + Chr(FieldDigits));
          write(F_sv, #0 + #0 + #0 + #0 + #0 + #0 + #0 + #0 + #0 + #0 + #0 + #0 + #0
            + #0); // 14 нулей
        end;
        write(F_sv, Chr($0D)); // разделитель
     
        tmpDC := DECIMALSEPARATOR;
        DECIMALSEPARATOR := '.'; // Числа в англицком формате
        if iRowCount > 1 then
          RecordSet.MoveFirst;
        for j := 0 to iRowCount - 1 do
        begin // пишем данные
          write(F_sv, ' ');
          for i := 0 to iColCount - 1 do
          begin
            case Fields[i].FieldType of
              'D': if not VarIsNull(RecordSet.Fields[i].Value) then
                  L := FormatDateTime('yyyymmdd',
                    VarToDateTime(RecordSet.Fields[i].Value))
                else
                  L := '1900101';
              'N', 'F': if not VarIsNull(RecordSet.Fields[i].Value) then
                  L := Format('%' + IntToStr(Fields[i].FieldSize -
                    Fields[i].FieldDigits) + '.' + IntToStr(Fields[i].FieldDigits) +
                    'f', [StrToFloatDef(VarToStr(RecordSet.Fields[i].Value), 0)])
                else
                  L := '';
            else if not VarIsNull(RecordSet.Fields[i].Value) then
              L := Ansi2Oem(VarToStr(RecordSet.Fields[i].Value))
            else
              L := '';
            end;
     
            while Length(L) < Fields[i].FieldSize do
              if Fields[i].FieldType in ['N', 'F'] then
                L := L + #0
              else
                L := L + ' ';
            if Length(L) > Fields[i].FieldSize then
              SetLength(L, Fields[i].FieldSize);
     
            write(F_sv, l);
          end;
     
          RecordSet.MoveNext;
        end;
        DECIMALSEPARATOR := tmpDC;
        write(F_sv, Chr($1A));
        CloseFile(F_sv);
      except
        Result := False;
        if FileExists(FileName) then
          DeleteFile(FileName);
      end;
    end;
     
    function CopyRecordSet(RecordSet: _RecordSet): _RecordSet;
    var
      adoStream: OleVariant;
    begin
      adoStream := CreateOLEObject('ADODB.Stream');
      Variant(RecordSet).Save(adoStream, adPersistADTG);
      Result := CreateOLEObject('ADODB.RecordSet') as _RecordSet;
      Result.CursorLocation := adUseClient;
      Result.Open(adoStream, EmptyParam, adOpenStatic, adLockOptimistic,
        adOptionUnspecified);
      adoStream := UnAssigned;
    end;
     
    function UniqueTableName: string;
    var
      G: TGUID;
    begin
      CreateGUID(G);
      Result := GUIDToString(G);
      Delete(Result, 1, 1);
      Delete(Result, Length(Result), 1);
      while Pos('-', Result) > 0 do
        Delete(Result, Pos('-', Result), 1);
      Result := 'T' + Result;
    end;
     
    end.
