---
Title: Как найти список параллельных портов?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как найти список параллельных портов?
=====================================

    function PortExists(const PortName: string): Boolean;
    var
      hPort: HWND;
    begin
      Result := False;
      hPort := CreateFile(PChar(PortName), {name}
        GENERIC_READ or GENERIC_WRITE, {access attributes}
        0, {no sharing}
        nil, {no security}
        OPEN_EXISTING, {creation action}
        FILE_ATTRIBUTE_NORMAL or
        FILE_FLAG_OVERLAPPED, {attributes}
        0); {no template}
      if hPort <> INVALID_HANDLE_VALUE then
      begin
        CloseHandle(hPort);
        Result := True;
      end;
    end;
     
    {Parallel Ports}
    for i := 1 to 9 do
    begin
      if PortExists('LPT' + IntToStr(i)) then
        List.Append('Ports: Printer Port (LPT' + IntTostr(i) + ')');
    end;

