---
Title: Получение уведомлений от оболочки (Shell)
Author: <maniac_n@hotmail.com>
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Получение уведомлений от оболочки (Shell)
=========================================

Пример показывает - как можно отслеживать практически все события
происходящий в Вашей оболочке. Код находится в процессе разработки, но
уже содержит в себе большое количество возможностей.

    {$IFNDEF VER80} {$IFNDEF VER90} {$IFNDEF VER93}
    {$DEFINE Delphi3orHigher}
    {$ENDIF} {$ENDIF} {$ENDIF}
     
    unit ShellNotify;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Controls, Forms, Dialogs,
      {$IFNDEF Delphi3orHigher} OLE2, {$ELSE} ActiveX, ComObj, {$ENDIF}
      ShlObj;
     
     
    type
      NOTIFYREGISTER = record
        pidlPath : PItemIDList;
        bWatchSubtree : boolean;
    end;
     
    PNOTIFYREGISTER = ^NOTIFYREGISTER;
     
    const
      SNM_SHELLNOTIFICATION = WM_USER +1;
      SHCNF_ACCEPT_INTERRUPTS = $0001;
      SHCNF_ACCEPT_NON_INTERRUPTS = $0002;
      SHCNF_NO_PROXY = $8000;
     
    type
      TNotificationEvent = (neAssociationChange, neAttributesChange,
        neFileChange, neFileCreate, neFileDelete, neFileRename,
        neDriveAdd, neDriveRemove, neShellDriveAdd, neDriveSpaceChange,
        neMediaInsert, neMediaRemove, neFolderCreate, neFolderDelete,
        neFolderRename, neFolderUpdate, neNetShare, neNetUnShare,
        neServerDisconnect, neImageListChange);
      TNotificationEvents = set of TNotificationEvent;
     
      TShellNotificationEvent1 = procedure(Sender: TObject;
        Path: string) of object;
      TShellNotificationEvent2 = procedure(Sender: TObject;
        path1, path2: string) of object;
      // TShellNotificationAttributesEvent = procedure(Sender: TObject;
      // OldAttribs, NewAttribs: Integer) of Object;
     
      TShellNotification = class( TComponent )
        private
          fWatchEvents: TNotificationEvents;
          fPath: string;
          fActive, fWatch: Boolean;
     
          prevPath1, prevPath2: string;
          PrevEvent: Integer;
     
          Handle, NotifyHandle: HWND;
     
          fOnAssociationChange: TNotifyEvent;
          fOnAttribChange: TShellNotificationEvent2;
          FOnCreate: TShellNotificationEvent1;
          FOnDelete: TShellNotificationEvent1;
          FOnDriveAdd: TShellNotificationEvent1;
          FOnDriveAddGui: TShellNotificationEvent1;
          FOnDriveRemove: TShellNotificationEvent1;
          FOnMediaInsert: TShellNotificationEvent1;
          FOnMediaRemove: TShellNotificationEvent1;
          FOnDirCreate: TShellNotificationEvent1;
          FOnNetShare: TShellNotificationEvent1;
          FOnNetUnShare: TShellNotificationEvent1;
          FOnRenameFolder: TShellNotificationEvent2;
          FOnItemRename: TShellNotificationEvent2;
          FOnFolderRemove: TShellNotificationEvent1;
          FOnServerDisconnect: TShellNotificationEvent1;
          FOnFolderUpdate: TShellNotificationEvent1;
     
          function PathFromPidl(Pidl: PItemIDList): string;
          procedure SetWatchEvents(const Value: TNotificationEvents);
          function GetActive: Boolean;
          procedure SetActive(const Value: Boolean);
          procedure SetPath(const Value: string);
          procedure SetWatch(const Value: Boolean);
        protected
          procedure ShellNotifyRegister;
          procedure ShellNotifyUnregister;
          procedure WndProc(var message: TMessage);
     
          procedure DoAssociationChange; dynamic;
          procedure DoAttributesChange(Path1, Path2: string); dynamic;
          procedure DoCreateFile(Path: string); dynamic;
          procedure DoDeleteFile(Path: string); dynamic;
          procedure DoDriveAdd(Path:string); dynamic;
          procedure DoDriveAddGui(Path: string); dynamic;
          procedure DoDriveRemove(Path: string); dynamic;
          procedure DoMediaInsert(Path: string); dynamic;
          procedure DoMediaRemove(Path: string); dynamic;
          procedure DoDirCreate(Path: string); dynamic;
          procedure DoNetShare(Path: string); dynamic;
          procedure DoNetUnShare(Path: string); dynamic;
          procedure DoRenameFolder(Path1, Path2: string); dynamic;
          procedure DoRenameItem(Path1, Path2: string); dynamic;
          procedure DoFolderRemove(Path: string); dynamic;
          procedure DoServerDisconnect(Path: string); dynamic;
          procedure DoDirUpdate(Path: string); dynamic;
        public
          constructor Create(AOwner: TComponent); override;
          destructor Destroy; override;
        published
          property Path: string
            read fPath write SetPath;
    
          property Active: Boolean
            read GetActive write SetActive;
    
          property WatchSubTree: Boolean
            read fWatch write SetWatch;
     
          property WatchEvents: TNotificationEvents
            read fWatchEvents write SetWatchEvents;
     
          property OnAssociationChange: TNotifyEvent
            read fOnAssociationChange write FOnAssociationChange;
     
          property OnAttributesChange: TShellNotificationEvent2
            read fOnAttribChange write fOnAttribChange;
     
          property OnFileCreate: TShellNotificationEvent1
            read FOnCreate write FOnCreate;
     
          property OnFolderRename: TShellNotificationEvent2
            read FOnRenameFolder write FOnRenameFolder;
     
          property OnFolderUpdate: TShellNotificationEvent1
            read FOnFolderUpdate write FOnFolderUpdate;
     
          property OnFileDelete: TShellNotificationEvent1
            read FOnDelete write FOnDelete;
     
          property OnDriveAdd: TShellNotificationEvent1
            read FOnDriveAdd write FOnDriveAdd;
     
          property OnFolderRemove: TShellNotificationEvent1
            read FOnFolderRemove write FOnFolderRemove;
     
          property OnItemRename: TShellNotificationEvent2
            read FOnItemRename write FOnItemRename;
     
          property OnDriveAddGui: TShellNotificationEvent1
            read FOnDriveAddGui write FOnDriveAddGui;
     
          property OnDriveRemove: TShellNotificationEvent1
            read FOnDriveRemove write FOnDriveRemove;
     
          property OnMediaInserted: TShellNotificationEvent1
            read FOnMediaInsert write FOnMediaInsert;
     
          property OnMediaRemove: TShellNotificationEvent1
            read FOnMediaRemove write FOnMediaRemove;
     
          property OnDirCreate: TShellNotificationEvent1
            read FOnDirCreate write FOnDirCreate;
     
          property OnNetShare: TShellNotificationEvent1
            read FOnNetShare write FOnNetShare;
     
          property OnNetUnShare: TShellNotificationEvent1
            read FOnNetUnShare write FOnNetUnShare;
     
          property OnServerDisconnect: TShellNotificationEvent1
            read FOnServerDisconnect write FOnServerDisconnect;
    end;
     
    function SHChangeNotifyRegister( hWnd: HWND; dwFlags: integer;
      wEventMask : cardinal; uMsg: UINT; cItems : integer;
      lpItems : PNOTIFYREGISTER) : HWND; stdcall;
     
    function SHChangeNotifyDeregister(hWnd: HWND) : boolean; stdcall;
     
    function SHILCreateFromPath(Path: Pointer; PIDL: PItemIDList;
      var Attributes: ULONG):HResult; stdcall;
     
    implementation
     
    const Shell32DLL = 'shell32.dll';
     
    function SHChangeNotifyRegister; external Shell32DLL index 2;
    function SHChangeNotifyDeregister; external Shell32DLL index 4;
    function SHILCreateFromPath; external Shell32DLL index 28;
     
    { TShellNotification }
     
    constructor TShellNotification.Create(AOwner: TComponent);
    begin
      inherited Create( AOwner );
      if not (csDesigning in ComponentState) then
        Handle := AllocateHWnd(WndProc);
    end;
     
    destructor TShellNotification.Destroy;
    begin
      if not (csDesigning in ComponentState) then
        Active := False;
      if Handle <> 0 then
        DeallocateHWnd( Handle );
      inherited Destroy;
    end;
     
    procedure TShellNotification.DoAssociationChange;
    begin
      if Assigned( fOnAssociationChange ) and
        (neAssociationChange in fWatchEvents) then
        fOnAssociationChange( Self );
    end;
     
    procedure TShellNotification.DoAttributesChange;
    begin
      if Assigned( fOnAttribChange ) then
        fOnAttribChange( Self, Path1, Path2 );
    end;
     
    procedure TShellNotification.DoCreateFile(Path: string);
    begin
      if Assigned( fOnCreate ) then
        FOnCreate(Self, Path)
    end;
     
    procedure TShellNotification.DoDeleteFile(Path: string);
    begin
      if Assigned( FOnDelete ) then
        FOnDelete(Self, Path);
    end;
     
    procedure TShellNotification.DoDirCreate(Path: string);
    begin
      if Assigned( FOnDirCreate ) then
        FOnDirCreate( Self, Path );
    end;
     
    procedure TShellNotification.DoDirUpdate(Path: string);
    begin
      if Assigned( FOnFolderUpdate ) then
        FOnFolderUpdate(Self, Path);
    end;
     
    procedure TShellNotification.DoDriveAdd(Path: string);
    begin
      if Assigned( FOnDriveAdd ) then
        FOnDriveAdd(Self, Path);
    end;
     
    procedure TShellNotification.DoDriveAddGui(Path: string);
    begin
      if Assigned( FOnDriveAddGui ) then
        FOnDriveAdd(Self, Path);
    end;
     
    procedure TShellNotification.DoDriveRemove(Path: string);
    begin
      if Assigned( FOnDriveRemove ) then
        FOnDriveRemove(Self, Path);
    end;
     
    procedure TShellNotification.DoFolderRemove(Path: string);
    begin
      if Assigned(FOnFolderRemove) then
        FOnFolderRemove( Self, Path );
    end;
     
    procedure TShellNotification.DoMediaInsert(Path: string);
    begin
      if Assigned( FOnMediaInsert ) then
        FOnMediaInsert(Self, Path);
    end;
     
    procedure TShellNotification.DoMediaRemove(Path: string);
    begin
      if Assigned(FOnMediaRemove) then
        FOnMediaRemove(Self, Path);
    end;
     
    procedure TShellNotification.DoNetShare(Path: string);
    begin
      if Assigned(FOnNetShare) then
        FOnNetShare(Self, Path);
    end;
     
    procedure TShellNotification.DoNetUnShare(Path: string);
    begin
      if Assigned(FOnNetUnShare) then
        FOnNetUnShare(Self, Path);
    end;
     
    procedure TShellNotification.DoRenameFolder(Path1, Path2: string);
    begin
      if Assigned( FOnRenameFolder ) then
        FOnRenameFolder(Self, Path1, Path2);
    end;
     
    procedure TShellNotification.DoRenameItem(Path1, Path2: string);
    begin
      if Assigned( FOnItemRename ) then
        FOnItemRename(Self, Path1, Path2);
    end;
     
    procedure TShellNotification.DoServerDisconnect(Path: string);
    begin
      if Assigned( FOnServerDisconnect ) then
        FOnServerDisconnect(Self, Path);
    end;
     
    function TShellNotification.GetActive: Boolean;
    begin
      Result := (NotifyHandle <> 0) and (fActive);
    end;
     
    function TShellNotification.PathFromPidl(Pidl: PItemIDList): string;
    begin
      SetLength(Result, Max_Path);
      if not SHGetPathFromIDList(Pidl, PChar(Result)) then
        Result := '';
      if pos(#0, Result) > 0 then
        SetLength(Result, pos(#0, Result));
    end;
     
    procedure TShellNotification.SetActive(const Value: Boolean);
    begin
      if (Value <> fActive) then
      begin
        fActive := Value;
        if fActive then
          ShellNotifyRegister
        else
          ShellNotifyUnregister;
      end;
    end;
     
    procedure TShellNotification.SetPath(const Value: string);
    begin
      if fPath <> Value then
      begin
        fPath := Value;
        ShellNotifyRegister;
      end;
    end;
     
    procedure TShellNotification.SetWatch(const Value: Boolean);
    begin
      if fWatch <> Value then
      begin
        fWatch := Value;
        ShellNotifyRegister;
      end;
    end;
     
    procedure TShellNotification.SetWatchEvents(
    const Value: TNotificationEvents);
    begin
      if fWatchEvents <> Value then
      begin
        fWatchEvents := Value;
        ShellNotifyRegister;
      end;
    end;
     
    procedure TShellNotification.ShellNotifyRegister;
    var
      NotifyRecord: PNOTIFYREGISTER;
      Flags: DWORD;
      Pidl: PItemIDList;
      Attributes: ULONG;
    begin
      if not (csDesigning in ComponentState) and
      not (csLoading in ComponentState) then
      begin
        SHILCreatefromPath( PChar(fPath), Addr(Pidl), Attributes);
        NotifyRecord^.pidlPath := Pidl;
        NotifyRecord^.bWatchSubtree := fWatch;
     
        if NotifyHandle <> 0 then
          ShellNotifyUnregister;
        Flags := 0;
        if neAssociationChange in FWatchEvents then
          Flags := Flags or SHCNE_ASSOCCHANGED;
        if neAttributesChange in FWatchEvents then
          Flags := Flags or SHCNE_ATTRIBUTES;
        if neFileChange in FWatchEvents then
          Flags := Flags or SHCNE_UPDATEITEM;
        if neFileCreate in FWatchEvents then
          Flags := Flags or SHCNE_CREATE;
        if neFileDelete in FWatchEvents then
          Flags := Flags or SHCNE_DELETE;
        if neFileRename in FWatchEvents then
          Flags := Flags or SHCNE_RENAMEITEM;
        if neDriveAdd in FWatchEvents then
          Flags := Flags or SHCNE_DRIVEADD;
        if neDriveRemove in FWatchEvents then
          Flags := Flags or SHCNE_DRIVEREMOVED;
        if neShellDriveAdd in FWatchEvents then
          Flags := Flags or SHCNE_DRIVEADDGUI;
        if neDriveSpaceChange in FWatchEvents then
          Flags := Flags or SHCNE_FREESPACE;
        if neMediaInsert in FWatchEvents then
          Flags := Flags or SHCNE_MEDIAINSERTED;
        if neMediaRemove in FWatchEvents then
          Flags := Flags or SHCNE_MEDIAREMOVED;
        if neFolderCreate in FWatchEvents then
          Flags := Flags or SHCNE_MKDIR;
        if neFolderDelete in FWatchEvents then
          Flags := Flags or SHCNE_RMDIR;
        if neFolderRename in FWatchEvents then
          Flags := Flags or SHCNE_RENAMEFOLDER;
        if neFolderUpdate in FWatchEvents then
          Flags := Flags or SHCNE_UPDATEDIR;
        if neNetShare in FWatchEvents then
          Flags := Flags or SHCNE_NETSHARE;
        if neNetUnShare in FWatchEvents then
          Flags := Flags or SHCNE_NETUNSHARE;
        if neServerDisconnect in FWatchEvents then
          Flags := Flags or SHCNE_SERVERDISCONNECT;
        if neImageListChange in FWatchEvents then
          Flags := Flags or SHCNE_UPDATEIMAGE;
        NotifyHandle := SHChangeNotifyRegister(Handle,
          SHCNF_ACCEPT_INTERRUPTS or SHCNF_ACCEPT_NON_INTERRUPTS,
          Flags, SNM_SHELLNOTIFICATION, 1, NotifyRecord);
      end;
    end;
     
    procedure TShellNotification.ShellNotifyUnregister;
    begin
      if NotifyHandle <> 0 then
        SHChangeNotifyDeregister(NotifyHandle);
    end;
     
    procedure TShellNotification.WndProc(var message: TMessage);
    type
      TPIDLLIST = record
      pidlist : array[1..2] of PITEMIDLIST;
    end;
    
    PIDARRAY = ^TPIDLLIST;
    var
      Path1 : string;
      Path2 : string;
      ptr : PIDARRAY;
      repeated : boolean;
      event : longint;
    begin
      case message.Msg of
        SNM_SHELLNOTIFICATION:
        begin
          event := message.LParam and ($7FFFFFFF);
          Ptr := PIDARRAY(message.WParam);
     
          Path1 := PathFromPidl( Ptr^.pidlist[1] );
          Path2 := PathFromPidl( Ptr^.pidList[2] );
     
          repeated := (PrevEvent = event)
            and (uppercase(prevpath1) = uppercase(Path1))
            and (uppercase(prevpath2) = uppercase(Path2));
     
          if Repeated then
            exit;
     
          PrevEvent := message.Msg;
          prevPath1 := Path1;
          prevPath2 := Path2;
     
          case event of
            SHCNE_ASSOCCHANGED : DoAssociationChange;
            SHCNE_ATTRIBUTES : DoAttributesChange( Path1, Path2);
            SHCNE_CREATE : DoCreateFile(Path1);
            SHCNE_DELETE : DoDeleteFile(Path1);
            SHCNE_DRIVEADD : DoDriveAdd(Path1);
            SHCNE_DRIVEADDGUI : DoDriveAddGui(path1);
            SHCNE_DRIVEREMOVED : DoDriveRemove(Path1);
            SHCNE_MEDIAINSERTED : DoMediaInsert(Path1);
            SHCNE_MEDIAREMOVED : DoMediaRemove(Path1);
            SHCNE_MKDIR : DoDirCreate(Path1);
            SHCNE_NETSHARE : DoNetShare(Path1);
            SHCNE_NETUNSHARE : DoNetUnShare(Path1);
            SHCNE_RENAMEFOLDER : DoRenameFolder(Path1, Path2);
            SHCNE_RENAMEITEM : DoRenameItem(Path1, Path2);
            SHCNE_RMDIR : DoFolderRemove(Path1);
            SHCNE_SERVERDISCONNECT : DoServerDisconnect(Path);
            SHCNE_UPDATEDIR : DoDirUpdate(Path);
            SHCNE_UPDATEIMAGE : ;
            SHCNE_UPDATEITEM : ;
          end;
        end;
      end;
    end;
     
    end.

