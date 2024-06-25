---
Title: Как найти все комьютеры в сети?
Author: Pegas
Date: 01.01.2007
---


Как найти все комьютеры в сети?
===============================

Вариант 1:

ID: 03286

    unit FindComp; 
     
    interface 
     
    uses 
     Windows, Classes; 
     
    function FindComputers: DWORD; 
     
    var 
     Computers: TStringList; 
     
    implementation 
     
    uses 
     SysUtils; 
     
    const 
     MaxEntries = 250; 
     
    function FindComputers: DWORD; 
     
    var 
     EnumWorkGroupHandle, EnumComputerHandle: THandle; 
     EnumError: DWORD; 
     Network: TNetResource; 
     WorkGroupEntries, ComputerEntries: DWORD; 
     EnumWorkGroupBuffer, EnumComputerBuffer: array[1..MaxEntries] of TNetResource; 
     EnumBufferLength: DWORD; 
     I, J: DWORD; 
     
    begin 
     
     Computers.Clear; 
     
     FillChar(Network, SizeOf(Network), 0); 
     with Network do 
     begin 
       dwScope := RESOURCE_GLOBALNET; 
       dwType := RESOURCETYPE_ANY; 
       dwUsage := RESOURCEUSAGE_CONTAINER; 
     end; 
     
     EnumError := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY, 0, @Network, EnumWorkGroupHandle); 
     
     if EnumError = NO_ERROR then 
     begin 
       WorkGroupEntries := MaxEntries; 
       EnumBufferLength := SizeOf(EnumWorkGroupBuffer); 
       EnumError := WNetEnumResource(EnumWorkGroupHandle, WorkGroupEntries, @EnumWorkGroupBuffer, EnumBufferLength); 
     
       if EnumError = NO_ERROR then 
       begin 
         for I := 1 to WorkGroupEntries do 
         begin 
           EnumError := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY, 0, @EnumWorkGroupBuffer[I], EnumComputerHandle); 
           if EnumError = NO_ERROR then 
           begin 
             ComputerEntries := MaxEntries; 
             EnumBufferLength := SizeOf(EnumComputerBuffer); 
             EnumError := WNetEnumResource(EnumComputerHandle, ComputerEntries, @EnumComputerBuffer, EnumBufferLength); 
             if EnumError = NO_ERROR then 
               for J := 1 to ComputerEntries do 
                 Computers.Add(Copy(EnumComputerBuffer[J].lpRemoteName, 3, Length(EnumComputerBuffer[J].lpRemoteName) - 2)); 
             WNetCloseEnum(EnumComputerHandle); 
           end; 
         end; 
       end; 
       WNetCloseEnum(EnumWorkGroupHandle); 
     end; 
     
     if EnumError = ERROR_NO_MORE_ITEMS then 
       EnumError := NO_ERROR; 
     Result := EnumError; 
     
    end; 
     
    initialization 
     
     Computers := TStringList.Create; 
     
    finalization 
     
     Computers.Free; 
     
    end.

------------------------------------------------------------------------

Вариант 2:

Author: Pegas

Source: Vingrad.ru <https://forum.vingrad.ru>

    function TNetForm.FillNetLevel(xxx: PNetResource; List:TListItems): Word;
    Type
        PNRArr = ^TNRArr;
        TNRArr = array[0..59] of TNetResource;
    Var
       x: PNRArr;
       tnr: TNetResource;
       I : integer;
       EntrReq,
       SizeReq,
       twx: THandle;
       WSName: string;
       LI:TListItem;
    begin
         Result :=WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY,RESOURCEUSAGE_CONTAINER, xxx, twx);
         If Result = ERROR_NO_NETWORK Then Exit;
         if Result = NO_ERROR then
         begin
                New(x);
                EntrReq := 1;
                SizeReq := SizeOf(TNetResource)*59;
                while (twx <> 0) and
                      (WNetEnumResource(twx, EntrReq, x, SizeReq) <> ERROR_NO_MORE_ITEMS) do
                begin
                      For i := 0 To EntrReq - 1 do
                      begin
                       Move(x^[i], tnr, SizeOf(tnr));
                       case tnr.dwDisplayType of
                        RESOURCEDISPLAYTYPE_SERVER:
                        begin
                           if tnr.lpRemoteName <> '' then
                               WSName:= tnr.lpRemoteName
                               else WSName:= tnr.lpComment;
                           LI:=list.Add;
                           LI.Caption:=copy(WSName,3,length(WSName)-2);
                           //list.Add(WSName);
                        end;
                        else FillNetLevel(@tnr, list);
                       end;
                      end;
                end;
                Dispose(x);
                WNetCloseEnum(twx);
         end;
    end;
     
    Пример вызова: 
    FillNetLevel(nil,ListView1.Items);

       ©Drkb::03287

