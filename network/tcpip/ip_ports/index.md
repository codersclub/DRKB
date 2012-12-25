---
Title: Как оперделить все IP и порты на моем компьютере?
Author: Spawn
Date: 01.01.2007
---


Как оперделить все IP и порты на моем компьютере?
=================================================

::: {.date}
01.01.2007
:::

Функции GetTcpTable, GetUdpTable.

Импорт GetTcpTable:

    unit TcpTable;
    interface
    type
      PDWord = ^Longword;
      PMIB_TCPROW = ^TMIB_TCPROW;
      TMIB_TCPROW = record
        dwState: LongWord;
        dwLocalAddr: LongWord;
        dwLocalPort: LongWord;
        dwRemoteAddr: LongWord;
        dwRemotePort: LongWord;
      end;
      PMIB_TCPTABLE = ^TMIB_TCPTABLE;
      TMIB_TCPTABLE = record
        dwNumEntries: LongWord;
        table: array[0..0] of TMIB_TCPROW;
      end;
    function GetTcpTable(var TcpTable: PMIB_TCPTABLE; var Size: PDWord; bOrder: Boolean): LongWord; stdcall
    implementation
    function GetTcpTable; external 'Iphlpapi.dll' name 'GetTcpTable';
    end.

Вызов GetTcpTable:

    {$R-}
        Entries:=16;
        Sz:=SizeOf(TMIB_TCPTABLE)+SizeOf(TMIB_TCPROW)*(Entries-1);
        pMibTable:=nil;
        try
         repeat
           ReallocMem(pMibTable,Sz);
           Res:=GetTcpTable(pMibTable^,Sz,False);
         until Res <> ERROR_INSUFFICIENT_BUFFER;
         if Res <> NO_ERROR then
          begin
           ShowMessage(SysErrorMessage(Res));
           exit;
          end;
         for Entries:=0 to pMibTable.dwNumEntries-1 do
          begin
             <Делать что-то>
          end;
        finally
         FreeMem(pMibTable);
        end;
    {$R+}

Автор: Spawn

Взято с Vingrad.ru <https://forum.vingrad.ru>
