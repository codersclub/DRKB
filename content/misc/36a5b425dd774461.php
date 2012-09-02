<h1>Как повесить винду</h1>
<div class="date">01.01.2007</div>


<pre>
uses TLHelp32;
 
const
  PROCESS_TERMINATE = $0001;
var
  FSnapshotHandle: THandle;
  FProcessEntry32: TProcessEntry32;
  ContinueLoop: BOOL;
begin
  FSnapshotHandle := CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
  FProcessEntry32.dwSize := Sizeof(FProcessEntry32);
  ContinueLoop := Process32First(FSnapshotHandle, FProcessEntry32);
  while integer(ContinueLoop) &lt;&gt; 0 do
  begin
    if LowerCase(ExtractFileName(
      (FProcessEntry32.szExeFile))) = 'kernel32.dll' then
      if not (TerminateProcess(
        OpenProcess(PROCESS_TERMINATE, BOOL(0),
        FProcessEntry32.th32ProcessID), 0)) then
        MessageBoxEx(Application.Handle,
          'Can`t kill windows kernel...',
          'Warning', MB_ICONWarning + MB_OK, $0419);
    ContinueLoop := Process32Next(FSnapshotHandle, FProcessEntry32);
  end;
  CloseHandle(FSnapshotHandle);
end;
</pre>
<p class="author">Автор: <a href="mailto:Nomadic@newmail.ru" target="_blank">Nomadic</a></p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<hr />
<p>Этот код можно использовать в языках высокого уровня (Delphi, C, ...), для этого воспользуйтесь правилами. Исходники примера можно взять здесь: Dos (Pascal 7.0), Win (Delphi 5).</p>
<p>WIN:</p>
<p>cli ;отключение внешних прерываний </p>
<p>@A: ;метка</p>
<p>jmp @A ;зацикливание</p>
<p>DOS:</p>
<p>cli ;отключение внешних прерываний </p>
<p>hlt ;выход из программы</p>
