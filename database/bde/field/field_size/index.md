---
Title: Изменить размер поля или его тип
Author: Reinhard Kalinke
Date: 01.01.2007
---


Изменить размер поля или его тип
================================

::: {.date}
01.01.2007
:::

Автор: Reinhard Kalinke

Единственный способ изменить размер поля или его тип - использовать
DBIDoRestructure. Вот простой пример, который может вам помочь в этом:

    function BDEStringFieldResize(ATable: TTable; AFieldName: string; ANewSize:
      integer): boolean;
    type
      TRestructStatus = (rsFieldNotFound, rsNothingToDo, rsDoIt);
    var
      hDB: hDBIdb;
      pTableDesc: pCRTblDesc;
      pFldOp: pCROpType; {фактически это массив array of pCROpType}
      pFieldDesc: pFldDesc; {фактически это массив array of pFldDesc}
      CurPrp: CurProps;
      CSubType: integer;
      CCbrOption: CBRType;
      eRestrStatus: TRestructStatus;
      pErrMess: DBIMsg;
      i: integer;
    begin
      Result := False;
      eRestrStatus := rsFieldNotFound;
      AFieldName := UpperCase(AFieldName);
      pTableDesc := nil;
      pFieldDesc := nil;
      pFldOp := nil;
     
      with ATable do
      try
     
        {убедимся что имеем исключительный доступ и сохраним dbhandle:}
        if Active and (not Exclusive) then
          Close;
        if (not Exclusive) then
          Exclusive := True;
        if (not Active) then
          Open;
        hDB := DBHandle;
     
        {готовим данные для DBIDoRestructure:}
        BDECheck(DBIGetCursorProps(Handle, CurPrp));
        GetMem(pFieldDesc, CurPrp.iFields * sizeOf(FldDesc));
        BDECheck(DBIGetFieldDescs(Handle, pFieldDesc));
        GetMem(pFldOp, CurPrp.iFields * sizeOf(CROpType));
        FillChar(pFldOp^, CurPrp.iFields * sizeOf(CROpType), 0);
     
        {ищем в цикле (через fielddesc) наше поле:}
        for i := 1 to CurPrp.iFields do
        begin
          {для ввода мы имеем серийные номера вместо
          Pdox ID, возвращаемых DbiGetFieldDescs:}
          pFieldDesc^.iFldNum := i;
          if (Uppercase(StrPas(pFieldDesc^.szName)) = AFieldName)
            and (pFieldDesc^.iFldType = fldZSTRING) then
          begin
            eRestrStatus := rsNothingToDo;
            if (pFieldDesc^.iUnits1 <> ANewSize) then
            begin
              pFieldDesc^.iUnits1 := ANewSize;
              pFldOp^ := crModify;
              eRestrStatus := rsDoIt;
            end;
          end;
          inc(pFieldDesc);
          inc(pFldOp);
        end; {for}
     
        {"регулируем" массив указателей:}
        dec(pFieldDesc, CurPrp.iFields);
        dec(pFldOp, CurPrp.iFields);
     
        {в случае отсутствия операций возбуждаем исключение:}
        case eRestrStatus of
          rsNothingToDo: raise Exception.Create('Ничего не сделано');
          rsFieldNotFound: raise Exception.Create('Поле не найдено');
        end;
     
        GetMem(pTableDesc, sizeOf(CRTblDesc));
        FillChar(pTableDesc^, SizeOf(CRTblDesc), 0);
        StrPCopy(pTableDesc^.szTblName, TableName);
        {StrPCopy(pTableDesc^.szTblType,szPARADOX); {}
        pTableDesc^.szTblType := CurPrp.szTableType;
        pTableDesc^.iFldCount := CurPrp.iFields;
        pTableDesc^.pecrFldOp := pFldOp;
        pTableDesc^.pfldDesc := pFieldDesc;
     
        Close;
     
        BDECheck(DbiDoRestructure(hDB, 1, pTableDesc, nil, nil, nil, False));
     
      finally
        if pTableDesc <> nil then
          FreeMem(pTableDesc, sizeOf(CRTblDesc));
        if pFldOp <> nil then
          FreeMem(pFldOp, CurPrp.iFields * sizeOf(CROpType));
        if pFieldDesc <> nil then
          FreeMem(pFieldDesc, CurPrp.iFields * sizeOf(FldDesc));
        Open;
      end; {пробуем с table1}
      Result := True;
    end;

Взято с <https://delphiworld.narod.ru>

Примечание Vit

На счёт \"Единственный способ\"  - этот товарищ несколько погорячился.
Все базы данных поддерживают SQL запрос вида

ALTER TABLE...

Конкретный формат надо выяснить в справочнике по используемой базе
данных, так как он немного различается для разных серверов, но указанный
запрос весьма гибок, и применим не только с BDE, но и с другими
системами доступа и с любыми базами данных.
