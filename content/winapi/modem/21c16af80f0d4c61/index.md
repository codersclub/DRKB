---
Title: Как узнать состояние модема в Win32?
Date: 01.01.2007
---


Как узнать состояние модема в Win32?
====================================

::: {.date}
01.01.2007
:::

Следующий пример демонстрирует получение состояния управляющих регистров
модема.

Пример:

    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      CommPort : string; 
      hCommFile : THandle; 
      ModemStat : DWord; 
    begin 
      CommPort := 'COM2'; 
     
    {Открываем com-порт} 
      hCommFile := CreateFile(PChar(CommPort), 
                              GENERIC_READ, 
                              0, 
                              nil, 
                              OPEN_EXISTING, 
                              FILE_ATTRIBUTE_NORMAL, 
                              0); 
      if hCommFile = INVALID_HANDLE_VALUE then 
      begin 
        ShowMessage('Unable to open '+ CommPort); 
        exit; 
      end; 
     
    {Получаем состояние модема} 
      if GetCommModemStatus(hCommFile, ModemStat) <> false then begin 
        if ModemStat and MS_CTS_ON <> 0 then 
          ShowMessage('The CTS (clear-to-send) is on.'); 
        if ModemStat and MS_DSR_ON <> 0 then 
          ShowMessage('The DSR (data-set-ready) is on.'); 
        if ModemStat and MS_RING_ON <> 0then 
          ShowMessage('The ring indicator is on.'); 
        if ModemStat and MS_RLSD_ON <> 0 then 
          ShowMessage('The RLSD (receive-line-signal-detect) is 
    on.'); 
    end; 
     
    {Закрываем com-порт} 
      CloseHandle(hCommFile); 
    end;

Взято из <https://forum.sources.ru>
