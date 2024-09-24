---
Title: Как получить список кнопок на таскбаре?
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как получить список кнопок на таскбаре?
=======================================

    uses CommCtrl;
     
    function GetModuleFileNameExW(hProcess:THandle; hModule:HMODULE;
             lpFilename:PWideChar; nSize:DWORD):DWORD;
             stdcall; external 'PSAPI.DLL';
     
    const 
     ICON_SMALL2 = 2;
     
    function WindowGetEXE(wnd:HWND):string;
    var
     wt:array[0..MAX_PATH-1] of WChar;
     r:integer;
     prc:THandle;
     prcID:cardinal;
    begin
     result:='';
     if GetWindowThreadProcessID(wnd,prcID)<>0 then
     begin
      prc:=OpenProcess(PROCESS_ALL_ACCESS,false,prcID);
      if prc<>0 then
      try
        r:=GetModuleFileNameExW(prc,0,wt,MAX_PATH*2);
       if r<>0 then result:=wt;
      finally
       CloseHandle(prc)
      end
     end
    end;
     
    function WindowGetIcon(wnd:HWND; fSmall:boolean):Cardinal;
    var
     defIcon:HICON;
     r,iType1,iType2: integer;
    begin
     defIcon:=LoadIcon(0,IDI_APPLICATION);
     if fSmall then
     begin iType1:=ICON_SMALL2; iType2:= GCL_HICONSM; end else
     begin iType1:=ICON_BIG; iType2:= GCL_HICON; end;
     
     r:=SendMessageTimeOut(wnd,WM_GETICON,iType1,0,
                           SMTO_ABORTIFHUNG or SMTO_NOTIMEOUTIFNOTHUNG,
                           100, result);
     if (r=0) then result:=defIcon else
     begin
      if (result=0) then  result:=GetClassLong(wnd,iType2);
      if (result=0) then  result:=defIcon
     end;
    end;
     
    function EnumWindowsProc(wnd:HWND; lParam: LPARAM):BOOL; stdcall;
    var
     wn:array[0..MAX_PATH-1] of char;
    begin
     result:=true;
     if IsWindowVisible(wnd) and (GetParent(wnd)=0) and (GetWindow(wnd,GW_OWNER)=0) and
     ((GetWindowLong(wnd,GWL_EXSTYLE) and WS_EX_TOOLWINDOW)=0)  then
     begin
      GetWindowText(wnd,wn,MAX_PATH);
      with Form1.ListView1.Items.Add do
      begin
       Caption :=wn; // заголовок
       SubItems.Add(IntToStr(wnd)); // дескриптор
       SubItems.Add(WindowGetEXE(wnd)); // exe
       SubItems.Add(' '); // колонка для большой иконки
       ImageIndex:=ImageList_AddIcon(Form1.ImageList1.Handle,WindowGetIcon(wnd,true)); // маленькая иконка
       SubItemImages[2] := ImageList_AddIcon(Form1.ImageList2.Handle,WindowGetIcon(wnd,false)); // большая иконка
      end;
     end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     ListView1.Clear;
     ImageList1.Clear;
     ImageList2.Clear;
     EnumWindows(@EnumWindowsProc,0);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     // ImageList1 - 16x16;  ImageList2 - 32x32;
     ListView1.SmallImages:=ImageList1;
     ListView1.LargeImages:=ImageList2;
    end;

