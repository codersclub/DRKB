<h1>Как получить размер физической установленной памяти?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  Windows, SysUtils;
 
function DisplayRam: string;
var
  Info: TMemoryStatus;
begin
  Info.dwLength := SizeOf(TMemoryStatus);
  GlobalMemoryStatus(Info);
  Result := Format('%d MB RAM', [(Info.dwTotalPhys shr 20) + 1]);
end;
</pre>



<hr />
<pre>
function Physmem: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwTotalPhys div 1024);
end;
 
function PhysmemFree: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwAvailPhys div 1024);
end;
 
function MemLoad: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwMemoryLoad);
end;
 
function TotalPageFile: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwTotalPageFile div 1024);
end;
 
function AvailPageFile: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwAvailPageFile div 1024);
end;
 
function VirTotPageFile: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwTotalVirtual div 1024);
end;
 
function AvailVir: string;
var
  MemStat: TMemoryStatus;
begin
  MemStat.dwLength := sizeof(MemStat);
  GlobalMemoryStatus(MemStat);
  result := inttoStr(memstat.dwAvailVirtual div 1024);
end;
</pre>

<hr />

<pre>
uses
  Windows;
 
function TMyApp.GlobalMemoryStatus(Index: Integer): Integer;
var
  MemoryStatus: TMemoryStatus
begin
  with MemoryStatus do
  begin
    dwLength := SizeOf(TMemoryStatus);
    Windows.GlobalMemoryStatus(MemoryStatus);
    case Index of
      1: Result := dwMemoryLoad;
      2: Result := dwTotalPhys div 1024;
      3: Result := dwAvailPhys div 1024;
      4: Result := dwTotalPageFile div 1024;
      5: Result := dwAvailPageFile div 1024;
      6: Result := dwTotalVirtual div 1024;
      7: Result := dwAvailVirtual div 1024;
    else
      Result := 0;
    end;
  end;
end;
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

