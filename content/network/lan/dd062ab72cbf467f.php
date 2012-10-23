<h1>Получение IP-адресов всех компьютеров в рабочей группе</h1>
<div class="date">01.01.2007</div>


<pre>
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
  until (Entries &lt;&gt; 1) or (Result &lt;&gt; NO_ERROR); 
  WNetCloseEnum(EnumHandle); 
end; { Find All Computers }
</pre>

<div class="author">Автор: Song</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
