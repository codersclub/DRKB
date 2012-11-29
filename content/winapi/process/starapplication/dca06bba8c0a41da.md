Как завершить любой процесс, в том числе и системный?
=====================================================

::: {.date}
01.01.2007
:::

    // Включение, приминение и отключения привилегии.
     // Для примера возьмем привилегию отладки приложений 'SeDebugPrivilege'
     // необходимую для завершения ЛЮБЫХ процессов в системе (завершение процесов
     // созданных текущим пользователем привилегия не нужна.
     
    function ProcessTerminate(dwPID:Cardinal):Boolean;
    var
     hToken:THandle;
     SeDebugNameValue:Int64;
     tkp:TOKEN_PRIVILEGES;
     ReturnLength:Cardinal;
     hProcess:THandle;
    begin
     Result:=false;
     // Добавляем привилегию SeDebugPrivilege 
     // Для начала получаем токен нашего процесса
     if not OpenProcessToken( GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES
      or TOKEN_QUERY, hToken ) then
        exit;
     
     // Получаем LUID привилегии
     if not LookupPrivilegeValue( nil, 'SeDebugPrivilege', SeDebugNameValue ) 
      then begin
       CloseHandle(hToken);
       exit; 
      end;
     
     tkp.PrivilegeCount:= 1;
     tkp.Privileges[0].Luid := SeDebugNameValue;
     tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
     
     // Добавляем привилегию к нашему процессу
     AdjustTokenPrivileges(hToken,false,tkp,SizeOf(tkp),tkp,ReturnLength);
     if GetLastError()< > ERROR_SUCCESS  then exit;
     
     // Завершаем процесс. Если у нас есть SeDebugPrivilege, то мы можем
     // завершить и системный процесс
     // Получаем дескриптор процесса для его завершения
     hProcess := OpenProcess(PROCESS_TERMINATE, FALSE, dwPID);
     if hProcess =0  then exit;
      // Завершаем процесс
       if not TerminateProcess(hProcess, DWORD(-1))
        then exit;
     CloseHandle( hProcess );
     
     // Удаляем привилегию 
     tkp.Privileges[0].Attributes := 0; 
     AdjustTokenPrivileges(hToken, FALSE, tkp, SizeOf(tkp), tkp, ReturnLength);
     if GetLastError() < >  ERROR_SUCCESS
      then exit;
     
     Result:=true; 
    end;
     
     // Название добавление/удаление привилгии немного неправильные.  Привилегия или 
     // есть в токене процесса или ее нет. Если привилегия есть, то она может быть в 
     // двух состояниях - или включеная или отключеная. И в этом примере мы только 
     // включаем или выключаем необходимую привилегию, а не добавляем ее.

Взято с <https://delphiworld.narod.ru>
