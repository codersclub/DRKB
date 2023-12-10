---
Title: Поиск в памяти процесса
Author: Rouse\_
Date: 01.01.2007
---

Поиск в памяти процесса
=======================

::: {.date}
01.01.2007
:::

    // Поиск значения типа DWORD в указанном процессе
    // paul_shmakov@mail.ru
    //
    program search;
     
    {$APPTYPE CONSOLE}
     
    uses Windows, SysUtils;
     
    var
     ProcessID: DWord;
     ProcessHandle: THandle;
     Mbi: TMemoryBasicInformation;
     Addr: DWord;
     Value: DWord;
     I: Cardinal;
     Buf: PChar;
     BytesRead: DWord;
    begin
     if ParamCount < 2 then
     begin
      WriteLn('Usage: search.exe processid value');
      Exit;
     end;
     
     ProcessID := StrToInt(ParamStr(1));
     WriteLn('Process id: ' + IntToStr(ProcessID));
     
     Value := StrToInt(ParamStr(2));
     WriteLn('Value to search: ' + IntToStr(Value));
     
     //
     // Открываем процесс
     //
     ProcessHandle := OpenProcess(PROCESS_QUERY_INFORMATION or PROCESS_VM_READ or
      PROCESS_VM_OPERATION, false, ProcessID);
     
     if ProcessHandle <> 0 then
     try
      Addr := 0;
     
      //
      // Перечисляем все регионы виртуальной памяти процесса
      //
      while VirtualQueryEx(ProcessHandle, Pointer(Addr), Mbi, SizeOf(Mbi)) <> 0 do
      begin
       // Uncomment чтобы увидеть список регионов, найденых в адресном пространстве
       // WriteLn('region: ' + IntToHex(Integer(Mbi.BaseAddress), 8) +
       //   ' size: ' + IntToStr(Mbi.RegionSize));
     
       //
       // Если региону выделена память, и регион не является "сторожевым" (как вершина стека),
       // то читаем этот регион
       //
       if (Mbi.State = MEM_COMMIT) and not ((Mbi.Protect and PAGE_GUARD) = PAGE_GUARD) then
       begin
        //
        // Это демонстрационная программа, поэтому здесь выделяется буфер под весь регион.
        // Регион может быть достаточно большим, поэтому лучше читать его блоками для экономии
        // памяти. Но здесь для простоты алгоритма вся оптимизация похерена.
        //
        GetMem(Buf, Mbi.RegionSize);
        try
         //
         // Читаем весь регион в выделенный буфер
         //
         if ReadProcessMemory(ProcessHandle, Mbi.BaseAddress, Buf,
           Mbi.RegionSize, BytesRead) then
         begin
          //
          // Ищем значение типа DWORD в буфере
          //
          for I := 0 to BytesRead - SizeOf(Value) do
          begin
           if PDWord(@Buf[I])^ = Value then
            // Найдено, выводим
            WriteLn('Value ' + IntToStr(Value) + ' found at ' +
             IntToHex(Integer(Cardinal(Mbi.BaseAddress) + I), 8));
          end;
         end
         else
          WriteLn('Failed to read process memory ' + IntToStr(GetLastError));
     
        finally
         FreeMem(Buf);
        end;
       end;
     
       // Вычисляем адрес следуюшего региона
       Addr := Addr + Mbi.RegionSize;
      end;
     
     finally  
      CloseHandle(ProcessHandle);
     end
     else
      WriteLn('Failed to open process');
    end.



а вот программа, в которой ведем поиск для примера:

    program someprog;
     
    {$APPTYPE CONSOLE}
     
    uses SysUtils;
     
    var
     SomeValue: Integer;
    begin
     SomeValue := 12345;
     WriteLn('One variable of this program has a value ' + IntToStr(SomeValue));
     WriteLn('Press any key to exit');
     ReadLn;
    end.

Взято из <https://forum.sources.ru>

Автор: Rouse\_


 
