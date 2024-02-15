---
Title: Как повесить винду
Author: [Nomadic](mailto:Nomadic@newmail.ru)
Date: 01.01.2007
---


Как повесить винду
==================

::: {.date}
01.01.2007
:::

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
      while integer(ContinueLoop) <> 0 do
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

Автор: [Nomadic](mailto:Nomadic@newmail.ru)

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Этот код можно использовать в языках высокого уровня (Delphi, C, ...),
для этого воспользуйтесь правилами. Исходники примера можно взять здесь:
Dos (Pascal 7.0), Win (Delphi 5).

WIN:

cli ;отключение внешних прерываний

@A: ;метка

jmp @A ;зацикливание

DOS:

cli ;отключение внешних прерываний

hlt ;выход из программы
