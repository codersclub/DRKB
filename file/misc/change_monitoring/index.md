---
Title: Мониторинг изменений на диске
Author: Rouse_
Date: 01.01.2007
---


Мониторинг изменений на диске
=============================

Вариант 1:

Author: Rouse\_

Source: <https://forum.sources.ru>

Как определяешь наличие новых файлов? По таймеру или через
ReadDirectoryChangesW? Если по таймеру, то оставь его и попробуй вот
такой код (тебя интересует флаг FILE\_NOTIFY\_CHANGE\_CREATION):

    unit Unit1;
     
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      PFileNotifyInformation = ^TFileNotifyInformation;
      TFileNotifyInformation = record
        NextEntryOffset: DWORD;
        Action: DWORD;
        FileNameLength: DWORD;
        FileName: array [0..MAX_PATH - 1] of WideChar;
      end;
     
      TForm1 = class(TForm)
        Memo1: TMemo;
        procedure FormCreate(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.FormCreate(Sender: TObject);
    const
      Filter =  FILE_NOTIFY_CHANGE_FILE_NAME or
                FILE_NOTIFY_CHANGE_DIR_NAME or
                FILE_NOTIFY_CHANGE_ATTRIBUTES or
                FILE_NOTIFY_CHANGE_SIZE or
                FILE_NOTIFY_CHANGE_LAST_WRITE or
                FILE_NOTIFY_CHANGE_LAST_ACCESS or
                FILE_NOTIFY_CHANGE_CREATION or
                FILE_NOTIFY_CHANGE_SECURITY;
    var
      Dir: THandle;
      Notify: TFileNotifyInformation;
      BytesReturned: DWORD;
    begin
      Dir := CreateFile('d:\', GENERIC_READ,
        FILE_SHARE_READ or FILE_SHARE_WRITE or FILE_SHARE_DELETE,
        nil, OPEN_EXISTING, FILE_FLAG_BACKUP_SEMANTICS, 0);
      if Dir <> INVALID_HANDLE_VALUE then
      try
        if not ReadDirectoryChangesW(Dir, @Notify, SizeOf(TFileNotifyInformation),
          False, Filter, @BytesReturned, nil, nil) then
          raise Exception.Create(SysErrorMessage(GetLastError))
        else
          case Notify.Action of
            FILE_ACTION_ADDED: ShowMessage('New file' + Notify.FileName);
            FILE_ACTION_REMOVED: ShowMessage('Delete file' + Notify.FileName);
            FILE_ACTION_MODIFIED: ShowMessage('Modify file' + Notify.FileName);
            FILE_ACTION_RENAMED_OLD_NAME: ShowMessage('Old Name file' + Notify.FileName);
            FILE_ACTION_RENAMED_NEW_NAME: ShowMessage('New Name file' + Notify.FileName);
          end;
      finally
        CloseHandle(Dir);
      end;
    end;
     
    end.


------------------------------------------------------------------------
Вариант 2:

Author: Krid

Source: <https://forum.sources.ru>

PS: только для NT/2000/XP/2003

    unit wfsU;
     
    interface
     
    type
     // Структура с информацией об изменении в файловой системе (передается в callback процедуру)
     
      PInfoCallback = ^TInfoCallback;
      TInfoCallback = record
        FAction      : Integer; // тип изменения (константы FILE_ACTION_XXX)
        FDrive       : string;  // диск, на котором было изменение
        FOldFileName : string;  // имя файла до переименования
        FNewFileName : string;  // имя файла после переименования
      end;
     
      // callback процедура, вызываемая при изменении в файловой системе
      TWatchFileSystemCallback = procedure (pInfo: TInfoCallback);
     
    { Запуск мониторинга файловой системы
      Праметры:
      pName    - имя папки для мониторинга
      pFilter  - комбинация констант FILE_NOTIFY_XXX
      pSubTree - мониторить ли все подпапки заданной папки
      pInfoCallback - адрес callback процедуры, вызываемой при изменении в файловой системе}
    procedure StartWatch(pName: string; pFilter: cardinal; pSubTree: boolean; pInfoCallback: TWatchFileSystemCallback);
    // Остановка мониторинга
    procedure StopWatch;
     
    implementation
     
    uses
      Classes, Windows, SysUtils;
     
    const
      FILE_LIST_DIRECTORY   = $0001;
     
    type
      PFileNotifyInformation = ^TFileNotifyInformation;
      TFileNotifyInformation = record
        NextEntryOffset : DWORD;
        Action          : DWORD;
        FileNameLength  : DWORD;
        FileName        : array[0..0] of WideChar;
      end;
     
      WFSError = class(Exception);
     
      TWFS = class(TThread)
      private
        FName           : string;
        FFilter         : Cardinal;
        FSubTree        : boolean;
        FInfoCallback   : TWatchFileSystemCallback;
        FWatchHandle    : THandle;
        FWatchBuf       : array[0..4096] of Byte;
        FOverLapp       : TOverlapped;
        FPOverLapp      : POverlapped;
        FBytesWritte    : DWORD;
        FCompletionPort : THandle;
        FNumBytes       : Cardinal;
        FOldFileName    : string;
        function CreateDirHandle(aDir: string): THandle;
        procedure WatchEvent;
        procedure HandleEvent;
      protected
        procedure Execute; override;
      public
        constructor Create(pName: string; pFilter: cardinal; pSubTree: boolean; pInfoCallback: TWatchFileSystemCallback);
        destructor Destroy; override;
      end;
     
     
    var
      WFS : TWFS;
     
    procedure StartWatch(pName: string; pFilter: cardinal; pSubTree: boolean; pInfoCallback: TWatchFileSystemCallback);
    begin
     WFS:=TWFS.Create(pName, pFilter, pSubTree, pInfoCallback);
    end;
     
    procedure StopWatch;
    var
      Temp : TWFS;
    begin
      if Assigned(WFS) then
      begin
       PostQueuedCompletionStatus(WFS.FCompletionPort, 0, 0, nil);
       Temp := WFS;
       WFS:=nil;
       Temp.Terminate;
      end;
    end;
     
    constructor TWFS.Create(pName: string; pFilter: cardinal; pSubTree: boolean; pInfoCallback: TWatchFileSystemCallback);
    begin
      inherited Create(True);
      FreeOnTerminate:=True;
      FName:=IncludeTrailingBackslash(pName);
      FFilter:=pFilter;
      FSubTree:=pSubTree;
      FOldFileName:=EmptyStr;
      ZeroMemory(@FOverLapp, SizeOf(TOverLapped));
      FPOverLapp:=@FOverLapp;
      ZeroMemory(@FWatchBuf, SizeOf(FWatchBuf));
      FInfoCallback:=pInfoCallback;
      Resume
    end;
     
    destructor TWFS.Destroy;
    begin
      PostQueuedCompletionStatus(FCompletionPort, 0, 0, nil);
      CloseHandle(FWatchHandle);
      FWatchHandle:=0;
      CloseHandle(FCompletionPort);
      FCompletionPort:=0;
      inherited Destroy;
    end;
     
    function TWFS.CreateDirHandle(aDir: string): THandle;
    begin
    Result:=CreateFile(PChar(aDir), FILE_LIST_DIRECTORY, FILE_SHARE_READ+FILE_SHARE_DELETE+FILE_SHARE_WRITE,
                       nil,OPEN_EXISTING, FILE_FLAG_BACKUP_SEMANTICS or FILE_FLAG_OVERLAPPED, 0);
    end;
     
    procedure TWFS.Execute;
    begin
      FWatchHandle:=CreateDirHandle(FName);
      WatchEvent;
    end;
     
    procedure TWFS.HandleEvent;
    var
      FileNotifyInfo : PFileNotifyInformation;
      InfoCallback   : TInfoCallback;
      Offset         : Longint;
    begin
      Pointer(FileNotifyInfo) := @FWatchBuf[0];
      repeat
        Offset:=FileNotifyInfo^.NextEntryOffset;
        InfoCallback.FAction:=FileNotifyInfo^.Action;
        InfoCallback.FDrive:=FName;
        SetString(InfoCallback.FNewFileName,FileNotifyInfo^.FileName,FileNotifyInfo^.FileNameLength);
        InfoCallback.FNewFileName:=Trim(InfoCallback.FNewFileName);
        case FileNotifyInfo^.Action of
          FILE_ACTION_RENAMED_OLD_NAME: FOldFileName:=Trim(WideCharToString(@(FileNotifyInfo^.FileName[0])));
          FILE_ACTION_RENAMED_NEW_NAME: InfoCallback.FOldFileName:=FOldFileName;
        end;
        FInfoCallback(InfoCallback);
        PChar(FileNotifyInfo):=PChar(FileNotifyInfo)+Offset;
      until (Offset=0) or Terminated;
    end;
     
    procedure TWFS.WatchEvent;
    var
     CompletionKey: Cardinal;
    begin
      FCompletionPort:=CreateIoCompletionPort(FWatchHandle, 0, Longint(pointer(self)), 0);
      ZeroMemory(@FWatchBuf, SizeOf(FWatchBuf));
      if not ReadDirectoryChanges(FWatchHandle, @FWatchBuf, SizeOf(FWatchBuf), FSubTree,
        FFilter, @FBytesWritte,  @FOverLapp, nil) then
      begin
        raise WFSError.Create(SysErrorMessage(GetLastError));
        Terminate;
      end else
      begin
        while not Terminated do
        begin
          GetQueuedCompletionStatus(FCompletionPort, FNumBytes, CompletionKey, FPOverLapp, INFINITE);
          if CompletionKey<>0 then
          begin
            Synchronize(HandleEvent);
            ZeroMemory(@FWatchBuf, SizeOf(FWatchBuf));
            FBytesWritte:=0;
            ReadDirectoryChanges(FWatchHandle, @FWatchBuf, SizeOf(FWatchBuf), FSubTree, FFilter,
                                 @FBytesWritte, @FOverLapp, nil);
          end else Terminate;
        end
      end
    end;
     
    end.


Пример использования:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses wfsU;
     
     procedure MyInfoCallback(pInfo: TInfoCallback);
     const
        Action: array[1..3] of String = ('Создание: %s', 'Удаление: %s', 'Изменение: %s');
     begin
        case pInfo.FAction of
          FILE_ACTION_RENAMED_NEW_NAME: Form1.Memo1.Lines.Add(Format('Переименование: %s в %s',
              [pInfo.FDrive+pInfo.FOldFileName,pInfo.FDrive+pInfo.FNewFileName]));
        else
          if pInfo.FAction<FILE_ACTION_RENAMED_OLD_NAME then
            Form1.Memo1.Lines.Add(Format(Action[pInfo.Faction], [pInfo.FDrive+pInfo.FNewFileName]));
        end;
     end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // мониторим, например, изменения всех папок на диске C: (создание, удаление, переименование)
     StartWatch('C:\', FILE_NOTIFY_CHANGE_DIR_NAME, True, @MyInfoCallback);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     StopWatch
    end;
     
    end.

