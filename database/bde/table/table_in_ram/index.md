---
Title: Как создать таблицу в памяти?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как создать таблицу в памяти?
=============================

This is an InMemoryTable example.
InMemory tables are a feature of the Borland Database Engine (BDE). 
InMemory tables are created in RAM and deleted when you close them. 
They are much faster and are very useful when you need fast operations on 
small tables. This example uses the DbiCreateInMemoryTable DBE function call. 


    { 
      This is an InMemoryTable example. Free for anyone to use, modify and do 
      whatever else you wish. 
     
      Just like all things free it comes with no guarantees. 
      I cannot be responsible for any damage this code may cause. 
      Let me repeat this: 
     
       WARNING! THIS CODE IS PROVIDED AS IS WITH NO GUARANTEES OF ANY KIND! 
       USE THIS AT YOUR OWN RISK - YOU ARE THE ONLY PERSON RESPONSIBLE FOR 
       ANY DAMAGE THIS CODE MAY CAUSE - YOU HAVE BEEN WARNED! 
     
      THANKS to Steve Garland <72700.2407@compuserve.com> for his help. 
      He created his own variation of an in-memory table component and 
      I used it to get started. 
     
      InMemory tables are a feature of the Borland Database Engine (BDE). 
      InMemory tables are created in RAM and deleted when you close them. 
      They are much faster and are very useful when you need fast operations on 
      small tables. This example uses the DbiCreateInMemoryTable DBE function call. 
     
      This object should work just like a regular table, except InMemory 
      tables do not support certain features (like referntial integrity, 
      secondary indexes and BLOBs) and currently this code doesn't do anything to 
      prevent you from trying to use them. You will probably get some error if 
      you try to create a memo field. 
    } 
     
    unit Inmem; 
     
    interface 
     
    uses DBTables, WinTypes, WinProcs, DBITypes, DBIProcs, DB, SysUtils; 
     
    type 
      TInMemoryTable = class(TTable) 
      private 
        hCursor: hDBICur; 
        procedure EncodeFieldDesc(var FieldDesc: FLDDesc; 
          const Name: string; DataType: TFieldType; Size: Word); 
        function CreateHandle: HDBICur; override; 
      public 
        procedure CreateTable; 
      end; 
     
    implementation 
     
    { 
      Luckely this function is virtual - so I could override it. In the 
      original VCL code for TTable this function actually opens the table - 
      but since we already have the handle to the table - we just return it 
    } 
     
    function TInMemoryTable.CreateHandle; 
    begin 
      Result := hCursor; 
    end; 
     
    { 
      This function is cut-and-pasted from the VCL source code. I had to do 
      this because it is declared private in the TTable component so I had no 
      access to it from here. 
    } 
     
    procedure TInMemoryTable.EncodeFieldDesc(var FieldDesc: FLDDesc; 
      const Name: string; DataType: TFieldType; Size: Word); 
    const 
      TypeMap: array[TFieldType] of Byte = (fldUNKNOWN, fldZSTRING, fldINT16, 
        fldINT32, fldUINT16, fldBOOL, 
        fldFLOAT, fldFLOAT, fldBCD, fldDATE, fldTIME, fldTIMESTAMP, fldBYTES, 
        fldVARBYTES, fldBLOB, fldBLOB, fldBLOB); 
    begin 
      with FieldDesc do 
      begin 
        AnsiToNative(Locale, Name, szName, SizeOf(szName) - 1); 
        iFldType := TypeMap[DataType]; 
        case DataType of 
          ftString, ftBytes, ftVarBytes, ftBlob, ftMemo, ftGraphic: 
            iUnits1 := Size; 
          ftBCD: 
            begin 
              iUnits1 := 32; 
              iUnits2 := Size; 
            end; 
        end; 
        case DataType of 
          ftCurrency: 
            iSubType := fldstMONEY; 
          ftBlob: 
            iSubType := fldstBINARY; 
          ftMemo: 
            iSubType := fldstMEMO; 
          ftGraphic: 
            iSubType := fldstGRAPHIC; 
        end; 
      end; 
    end; 
     
    { 
      This is where all the fun happens. I copied this function from the VCL 
      source and then changed it to use DbiCreateInMemoryTable instead of 
      DbiCreateTable. 
     
      Since InMemory tables do not support Indexes - I took all of the 
      index-related things out 
    } 
     
    procedure TInMemoryTable.CreateTable; 
    var 
      I: Integer; 
      pFieldDesc: pFLDDesc; 
      szTblName: DBITBLNAME; 
      iFields: Word; 
      Dogs: pfldDesc; 
    begin 
      CheckInactive; 
      if FieldDefs.Count = 0 then 
        for I := 0 to FieldCount - 1 do 
          with Fields[I] do 
            if not Calculated then 
              FieldDefs.Add(FieldName, DataType, Size, Required); 
      pFieldDesc := nil; 
      SetDBFlag(dbfTable, True); 
      try 
        AnsiToNative(Locale, TableName, szTblName, SizeOf(szTblName) - 1); 
        iFields := FieldDefs.Count; 
        pFieldDesc := AllocMem(iFields * SizeOf(FLDDesc)); 
        for I := 0 to FieldDefs.Count - 1 do 
          with FieldDefs[I] do 
          begin 
            EncodeFieldDesc(PFieldDescList(pFieldDesc)^[I], Name, 
              DataType, Size); 
          end; 
        { the driver type is nil = logical fields } 
        Check(DbiTranslateRecordStructure(nil, iFields, pFieldDesc, 
          nil, nil, pFieldDesc)); 
        { here we go - this is where hCursor gets its value } 
        Check(DbiCreateInMemTable(DBHandle, szTblName, iFields, pFieldDesc, hCursor)); 
      finally 
        if pFieldDesc <> nil then FreeMem(pFieldDesc, iFields * SizeOf(FLDDesc)); 
        SetDBFlag(dbfTable, False); 
      end; 
    end; 
     
    end. 

