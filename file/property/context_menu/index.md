---
Title: Как показать контекстное меню для конкретного файла?
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как показать контекстное меню для конкретного файла?
====================================================

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Unit Name : Unit1
    //  * Purpose   : Демо отображения системного контекстного меню эксплорера
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls,
      // Чтоб все заработало - подключаем вот эти 2 юнита
      ShlObj,
      ActiveX;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    // Это для работы самого меню, как оконного элемента
    function MenuCallback(Wnd: HWND; Msg: UINT; WParam: WPARAM;
     LParam: LPARAM): LRESULT; stdcall;
    var
      ContextMenu2: IContextMenu2;
    begin
      case Msg of
        WM_CREATE:
        begin
          ContextMenu2 := IContextMenu2(PCreateStruct(lParam).lpCreateParams);
          SetWindowLong(Wnd, GWL_USERDATA, Longint(ContextMenu2));
          Result := DefWindowProc(Wnd, Msg, wParam, lParam);
        end;
        WM_INITMENUPOPUP:
        begin
          ContextMenu2 := IContextMenu2(GetWindowLong(Wnd, GWL_USERDATA));
          ContextMenu2.HandleMenuMsg(Msg, wParam, lParam);
          Result := 0;
        end;
        WM_DRAWITEM, WM_MEASUREITEM:
        begin
          ContextMenu2 := IContextMenu2(GetWindowLong(Wnd, GWL_USERDATA));
          ContextMenu2.HandleMenuMsg(Msg, wParam, lParam);
          Result := 1;
        end;
      else
        Result := DefWindowProc(Wnd, Msg, wParam, lParam);
      end;
    end;
     
    // Это для создания самого меню, как оконного элемента
    function CreateMenuCallbackWnd(const ContextMenu: IContextMenu2): HWND;
    const
      IcmCallbackWnd = 'ICMCALLBACKWND';
    var
      WndClass: TWndClass;
    begin
      FillChar(WndClass, SizeOf(WndClass), #0);
      WndClass.lpszClassName := PChar(IcmCallbackWnd);
      WndClass.lpfnWndProc := @MenuCallback;
      WndClass.hInstance := HInstance;
      Windows.RegisterClass(WndClass);
      Result := CreateWindow(IcmCallbackWnd, IcmCallbackWnd, WS_POPUPWINDOW, 0,
        0, 0, 0, 0, 0, HInstance, Pointer(ContextMenu));
    end;
     
    procedure GetProperties(Path: String; MousePoint: TPoint; WC: TWinControl);
    var
      CoInit, AResult: HRESULT;
      CommonDir, FileName: String;
      Desktop, ShellFolder: IShellFolder;
      pchEaten, Attr: Cardinal;
      PathPIDL: PItemIDList;
      FilePIDL: array [0..1] of PItemIDList;
      ShellContextMenu: HMenu;
      ICMenu: IContextMenu;
      ICMenu2: IContextMenu2;
      PopupMenuResult: BOOL;
      CMD: TCMInvokeCommandInfo;
      M: IMAlloc;
      ICmd: Integer;
      CallbackWindow: HWND;
    begin
      // Первичная инициализация
      ShellContextMenu := 0;
      Attr := 0;
      PathPIDL := nil;
      CallbackWindow := 0;
      CoInit := CoInitializeEx(nil, COINIT_MULTITHREADED);
      try
        // Получаем пути и имя фала
        CommonDir := ExtractFilePath(Path);
        FileName := ExtractFileName(Path);
        // Получаем указатель на интерфейс рабочего стола
        if SHGetDesktopFolder(Desktop) <> S_OK then
          RaiseLastOSError;
        // Если работаем с папкой
        if FileName = '' then
        begin
          // Получаем указатель на папку "Мой компьютер"
          if (SHGetSpecialFolderLocation(0, CSIDL_DRIVES, PathPIDL) <> S_OK) or
            (Desktop.BindToObject(PathPIDL,  nil,  IID_IShellFolder,
              Pointer(ShellFolder)) <> S_OK) then RaiseLastOSError;
          // Получаем указатель на директорию
          ShellFolder.ParseDisplayName(WC.Handle, nil, StringToOleStr(CommonDir),
            pchEaten, FilePIDL[0], Attr);
          // Получаем указатель на контектсное меню папки
          AResult := ShellFolder.GetUIObjectOf(WC.Handle, 1, FilePIDL[0],
            IID_IContextMenu, nil, Pointer(ICMenu));
        end
        else
        begin
          // Получаем указатель на папку "Мой компьютер"
          if (Desktop.ParseDisplayName(WC.Handle, nil, StringToOleStr(CommonDir),
            pchEaten, PathPIDL, Attr) <> S_OK) or
            (Desktop.BindToObject(PathPIDL, nil, IID_IShellFolder,
              Pointer(ShellFolder)) <> S_OK) then RaiseLastOSError;
          // Получаем указатель на файл
          ShellFolder.ParseDisplayName(WC.Handle, nil, StringToOleStr(FileName),
            pchEaten, FilePIDL[0], Attr);
          // Получаем указатель на контектсное меню файла
          AResult := ShellFolder.GetUIObjectOf(WC.Handle, 1, FilePIDL[0],
            IID_IContextMenu, nil, Pointer(ICMenu));
        end;
     
        // Если указатель на конт. меню есть, делаем так:
        if Succeeded(AResult) then
        begin
          ICMenu2 := nil;
          // Создаем меню
          ShellContextMenu := CreatePopupMenu;
          // Производим его наполнение
          if Succeeded(ICMenu.QueryContextMenu(ShellContextMenu, 0,
            1, $7FFF, CMF_EXPLORE)) and
            Succeeded(ICMenu.QueryInterface(IContextMenu2, ICMenu2)) then
              CallbackWindow := CreateMenuCallbackWnd(ICMenu2);
          try
            // Показываем меню
            PopupMenuResult := TrackPopupMenu(ShellContextMenu, TPM_LEFTALIGN or TPM_LEFTBUTTON
              or TPM_RIGHTBUTTON or TPM_RETURNCMD,
              MousePoint.X, MousePoint.Y, 0, CallbackWindow, nil);
          finally
            ICMenu2 := nil;
          end;
          // Если был выбран какой либо пункт меню:
          if PopupMenuResult then
          begin
            // Индекс этого пункта будет лежать в ICmd
            ICmd := LongInt(PopupMenuResult) - 1;
            // Заполняем структуру TCMInvokeCommandInfo
            FillChar(CMD, SizeOf(CMD), #0);
            with CMD do
            begin
              cbSize := SizeOf(CMD);
              hWND := WC.Handle;
              lpVerb := MakeIntResource(ICmd);
              nShow := SW_SHOWNORMAL;
            end;
            // Выполняем InvokeCommand с заполненной структурой
            AResult := ICMenu.InvokeCommand(CMD);
            if AResult <> S_OK then RaiseLastOSError;
           end;
        end;
      finally
        // Освобождаем занятые ресурсы чтобы небыло утечки памяти
        if FilePIDL[0] <> nil then
        begin
          // Для освобождения использем IMalloc
          SHGetMAlloc(M);
          if M <> nil then
            M.Free(FilePIDL[0]);
          M:=nil;
        end;
        if PathPIDL <> nil then
        begin
          SHGetMAlloc(M);
          if M <> nil then
            M.Free(PathPIDL);
          M:=nil;
        end;
        if ShellContextMenu <>0 then
          DestroyMenu(ShellContextMenu);
        if CallbackWindow <> 0 then
          DestroyWindow(CallbackWindow);
        ICMenu := nil;
        ShellFolder := nil;
        Desktop := nil;
        if CoInit = S_OK then CoUninitialize;
      end;
    end;
     
    // Пример использования
    procedure TForm1.Button1Click(Sender: TObject);
    var
      pt: TPoint;
    begin
      GetCursorPos(pt);
      GetProperties('E:\Guardant\INSTDRV.INI', pt, Self);
    end;
     
    end.


Автор: Rouse\_
