---
Title: Аналог DumpBin
Author: x2er0
Date: 01.01.2007
---


Аналог DumpBin
==============

::: {.date}
01.01.2007
:::

Иногда на форуме проскакивает такой вопрос: "Как можно поглядеть
экспортируемые функции какой либо DLL\'ины?".

Можно конечно же воспользоваться стандартными утилитами, но можно
попробовать написать и что нить свое.

Сейчас я попробую показать такой пример. Напишем пример, который делает
именно это - вытаскивает экспорт модуля.

Подробно расписывать тут ничего не буду, тут идет разбор элементов PE
заголовка - нахождение таблицы экспорта,

перечисление ф-ий. Недостаток этого примера в том, что он работает уже с
подгруженными модулями, т.к. для нахождения

базы используется GetModuleHandle().

Вставка:

The GetModuleHandle function returns a module handle for the specified
module if the file has been mapped into the address

space of the calling process.

Для расширения возможностей - простмотра всех модулей, надо использовать

что нить другое, например "мэпирование" (CreateFileMapping() итд).
Ведь надо хоть что нить самому сделать....

    program ExpDump;
     
    uses windows;
     
    var
        ImageBase : DWord;
        DosHeader : PImageDosHeader;
        PeHeader  : PImageNtHeaders;
        PExport   : PImageExportDirectory;
        pname     : PDWord;
        name      : PChar;
        i         : Integer;
        cmdline   : string;
     
    //#### ?-??: ????? ? ????
    function Dump(const log: PChar): boolean;
    Var hFile     : THandle;
        dwError   : DWord;
        dwWritten : DWord;
        buffer    : PChar;
    begin
     hFile := CreateFile(PChar(cmdline + '_fexport.txt'), GENERIC_WRITE, 0, nil, OPEN_ALWAYS, FILE_ATTRIBUTE_NORMAL, 0);
     if (hFile = INVALID_HANDLE_VALUE) then begin
      result := FALSE;
      exit;
     end;
     
     dwError := SetFilePointer(hFile, 0, nil, FILE_END);
     if (dwError = $FFFFFFFF) then begin
      CloseHandle(hFile);
      result := FALSE;
      exit;
     end;
     
     buffer := PChar(log + #13#10);
     WriteFile(hFile, buffer^, length(buffer), dwWritten, nil);
     if (dwWritten < DWord(length(buffer))) then begin
      CloseHandle(hFile);
      result := FALSE;
      exit;
     end;
     CloseHandle(hFile);
     result := TRUE;
    end;
    //####
     
    //#### Start
    begin
      if (ParamCount < 1) then halt(0) else cmdline := ParamStr(1);
     
      ImageBase := GetModuleHandle(PChar(cmdline));
      if (ImageBase = 0) then begin
        MessageBox(0, 'Error Load Module', 'Error', MB_OK);
        halt(0);
      end;
     
      DosHeader := PImageDosHeader(ImageBase);
      if (DosHeader^.e_magic <> IMAGE_DOS_SIGNATURE) then begin
        MessageBox(0,'Error Dos Header','Error',MB_OK);
        halt(0);
      end;
     
      PEHeader := PImageNtHeaders(DWord(ImageBase) + DWord(DosHeader^._lfanew));
      if (PEHeader^.Signature <> IMAGE_NT_SIGNATURE) then begin
        MessageBox(0,'Error PE Header', 'Error', MB_OK);
        halt(0);
      end;
     
      PExport := PImageExportDirectory(ImageBase + DWord(PEHeader^.OptionalHeader.DataDirectory[IMAGE_DIRECTORY_ENTRY_EXPORT].VirtualAddress));
      pname   := PDWord(ImageBase + DWord(PExport^.AddressOfNames));
     
     
      Dump(PChar('Programm ExpDump =)'));
      Dump(PChar(cmdline + ' functions:'));
      Dump(PChar(#13#10));
     
      For i := 0 to PExport^.NumberOfNames - 1 do begin
       name := PChar(PDWord(DWord(ImageBase)  + PDword(pname)^));
       if (not Dump(name)) then halt(0);
       inc(pname);
      end;
    end.
    //#### End 

Пример использования:

ExpDump.Exe User32.dll

В рехультате:

Programm ExpDump =)

user32.dll functions:

ActivateKeyboardLayout

AdjustWindowRect

AdjustWindowRectEx

AlignRects

AllowForegroundActivation

AllowSetForegroundWindow

AnimateWindow

AnyPopup

AppendMenuA

AppendMenuW

ArrangeIconicWindows

AttachThreadInput

BeginDeferWindowPos

BeginPaint

BlockInput

...

Для улучшения можно доделать так:

    ImageBase := GetModuleHandle(PChar(cmdline));
      if (ImageBase = 0) then begin
        ImageBase := LoadLibrary(PChar(cmdline));
        if (ImageBase = 0) then begin
         MessageBox(0, 'Error Load Module', 'Error', MB_OK);
         halt(0);
        end;
      end;

И не забудте в конце FreeLibrary()

Автор: x2er0

Взято из <https://forum.sources.ru>