------------------------------------------------------------------------

Вариант 3:

Author: SmaLL

Source: Vingrad.ru <https://forum.vingrad.ru>

    function EnumerateFunc( hwnd: HWND; hdc: HDC; lpnr: PNetResource ): Boolean;
    const
     cbBuffer : DWORD    = 16384;      // 16K is a good size
    var
     hEnum, dwResult, dwResultEnum : DWORD;
     lpnrLocal : array
           [0..16384 div SizeOf(TNetResource)] of TNetResource;    // pointer to enumerated structures
     i : integer;
     cEntries : Longint;             
    begin
     centries := -1;      // enumerate all possible entries
     
     // Call the WNetOpenEnum function to begin the enumeration.
     dwResult := WNetOpenEnum(
                             RESOURCE_CONTEXT,  // Enumerate currently connected resources.
                             RESOURCETYPE_DISK, // all resources
                             0,                 // enumerate all resources
                             lpnr,              // NULL first time the function is called
                             hEnum              // handle to the resource
                             );
     
     if (dwResult <> NO_ERROR) then
     begin
       // Process errors with an application-defined error handler
       Result := False;
       Exit;
     end;
     
     // Initialize the buffer.
     FillChar( lpnrLocal, cbBuffer, 0 );
     
     // Call the WNetEnumResource function to continue
     //  the enumeration.
     dwResultEnum := WNetEnumResource(hEnum,           // resource handle
                                     DWORD(cEntries),  // defined locally as -1
                                     @lpnrLocal,       // LPNETRESOURCE
                                     cbBuffer);        // buffer size
     
     // This is just printing
     for i := 0 to cEntries - 1 do
     begin
       // loop through each structure and 
       // get remote name of resource... lpnrLocal[i].lpRemoteName)
     end;
     
     // Call WNetCloseEnum to end the enumeration.
     dwResult := WNetCloseEnum(hEnum);
     
     if(dwResult <> NO_ERROR) then
     begin
       // Process errors... some user defined function here
       Result := False;
     end
     else
       Result :=  True;
    end;

Код вроде бы из борландовского FAQ.

------------------------------------------------------------------------

Вариант 4:

Source: Vingrad.ru <https://forum.vingrad.ru>

Вот решение приведенное на <https://delphi.mastak.ru> для нахождения
всех компютеров:

    var
      Computer: array[1..500] of string[25];
      ComputerCount: Integer;
     
    procedure FindAllComputers(Workgroup: string);
    var
      EnumHandle: THandle;
      WorkgroupRS: TNetResource;
      Buf: array[1..500] of TNetResource;
      BufSize: Integer;
      Entries: Integer;
      Result: Integer;
    begin
      ComputerCount := 0;
      Workgroup := Workgroup + #0;
      FillChar(WorkgroupRS, SizeOf(WorkgroupRS), 0);
      with WorkgroupRS do
        begin
          dwScope := 2;
          dwType := 3;
          dwDisplayType := 1;
          dwUsage := 2;
          lpRemoteName := @Workgroup[1];
        end;
      WNetOpenEnum(RESOURCE_GLOBALNET,
        RESOURCETYPE_ANY,
        0,
        @WorkgroupRS,
        EnumHandle);
      repeat
        Entries := 1;
        BufSize := SizeOf(Buf);
        Result :=
          WNetEnumResource(EnumHandle,
          Entries,
          @Buf,
          BufSize);
        if (Result = NO_ERROR) and (Entries = 1) then
          begin
            Inc(ComputerCount);
            Computer[ComputerCount] := StrPas(Buf[1].lpRemoteName);
          end;
      until (Entries <> 1) or (Result <> NO_ERROR);
      WNetCloseEnum(EnumHandle);
    end; { Find All Computers }

