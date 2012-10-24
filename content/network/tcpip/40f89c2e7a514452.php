<h1>Как оперделить все IP и порты на моем компьютере?</h1>
<div class="date">01.01.2007</div>


<p>Функции GetTcpTable, GetUdpTable.</p>
<p>Импорт GetTcpTable:</p>
<pre>
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
</pre>
<p>Вызов GetTcpTable:</p>
<pre>
{$R-}
    Entries:=16;
    Sz:=SizeOf(TMIB_TCPTABLE)+SizeOf(TMIB_TCPROW)*(Entries-1);
    pMibTable:=nil;
    try
     repeat
       ReallocMem(pMibTable,Sz);
       Res:=GetTcpTable(pMibTable^,Sz,False);
     until Res &lt;&gt; ERROR_INSUFFICIENT_BUFFER;
     if Res &lt;&gt; NO_ERROR then
      begin
       ShowMessage(SysErrorMessage(Res));
       exit;
      end;
     for Entries:=0 to pMibTable.dwNumEntries-1 do
      begin
         &lt;Делать что-то&gt;
      end;
    finally
     FreeMem(pMibTable);
    end;
{$R+}
</pre>
<div class="author">Автор: Spawn</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
