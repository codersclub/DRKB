---
Title: Как использовать chm-файлы в своем проекте?
Date: 01.01.2007
---


Как использовать chm-файлы в своем проекте?
===========================================

Вариант 1:

Всё, что вам надо сделать, это сохранить ниже приведенный модуль на
диске и добавить его в Uses вашего проекта. После этого Вы сможете
использовать CHM файлы точно так же как и обычные HLP файлы.

    unit StoHtmlHelp;
    ////////////////////////////////////////////////////////////////
    // Implementation of context sensitive HTML help (.chm) for Delphi.
    //
    // Version:       1.2
    // Author:        Martin Stoeckli
    // Homepage:      www.martinstoeckli.ch/delphi
    // Copyright(c):  Martin Stoeckli 2002
    //
    // Restrictions:  - Works only under the Windows platform.
    //                - Is written for Delphi v7, should work from v6 up.
    //
    // Description
    // ***********
    // This unit enables you to call ".chm" files from your Delphi projects.
    // You can use the normal Delphi VCL framework, write your projects the
    // same way, as you would using normal ".hlp" files.
    //
    // Installation
    // ************
    // Simply add this unit to your project, that's all.
    //
    // If your help project contains files with the extension ".html"
    // instead of ".htm", then you can either pass the filename with the
    // extension to Application.HelpJump(), or you can set the property
    // "HtmlExt" of the global object in this unit.
    //   StoHelpViewer.HtmlExt := '.html';
    //
    // Examples
    // ********
    //   // assign a helpfile, you could also select the helpfile at the
    //   // options dialog "Project/Options.../Application".
    //   Application.HelpFile := 'C:\MyHelp.chm';
    //   ...
    //   // shows the contents of the helpfile
    //   Application.HelpCommand(HELP_CONTENTS, 0);
    //   // or
    //   Application.HelpSystem.ShowTableOfContents;
    //   ...
    //   // opens the context sensitive help with a numerical id.
    //   // you could do the same by setting the "HelpContext"
    //   // property of a component and pressing the F1 key.
    //   Application.HelpContext(1000);
    //   // or with a string constant
    //   Application.HelpJump('welcome');
    //   ...
    //   // opens the help index with a keyword.
    //   // you could do the same by setting the "HelpKeyword"
    //   // property of a component and pressing the F1 key.
    //   Application.HelpKeyword('how to do');
    //
     
    interface
    uses Classes, Windows, HelpIntfs;
     
    type
      THtmlHelpA = function(hwndCaller: HWND; pszFile: LPCSTR; uCommand: UINT; dwData: DWORD): HWND; stdcall;
     
      TStoHtmlHelpViewer = class(TInterfacedObject, ICustomHelpViewer,
                                 IExtendedHelpViewer, IHelpSelector)
      private
        FViewerID: Integer;
        FViewerName: String;
        FHtmlHelpFunction: THtmlHelpA;
      protected
        FHHCtrlHandle: THandle;
        FHelpManager: IHelpManager;
        FHtmlExt: String;
        function  GetHelpFileName: String;
        function  IsChmFile(const FileName: String): Boolean;
        procedure InternalShutdown;
        procedure CallHtmlHelp(const HelpFile: String; uCommand: UINT; dwData: DWORD);
        // ICustomHelpViewer
        function  GetViewerName: String;
        function  UnderstandsKeyword(const HelpString: String): Integer;
        function  GetHelpStrings(const HelpString: String): TStringList;
        function  CanShowTableOfContents: Boolean;
        procedure ShowTableOfContents;
        procedure ShowHelp(const HelpString: String);
        procedure NotifyID(const ViewerID: Integer);
        procedure SoftShutDown;
        procedure ShutDown;
        // IExtendedHelpViewer
        function  UnderstandsTopic(const Topic: String): Boolean;
        procedure DisplayTopic(const Topic: String);
        function  UnderstandsContext(const ContextID: Integer;
          const HelpFileName: String): Boolean;
        procedure DisplayHelpByContext(const ContextID: Integer;
          const HelpFileName: String);
        // IHelpSelector
        function  SelectKeyword(Keywords: TStrings) : Integer;
        function  TableOfContents(Contents: TStrings): Integer;
      public
        constructor Create; virtual;
        destructor Destroy; override;
        property HtmlExt: String read FHtmlExt write FHtmlExt;
      end;
     
    var
      StoHelpViewer: TStoHtmlHelpViewer;
     
    implementation
    uses Forms, SysUtils, WinHelpViewer;
     
    const
      // imported from HTML Help Workshop
      HH_DISPLAY_TOPIC        = $0000;
      HH_HELP_FINDER          = $0000; // WinHelp equivalent
      HH_DISPLAY_TOC          = $0001;
      HH_DISPLAY_INDEX        = $0002;
      HH_DISPLAY_SEARCH       = $0003;
      HH_KEYWORD_LOOKUP       = $000D;
      HH_DISPLAY_TEXT_POPUP   = $000E; // display string resource id or text in a popup window
      HH_HELP_CONTEXT         = $000F; // display mapped numeric value in dwData
      HH_TP_HELP_CONTEXTMENU  = $0010; // text popup help, same as WinHelp HELP_CONTEXTMENU
      HH_TP_HELP_WM_HELP      = $0011; // text popup help, same as WinHelp HELP_WM_HELP
      HH_CLOSE_ALL            = $0012; // close all windows opened directly or indirectly by the caller
      HH_ALINK_LOOKUP         = $0013; // ALink version of HH_KEYWORD_LOOKUP
      HH_GET_LAST_ERROR       = $0014; // not currently implemented // See HHERROR.h
     
    type
      TStoWinHelpTester = class(TInterfacedObject, IWinHelpTester)
      protected
        // IWinHelpTester
        function CanShowALink(const ALink, FileName: String): Boolean;
        function CanShowTopic(const Topic, FileName: String): Boolean;
        function CanShowContext(const Context: Integer;
                                const FileName: String): Boolean;
        function GetHelpStrings(const ALink: String): TStringList;
        function GetHelpPath : String;
        function GetDefaultHelpFile: String;
        function IsHlpFile(const FileName: String): Boolean;
      end;
     
    ////////////////////////////////////////////////////////////////
    // like "Application.ExeName", but in a DLL you get the name of
    // the DLL instead of the application name
    function Sto_GetModuleName: String;
    var
      szFileName: array[0..MAX_PATH] of Char;
    begin
      FillChar(szFileName, SizeOf(szFileName), #0);
      GetModuleFileName(hInstance, szFileName, MAX_PATH);
      Result := szFileName;
    end;
     
    ////////////////////////////////////////////////////////////////
    { TStoHtmlHelpViewer }
    ////////////////////////////////////////////////////////////////
     
    procedure TStoHtmlHelpViewer.CallHtmlHelp(const HelpFile: String; uCommand: UINT; dwData: DWORD);
    begin
      if Assigned(FHtmlHelpFunction) then
      begin
        case uCommand of
        HH_CLOSE_ALL: FHtmlHelpFunction(0, nil, uCommand, dwData); // special parameters
        HH_GET_LAST_ERROR: ; // ignore
        else
          FHtmlHelpFunction(FHelpManager.GetHandle, PChar(HelpFile), uCommand, dwData);
        end;
      end;
    end;
     
    function TStoHtmlHelpViewer.CanShowTableOfContents: Boolean;
    begin
      Result := True;
    end;
     
    constructor TStoHtmlHelpViewer.Create;
    begin
      inherited Create;
      FViewerName := 'StoHtmlHelp';
      FHtmlExt := '.htm';
      // load dll
      FHHCtrlHandle := LoadLibrary('HHCtrl.ocx');
      if (FHHCtrlHandle <> 0) then
        FHtmlHelpFunction := GetProcAddress(FHHCtrlHandle, 'HtmlHelpA');
    end;
     
    destructor TStoHtmlHelpViewer.Destroy;
    begin
      StoHelpViewer := nil;
      // free dll
      FHtmlHelpFunction := nil;
      if (FHHCtrlHandle <> 0) then
        FreeLibrary(FHHCtrlHandle);
      inherited Destroy;
    end;
     
    procedure TStoHtmlHelpViewer.DisplayHelpByContext(const ContextID: Integer;
      const HelpFileName: String);
    var
      sHelpFile: String;
    begin
      sHelpFile := GetHelpFileName;
      if IsChmFile(sHelpFile) then
        CallHtmlHelp(sHelpFile, HH_HELP_CONTEXT, ContextID);
    end;
     
    procedure TStoHtmlHelpViewer.DisplayTopic(const Topic: String);
    var
      sHelpFile: String;
      sTopic: String;
      sFileExt: String;
    begin
      sHelpFile := GetHelpFileName;
      if IsChmFile(sHelpFile) then
      begin
        // prepare topicname as a html page
        sTopic := Topic;
        sFileExt := LowerCase(ExtractFileExt(sTopic));
        if (sFileExt <> '.htm') and (sFileExt <> '.html') then
          sTopic := sTopic + FHtmlExt;
        CallHtmlHelp(sHelpFile + '::/' + sTopic, HH_DISPLAY_TOPIC, 0);
      end;
    end;
     
    function TStoHtmlHelpViewer.GetHelpFileName: String;
    var
      sPath: String;
    begin
      Result := '';
      // ask for the helpfile name
      if Assigned(FHelpManager) then
        Result := FHelpManager.GetHelpFile;
      if (Result = '') then
        Result := Application.CurrentHelpFile;
      // if no path is specified, then add the application path
      // (otherwise the file won't be found if the current directory is wrong).
      if (Result <> '') then
      begin
        sPath := ExtractFilePath(Result);
        if (sPath = '') then
          Result := ExtractFilePath(Sto_GetModuleName) + Result;
      end;
    end;
     
    function TStoHtmlHelpViewer.GetHelpStrings(const HelpString: String): TStringList;
    begin
      // create a tagged keyword
      Result := TStringList.Create;
      Result.Add(Format('%s: %s', [FViewerName, HelpString]));
    end;
     
    function TStoHtmlHelpViewer.GetViewerName: String;
    begin
      Result := FViewerName;
    end;
     
    procedure TStoHtmlHelpViewer.InternalShutdown;
    begin
      if Assigned(FHelpManager) then
      begin
        FHelpManager.Release(FViewerID);
        FHelpManager := nil;
      end;
    end;
     
    function TStoHtmlHelpViewer.IsChmFile(const FileName: String): Boolean;
    var
      iPos: Integer;
      sFileExt: String;
    begin
      // find extension
      iPos := LastDelimiter('.', FileName);
      if (iPos > 0) then
      begin
        sFileExt := Copy(FileName, iPos, Length(FileName));
        Result := CompareText(sFileExt, '.chm') = 0;
      end
      else
        Result := False;
    end;
     
    procedure TStoHtmlHelpViewer.NotifyID(const ViewerID: Integer);
    begin
      FViewerID := ViewerID;
    end;
     
    function TStoHtmlHelpViewer.SelectKeyword(Keywords: TStrings): Integer;
    var
      i: Integer;
      sViewerName: String;
    begin
      Result := 0;
      i := 0;
      // find first tagged line (see GetHelpStrings)
      while (Result = 0) and (i <= Keywords.Count - 1) do
      begin
        sViewerName := Keywords.Strings[i];
        Delete(sViewerName, Pos(':', sViewerName), Length(sViewerName));
        if (FViewerName = sViewerName) then
          Result := i
        else
          Inc(i);
      end;
    end;
     
    procedure TStoHtmlHelpViewer.ShowHelp(const HelpString: String);
    var
      sHelpFile: String;
      sHelpString: String;
    begin
      sHelpFile := GetHelpFileName;
      if IsChmFile(sHelpFile) then
      begin
        // remove the tag if necessary (see GetHelpStrings)
        sHelpString := HelpString;
        Delete(sHelpString, 1, Pos(':', sHelpString));
        sHelpString := Trim(sHelpString);
        CallHtmlHelp(sHelpFile, HH_DISPLAY_INDEX, DWORD(Pchar(sHelpString)));
      end;
    end;
     
    procedure TStoHtmlHelpViewer.ShowTableOfContents;
    var
      sHelpFile: String;
    begin
      sHelpFile := GetHelpFileName;
      if IsChmFile(sHelpFile) then
        CallHtmlHelp(sHelpFile, HH_DISPLAY_TOC, 0);
    end;
     
    procedure TStoHtmlHelpViewer.ShutDown;
    begin
      SoftShutDown;
      if Assigned(FHelpManager) then
        FHelpManager := nil;
    end;
     
    procedure TStoHtmlHelpViewer.SoftShutDown;
    begin
      CallHtmlHelp('', HH_CLOSE_ALL, 0);
    end;
     
    function TStoHtmlHelpViewer.TableOfContents(Contents: TStrings): Integer;
    begin
      // find line with viewer name
      Result := Contents.IndexOf(FViewerName);
    end;
     
    function TStoHtmlHelpViewer.UnderstandsContext(const ContextID: Integer;
      const HelpFileName: String): Boolean;
    begin
      Result := IsChmFile(HelpFileName);
    end;
     
    function TStoHtmlHelpViewer.UnderstandsKeyword(const HelpString: String): Integer;
    begin
      if IsChmFile(GetHelpFileName) then
        Result := 1
      else
        Result := 0;
    end;
     
    function TStoHtmlHelpViewer.UnderstandsTopic(const Topic: String): Boolean;
    begin
      Result := IsChmFile(GetHelpFileName);
    end;
     
    ////////////////////////////////////////////////////////////////
    { TStoWinHelpTester }
    //
    // delphi will call the WinHelpTester to determine, if the default
    // winhelp should handle the requests.
    // don't allow anything, because delphi (v7) will create an invalid
    // helpfile path, calling GetHelpPath (it puts a pathdelimiter
    // before the filename in "TWinHelpViewer.HelpFile").
    ////////////////////////////////////////////////////////////////
     
    function TStoWinHelpTester.CanShowALink(const ALink,
      FileName: String): Boolean;
    begin
      Result := False;
    //  Result := IsHlpFile(FileName);
    end;
     
    function TStoWinHelpTester.CanShowContext(const Context: Integer;
      const FileName: String): Boolean;
    begin
      Result := False;
    //  Result := IsHlpFile(FileName);
    end;
     
    function TStoWinHelpTester.CanShowTopic(const Topic,
      FileName: String): Boolean;
    begin
      Result := False;
    //  Result := IsHlpFile(FileName);
    end;
     
    function TStoWinHelpTester.GetDefaultHelpFile: String;
    begin
      Result := '';
    end;
     
    function TStoWinHelpTester.GetHelpPath: String;
    begin
      Result := '';
    end;
     
    function TStoWinHelpTester.GetHelpStrings(
      const ALink: String): TStringList;
    begin
      // as TWinHelpViewer would do it
      Result := TStringList.Create;
      Result.Add(': ' + ALink);
    end;
     
    function TStoWinHelpTester.IsHlpFile(const FileName: String): Boolean;
    var
      iPos: Integer;
      sFileExt: String;
    begin
      // file has extension '.hlp' ?
      iPos := LastDelimiter('.', FileName);
      if (iPos > 0) then
      begin
        sFileExt := Copy(FileName, iPos, Length(FileName));
        Result := CompareText(sFileExt, '.hlp') = 0;
      end
      else
        Result := False;
    end;
     
    initialization
      StoHelpViewer := TStoHtmlHelpViewer.Create;
      RegisterViewer(StoHelpViewer, StoHelpViewer.FHelpManager);
      Application.HelpSystem.AssignHelpSelector(StoHelpViewer);
      WinHelpTester := TStoWinHelpTester.Create;
     
    finalization
      // do not free StoHelpViewer, because the object is referenced by the
      // interface and will be freed automatically by releasing the last reference
      if Assigned(StoHelpViewer) then
        StoHelpViewer.InternalShutdown;
    end.

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------
Вариант 2:


    unit HtmlHelp; 
     
    interface 
     
    uses 
      Windows, Graphics; 
     
    const 
      HH_DISPLAY_TOPIC  = $0000; 
      HH_DISPLAY_TOC    = $0001; 
      HH_DISPLAY_INDEX  = $0002; 
      HH_DISPLAY_SEARCH = $0003; 
      HH_SET_WIN_TYPE   = $0004; 
      HH_GET_WIN_TYPE   = $0005; 
      HH_GET_WIN_HANDLE = $0006; 
      HH_GET_INFO_TYPES = $0007; 
      HH_SET_INFO_TYPES = $0008; 
      HH_SYNC           = $0009; 
      HH_ADD_NAV_UI     = $000A; 
      HH_ADD_BUTTON     = $000B; 
      HH_GETBROWSER_APP = $000C; 
      HH_KEYWORD_LOOKUP = $000D; 
      HH_DISPLAY_TEXT_POPUP = $000E; 
      HH_HELP_CONTEXT   = $000F; 
     
    const 
      HHWIN_PROP_ONTOP          = 2; 
      HHWIN_PROP_NOTITLEBAR     = 4; 
      HHWIN_PROP_NODEF_STYLES   = 8; 
      HHWIN_PROP_NODEF_EXSTYLES = 16; 
      HHWIN_PROP_TRI_PANE       = 32; 
      HHWIN_PROP_NOTB_TEXT      = 64; 
      HHWIN_PROP_POST_QUIT      = 128; 
      HHWIN_PROP_AUTO_SYNC      = 256; 
      HHWIN_PROP_TRACKING       = 512; 
      HHWIN_PROP_TAB_SEARCH     = 1024; 
      HHWIN_PROP_TAB_HISTORY    = 2048; 
      HHWIN_PROP_TAB_FAVORITES  = 4096; 
      HHWIN_PROP_CHANGE_TITLE   = 8192; 
      HHWIN_PROP_NAV_ONLY_WIN   = 16384; 
      HHWIN_PROP_NO_TOOLBAR     = 32768; 
     
    const 
      HHWIN_PARAM_PROPERTIES    = 2; 
      HHWIN_PARAM_STYLES        = 4; 
      HHWIN_PARAM_EXSTYLES      = 8; 
      HHWIN_PARAM_RECT          = 16; 
      HHWIN_PARAM_NAV_WIDTH     = 32; 
      HHWIN_PARAM_SHOWSTATE     = 64; 
      HHWIN_PARAM_INFOTYPES     = 128; 
      HHWIN_PARAM_TB_FLAGS      = 256; 
      HHWIN_PARAM_EXPANSION     = 512; 
      HHWIN_PARAM_TABPOS        = 1024; 
      HHWIN_PARAM_TABORDER      = 2048; 
      HHWIN_PARAM_HISTORY_COUNT = 4096; 
      HHWIN_PARAM_CUR_TAB       = 8192; 
     
    const 
      HHWIN_BUTTON_EXPAND     = 2; 
      HHWIN_BUTTON_BACK       = 4; 
      HHWIN_BUTTON_FORWARD    = 8; 
      HHWIN_BUTTON_STOP       = 16; 
      HHWIN_BUTTON_REFRESH    = 32; 
      HHWIN_BUTTON_HOME       = 64; 
      HHWIN_BUTTON_BROWSE_FWD = 128; 
      HHWIN_BUTTON_BROWSE_BCK = 256; 
      HHWIN_BUTTON_NOTES      = 512; 
      HHWIN_BUTTON_CONTENTS   = 1024; 
      HHWIN_BUTTON_SYNC       = 2048; 
      HHWIN_BUTTON_OPTIONS    = 4096; 
      HHWIN_BUTTON_PRINT      = 8192; 
      HHWIN_BUTTON_INDEX      = 16384; 
      HHWIN_BUTTON_SEARCH     = 32768; 
      HHWIN_BUTTON_HISTORY    = 65536; 
      HHWIN_BUTTON_FAVORITES  = 131072; 
      HHWIN_BUTTON_JUMP1      = 262144; 
      HHWIN_BUTTON_JUMP2      = 524288; 
      HHWIN_BUTTON_ZOOM       = HHWIN_Button_Jump2 * 2; 
      HHWIN_BUTTON_TOC_NEXT   = HHWIN_Button_Zoom * 2; 
      HHWIN_BUTTON_TOC_PREV   = HHWIN_Button_Toc_Next * 2; 
     
    const 
      HHWIN_DEF_Buttons = HHWIN_Button_Expand or HHWIN_Button_Back or 
        HHWIN_Button_Options or HHWIN_Button_Print; 
     
    const 
      IDTB_EXPAND      = 200; 
      IDTB_CONTRACT    = 201; 
      IDTB_STOP        = 202; 
      IDTB_REFRESH     = 203; 
      IDTB_BACK        = 204; 
      IDTB_HOME        = 205; 
      IDTB_SYNC        = 206; 
      IDTB_PRINT       = 207; 
      IDTB_OPTIONS     = 208; 
      IDTB_FORWARD     = 209; 
      IDTB_NOTES       = 210; 
      IDTB_BROWSE_FWD  = 211; 
      IDTB_BROWSE_BACK = 212; 
      IDTB_CONTENTS    = 213; 
      IDTB_INDEX       = 214; 
      IDTB_SEARCH      = 215; 
      IDTB_HISTORY     = 216; 
      IDTB_FAVORITES   = 217; 
      IDTB_JUMP1       = 218; 
      IDTB_JUMP2       = 219; 
      IDTB_CUSTOMIZE   = 221; 
      IDTB_ZOOM        = 222; 
      IDTB_TOC_NEXT    = 223; 
      IDTB_TOC_PREV    = 224; 
     
    const 
      HHN_First = Cardinal(-860); 
      HHN_Last  = Cardinal(-879); 
     
      HHN_NavComplete = HHN_First - 0; 
      HHN_Track       = HHN_First - 1; 
     
    type 
      HHN_Notify = record 
        hdr: Pointer; 
        pszUrl: PWideChar; 
      end; 
     
      HH_Popup = record 
        cbStruct: Integer; 
        hinst: THandle; 
        idString: Cardinal; 
        pszText: PChar; 
        pt: TPoint; 
        clrForeground: TColor; 
        clrBackground: TColor; 
        rcMargins: TRect; 
        pszFont: PChar; 
      end; 
     
      HH_AKLINK = record 
        cbStruct: Integer; 
        fReserved: bool; 
        pszKeywords: PChar; 
        pszUrl: PChar; 
        pszMsgText: PChar; 
        pszMsgTitle: PChar; 
        pszWindow: PChar; 
        fIndexOnFail: bool; 
      end; 
     
    type 
      HHWin_NavTypes = (HHWIN_NAVTYPE_TOC, 
        HHWIN_NAVTYPE_INDEX, 
        HHWIN_NAVTYPE_SEARCH, 
        HHWIN_NAVTYPE_HISTORY, 
        HHWIN_NAVTYPE_FAVOURITES); 
     
    type 
      HH_InfoType  = Longint; 
      PHH_InfoType = ^ HH_InfoType; 
     
    type 
      HHWin_NavTabs = (HHWIN_NavTab_Top, 
        HHWIN_NavTab_Left, 
        HHWIN_NavTab_Bottom); 
     
    const 
      HH_Max_Tabs = 19; 
     
    type 
      HH_Tabs = (HH_TAB_CONTENTS, 
        HH_TAB_INDEX, 
        HH_TAB_SEARCH, 
        HH_TAB_HISTORY, 
        HH_TAB_FAVORITES 
        ); 
     
    const 
      HH_FTS_DEFAULT_PROXIMITY = (-1); 
     
    type 
      HH_FTS_Query = record 
        cbStruct: Integer; 
        fUniCodeStrings: bool; 
        pszSearchQuery: PChar; 
        iProximity: Longint; 
        fStemmedSearch: bool; 
        fTitleOnly: bool; 
        fExecute: bool; 
        pszWindow: PChar; 
      end; 
     
    type 
      HH_WinType = record 
        cbStruct: Integer; 
        fUniCodeStrings: bool; 
        pszType: PChar; 
        fsValidMembers: Longint; 
        fsWinProperties: Longint; 
        pszCaption: PChar; 
        dwStyles: Longint; 
        dwExStyles: Longint; 
        rcWindowPos: TRect; 
        nShowState: Integer; 
        hwndHelp: THandle; 
        hwndCaller: THandle; 
        paInfoTypes: ^ HH_InfoType; 
        hwndToolbar: THandle; 
        hwndNavigation: THandle; 
        hwndHTML: THandle; 
        iNavWidth: Integer; 
        rcHTML: TRect; 
        pszToc: PChar; 
        pszIndex: PChar; 
        pszFile: PChar; 
        pszHome: PChar; 
        fsToolbarFlags: Longint; 
        fNotExpanded: bool; 
        curNavType: Integer; 
        tabPos: Integer; 
        idNotify: Integer; 
        TabOrder: array[0..HH_Max_Tabs + 1] of Byte; 
        cHistory: Integer; 
        pszJump1: PChar; 
        pszJump2: PChar; 
        pszUrlJump1: PChar; 
        pszUrlJump2: PChar; 
        rcMinSize: TRect; 
      end; 
     
      PHH_WinType = ^ HH_WinType; 
     
    type 
      HHACTTYpes = (HHACT_TAB_CONTENTS, 
        HHACT_TAB_INDEX, 
        HHACT_TAB_SEARCH, 
        HHACT_TAB_HISTORY, 
        HHACT_TAB_FAVORITES, 
     
        HHACT_EXPAND, 
        HHACT_CONTRACT, 
        HHACT_BACK, 
        HHACT_FORWARD, 
        HHACT_STOP, 
        HHACT_REFRESH, 
        HHACT_HOME, 
        HHACT_SYNC, 
        HHACT_OPTIONS, 
        HHACT_PRINT, 
        HHACT_HIGHLIGHT, 
        HHACT_CUSTOMIZE, 
        HHACT_JUMP1, 
        HHACT_JUMP2, 
        HHACT_ZOOM, 
        HHACT_TOC_NEXT, 
        HHACT_TOC_PREV, 
        HHACT_NOTES, 
     
        HHACT_LAST_ENUM 
        ); 
     
    type 
      HHNTRACK = record 
        hdr: TNMHDR; 
        pszCurUrl: PWideChar; 
        idAction: Integer; 
        phhWinType: ^ HH_WinType; 
      end; 
      PHHNTRACK = ^ HHNTRACK; 
     
      HHNNAVCOMPLETE = record 
        hdr: TNMHDR; 
        pszUrl: PChar; 
      end; 
      PHHNNAVCOMPLETE = ^ HHNNAVCOMPLETE; 
     
    type 
      THtmlHelpA = function(hwndCaller: THandle; pszFile: PChar; 
        uCommand: Cardinal; dwData: Longint): THandle;  
        stdCall; 
      THtmlHelpW = function(hwndCaller: THandle; pszFile: PChar; 
        uCommand: Cardinal; dwData: Longint): THandle;  
        stdCall; 
     
    function HH(hwndCaller: THandle; pszFile: PChar;
      uCommand: Cardinal; dwData: Longint): THandle;

    function HtmlHelpInstalled: Boolean; 
     
    implementation 
     
    const 
      ATOM_HTMLHELP_API_ANSI = #14#0; 
      ATOM_HTMLHELP_API_UNICODE = #15#0; 
     
    var 
      HtmlHelpA: THtmlHelpA; 
      OCXHandle: THandle; 
     
    function HH; 
    begin 
      Result := 0; 
      if (Assigned(HtmlHelpA)) then  
      begin 
        Result := HtmlHelpA(hwndCaller, pszFile, uCommand, dwData); 
      end; 
    end; 
     
    function HtmlHelpInstalled: Boolean; 
    begin 
      Result := (Assigned(HtmlHelpA)); 
    end; 
     
    initialization 
      begin 
        HtmlHelpA := nil; 
        OCXHandle := LoadLibrary('HHCtrl.OCX'); 
        if (OCXHandle <> 0) then  
        begin 
          HtmlHelpA := GetProcAddress(OCXHandle, 'HtmlHelpA'); 
        end; 
      end; 
     
    finalization 
      begin 
        if (OCXHandle <> 0) then 
          FreeLibrary(OCXHandle); 
      end; 
    end. 
    //----------------------------------------------- 

    unit Unit1; 
     
    {....} 
     
    implementation 
     
    uses 
      HtmlHelp; 
     
    const 
      HH_HELP_CONTEXT = $F; 
      MYHELP_FILE = 'DualHelp.chm' + Chr(0); 
    var 
      RetCode: LongInt; 
     
      {$R *.DFM} 
     
    procedure TForm1.FormKeyUp(Sender: TObject; var Key: Word;
                               Shift: TShiftState); 
    begin 
      if Key = vk_f1 then 
      begin 
        if HtmlHelpInstalled = True then 
        begin 
          RetCode := HH(Form1.Handle, PChar(MYHELP_FILE),
            HH_HELP_CONTEXT, ActiveControl.HelpContext); 
          Key     := 0; //eat it! 
        end  
        else 
          helpfile := 'hhtest.hlp'; 
      end; 
    end; 

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
