---
Title: Перехват API функций на примере MessageBoxA
Author: Song
Date: 01.01.2007
---


Перехват API функций на примере MessageBoxA
===========================================

::: {.date}
01.01.2007
:::

DLL:

    library Mouse_mes;
     
    uses
      sysutils,
      windows,
      messages;
     
    type
       TImageImportDescriptor=packed record
        OriginalFirstThunk    : DWORD;
        TimeDateStamp         : DWORD;
        ForwarderChain        : DWORD;
        Name                  : DWORD;
        FirstThunk            : DWORD;
      end;
      PImageImportDescriptor=^TImageImportDescriptor;
     
    var filename:array[0..max_path-1] of char;
        hook:HHook=0;
        PEHeader:PImageNtHeaders;
        ImageBase:cardinal;
     
    function MyHookProcedure(hWnd: HWND; lpText, lpCaption: PWideChar; uType: UINT): Integer;
    stdcall;
    begin
      result:=MessageBoxA(0, 'Notepad', 'my hook', 0);
      //Но уже через нашу табл. импорта
    end;
     
    procedure ProcessImports(PImports:PImageImportDescriptor);
        Var
            PImport:PImageImportDescriptor;
            PRVA_Import:LPDWORD;
            ProcAddress:pointer;
            Temp_Cardinal:cardinal;
        begin{1}
          ProcAddress:=GetProcAddress(GetModuleHandle('USER32.DLL'), 'MessageBoxA');
          PImport:=PImports;
          while PImport.Name<>0 do
            begin{2}
              PRVA_Import:=LPDWORD(pImport.FirstThunk+ImageBase);
              while PRVA_Import^<>0 do
              begin{3}
                if PPointer(PRVA_Import)^=ProcAddress
                   then
                     begin{4}
                       VirtualProtect(PPointer(PRVA_Import),4,PAGE_READWRITE,Temp_Cardinal);
                       PPointer(PRVA_Import)^:=@MyHookProcedure; //пишем свою...
                      VirtualProtect(PPointer(PRVA_Import),4,Temp_Cardinal,Temp_Cardinal);
                     end;{1}
                Inc(PRVA_Import);
              end;{2}
           Inc(PImport);
       end;{3}
    end;{4}
     
    procedure DllEntryPoint(reson:longint);stdcall;
    begin
     case reson of
      DLL_PROCESS_ATTACH:
         begin
          DisableThreadLibraryCalls(hInstance);
          ZeroMemory(@FileName, SizeOf(FileName));
          GetModuleFileName(GetModuleHandle(nil), @FileName, SizeOf(FileName));
     
             if Pos('NOTEPAD.EXE',AnsiUpper(@FileName))<>0 then //сейчас я хочу попробовать все это дело надо  нотепадом
             begin
               ImageBase:=GetModuleHandle(nil);
               PEHeader:=pointer(int64(ImageBase)+PImageDosHeader(ImageBase)._lfanew);//pe header
              ProcessImports(pointer(PEHeader.OptionalHeader.DataDirectory[IMAGE_DIRECTORY_ENTRY_IMPORT].VirtualAddress+ImageBase));
              end;
          end;
      end;
    end;
     
    function nexthook(code:integer;wParam,lParam:longint):longint;stdcall;
    begin
      result:=callnexthookex(hook,code,wParam,lParam);
    end;
     
    procedure sethook(flag:bool);export; stdcall;
    begin
     if flag then
        hook:=setwindowshookex(wh_getmessage,@nexthook,hInstance,0)
     else
       begin
        unhookwindowshookex(hook);
        hook:=0;
       end;
    end;
     
    exports sethook;
     
    begin
      DLLProc:=@DllEntryPoint;
      DllEntryPoint(DLL_PROCESS_ATTACH)
    end.

EXE:

    program Project2;
    uses windows;
     
    var
       sethook:procedure(flag:bool)stdcall;
       hDll:hModule;
     
    begin
      hDll:=LoadLibrary('Mouse_mes.dll');
      @sethook:=GetProcAddress(hDll, 'sethook');
      sethook(true);
      messagebox(0,'Не закрывай, пока идет работа','',0);
      sethook(false);
      FreeLibrary(hDll);
    end.

Автор: Song

Взято из <https://forum.sources.ru>
