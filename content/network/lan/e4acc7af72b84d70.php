<h1>Имена сетевого адаптера, системное имя устройства и описание</h1>
<div class="date">01.01.2007</div>


<p>Имя виртуального устройства можно получить вот так:<br>
<p></p>
<pre>

 
 
const
  MAX_ADAPTER_NAME       = 255;
type
  PIP_ADAPTER_INDEX_MAP = ^IP_ADAPTER_INDEX_MAP;
  IP_ADAPTER_INDEX_MAP = record
     Index: DWORD;
     Name: array [0..MAX_ADAPTER_NAME-1] of WideChar;
  end;
 
  PIP_INTERFACE_INFO = ^IP_INTERFACE_INFO;
  IP_INTERFACE_INFO = record
     NumAdapters: Longint;
     Adapter: array [0..0] of IP_ADAPTER_INDEX_MAP;
  end;
 
  function GetIfEntry(pIfRow: PMibIfRow): DWORD; stdcall external 'iphlpapi.dll';
  function GetNumberOfInterfaces(var pdwIntf: DWORD): DWORD; stdcall; external 'iphlpapi.dll';
  function GetInterfaceInfo(pIfTable: PIP_INTERFACE_INFO; var dwOutBufLen:DWORD): DWORD;
    stdcall; external 'iphlpapi.dll';
  function GetAdapterIndex(AdapterName: PWideChar; var IfIndex: DWORD): DWORD;
    stdcall; external 'iphlpapi.dll';
 
procedure TMainForm.Button1Click(Sender: TObject);
var
  I, pdwIntf, dwOutBufLen, IfIndex: DWORD;
  lpInfo: PIP_INTERFACE_INFO;
  mirIfDescr: TMibIfRow;
begin
  //if GetNumberOfInterfaces(pdwIntf) = NO_ERROR then
  //begin
    GetInterfaceInfo(nil, dwOutBufLen);
    GetMem(lpInfo, dwOutBufLen);
    try
      if GetInterfaceInfo(lpInfo, dwOutBufLen) = NO_ERROR then
      begin
        for I := 0 to lpInfo^.NumAdapters - 1 do
        begin
          Memo1.Lines.Add('AdapterName: ' + lpInfo^.Adapter[I].Name);
          if GetAdapterIndex(lpInfo^.Adapter[I].Name, IfIndex) = NO_ERROR then
            Memo1.Lines.Add('AdapterIndex: ' + IntToStr(IfIndex))
          else
            RaiseLastOSError;
          ZeroMemory(@mirIfDescr, SizeOf(TMibIfRow));
          mirIfDescr.dwIndex := IfIndex;
          if GetIfEntry(@mirIfDescr) = NO_ERROR then
            Memo1.Lines.Add('AdapterDescription: ' + mirIfDescr.bDescr)
          else
            RaiseLastOSError;
        end;
      end
      else
        RaiseLastOSError;
    finally
      FreeMem(lpInfo);
    end;
  end
  //else
    //RaiseLastOSError;
end;
</pre>
<p> <br>
 <br>
<div class="author">Автор: Александр (Rouse_) Багель</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


