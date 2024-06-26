---
Title: Перехват сообщений IE
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Перехват сообщений IE
=====================

    {
    This component allows you to intercept Internet Explorer messages such as
    "StatusTextChangeEvent", "DocumentCompleteEvent" and so on.
     
    }
     
    //---- Component Source: Install this component first.
     
    unit IEEvents;
     
    interface
     
    uses
      Windows, SysUtils, Classes, Graphics, ComObj, ActiveX, SHDocVW;
     
    type
      // Event types exposed from the Internet Explorer interface
      TIEStatusTextChangeEvent = procedure(Sender: TObject; const Text: WideString) of object;
      TIEProgressChangeEvent = procedure(Sender: TObject; Progress: Integer; ProgressMax: Integer) of object;
      TIECommandStateChangeEvent = procedure(Sender: TObject; Command: Integer; Enable: WordBool) of object;
      TIEDownloadBeginEvent = procedure(Sender: TObject) of object;
      TIEDownloadCompleteEvent = procedure(Sender: TObject) of object;
      TIETitleChangeEvent = procedure(Sender: TObject; const Text: WideString) of object;
      TIEPropertyChangeEvent = procedure(Sender: TObject; const szProperty: WideString) of object;
      TIEBeforeNavigate2Event = procedure(Sender: TObject; const pDisp: IDispatch;
        var URL: OleVariant; var Flags: OleVariant; var TargetFrameName: OleVariant;
        var PostData: OleVariant; var Headers: OleVariant; var Cancel: WordBool) of object;
      TIENewWindow2Event = procedure(Sender: TObject; var ppDisp: IDispatch; var Cancel: WordBool) of object;
      TIENavigateComplete2Event = procedure(Sender: TObject; const pDisp: IDispatch; var URL: OleVariant) of object;
      TIEDocumentCompleteEvent = procedure(Sender: TObject; const pDisp: IDispatch; var URL: OleVariant) of object;
      TIEOnQuitEvent = procedure(Sender: TObject) of object;
      TIEOnVisibleEvent = procedure(Sender: TObject; Visible: WordBool) of object;
      TIEOnToolBarEvent = procedure(Sender: TObject; ToolBar: WordBool) of object;
      TIEOnMenuBarEvent = procedure(Sender: TObject; MenuBar: WordBool) of object;
      TIEOnStatusBarEvent = procedure(Sender: TObject; StatusBar: WordBool) of object;
      TIEOnFullScreenEvent = procedure(Sender: TObject; FullScreen: WordBool) of object;
      TIEOnTheaterModeEvent = procedure(Sender: TObject; TheaterMode: WordBool) of object;
     
      // Event component for Internet Explorer
      TIEEvents = class(TComponent, IUnknown, IDispatch)
      private
         // Private declarations
        FConnected: Boolean;
        FCookie: Integer;
        FCP: IConnectionPoint;
        FSinkIID: TGuid;
        FSource: IWebBrowser2;
        FStatusTextChange: TIEStatusTextChangeEvent;
        FProgressChange: TIEProgressChangeEvent;
        FCommandStateChange: TIECommandStateChangeEvent;
        FDownloadBegin: TIEDownloadBeginEvent;
        FDownloadComplete: TIEDownloadCompleteEvent;
        FTitleChange: TIETitleChangeEvent;
        FPropertyChange: TIEPropertyChangeEvent;
        FBeforeNavigate2: TIEBeforeNavigate2Event;
        FNewWindow2: TIENewWindow2Event;
        FNavigateComplete2: TIENavigateComplete2Event;
        FDocumentComplete: TIEDocumentCompleteEvent;
        FOnQuit: TIEOnQuitEvent;
        FOnVisible: TIEOnVisibleEvent;
        FOnToolBar: TIEOnToolBarEvent;
        FOnMenuBar: TIEOnMenuBarEvent;
        FOnStatusBar: TIEOnStatusBarEvent;
        FOnFullScreen: TIEOnFullScreenEvent;
        FOnTheaterMode: TIEOnTheaterModeEvent;
      protected
         // Protected declaratios for IUnknown
        function QueryInterface(const IID: TGUID; out Obj): HResult; override;
        function _AddRef: Integer; stdcall;
        function _Release: Integer; stdcall;
         // Protected declaratios for IDispatch
        function GetIDsOfNames(const IID: TGUID; Names: Pointer; NameCount, LocaleID:
          Integer; DispIDs: Pointer): HResult; virtual; stdcall;
        function GetTypeInfo(Index, LocaleID: Integer; out TypeInfo): HResult; virtual; stdcall;
        function GetTypeInfoCount(out Count: Integer): HResult; virtual; stdcall;
        function Invoke(DispID: Integer; const IID: TGUID; LocaleID: Integer;
          Flags: Word; var Params; VarResult, ExcepInfo, ArgErr: Pointer): HResult; virtual; stdcall;
         // Protected declarations
        procedure DoStatusTextChange(const Text: WideString); safecall;
        procedure DoProgressChange(Progress: Integer; ProgressMax: Integer); safecall;
        procedure DoCommandStateChange(Command: Integer; Enable: WordBool); safecall;
        procedure DoDownloadBegin; safecall;
        procedure DoDownloadComplete; safecall;
        procedure DoTitleChange(const Text: WideString); safecall;
        procedure DoPropertyChange(const szProperty: WideString); safecall;
        procedure DoBeforeNavigate2(const pDisp: IDispatch; var URL: OleVariant;
          var Flags: OleVariant; var TargetFrameName: OleVariant; var PostData: OleVariant;
          var Headers: OleVariant; var Cancel: WordBool); safecall;
        procedure DoNewWindow2(var ppDisp: IDispatch; var Cancel: WordBool); safecall;
        procedure DoNavigateComplete2(const pDisp: IDispatch; var URL: OleVariant); safecall;
        procedure DoDocumentComplete(const pDisp: IDispatch; var URL: OleVariant); safecall;
        procedure DoOnQuit; safecall;
        procedure DoOnVisible(Visible: WordBool); safecall;
        procedure DoOnToolBar(ToolBar: WordBool); safecall;
        procedure DoOnMenuBar(MenuBar: WordBool); safecall;
        procedure DoOnStatusBar(StatusBar: WordBool); safecall;
        procedure DoOnFullScreen(FullScreen: WordBool); safecall;
        procedure DoOnTheaterMode(TheaterMode: WordBool); safecall;
      public
         // Public declarations
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        procedure ConnectTo(Source: IWebBrowser2);
        procedure Disconnect;
        property SinkIID: TGuid read FSinkIID;
        property Source: IWebBrowser2 read FSource;
      published
         // Published declarations
        property WebObj: IWebBrowser2 read FSource;
        property Connected: Boolean read FConnected;
        property StatusTextChange: TIEStatusTextChangeEvent read FStatusTextChange write FStatusTextChange;
        property ProgressChange: TIEProgressChangeEvent read FProgressChange write FProgressChange;
        property CommandStateChange: TIECommandStateChangeEvent read FCommandStateChange write FCommandStateChange;
        property DownloadBegin: TIEDownloadBeginEvent read FDownloadBegin write FDownloadBegin;
        property DownloadComplete: TIEDownloadCompleteEvent read FDownloadComplete write FDownloadComplete;
        property TitleChange: TIETitleChangeEvent read FTitleChange write FTitleChange;
        property PropertyChange: TIEPropertyChangeEvent read FPropertyChange write FPropertyChange;
        property BeforeNavigate2: TIEBeforeNavigate2Event read FBeforeNavigate2 write FBeforeNavigate2;
        property NewWindow2: TIENewWindow2Event read FNewWindow2 write FNewWindow2;
        property NavigateComplete2: TIENavigateComplete2Event read FNavigateComplete2 write FNavigateComplete2;
        property DocumentComplete: TIEDocumentCompleteEvent read FDocumentComplete write FDocumentComplete;
        property OnQuit: TIEOnQuitEvent read FOnQuit write FOnQuit;
        property OnVisible: TIEOnVisibleEvent read FOnVisible write FOnVisible;
        property OnToolBar: TIEOnToolBarEvent read FOnToolBar write FOnToolBar;
        property OnMenuBar: TIEOnMenuBarEvent read FOnMenuBar write FOnMenuBar;
        property OnStatusBar: TIEOnStatusBarEvent read FOnStatusBar write FOnStatusBar;
        property OnFullScreen: TIEOnFullScreenEvent read FOnFullScreen write FOnFullScreen;
        property OnTheaterMode: TIEOnTheaterModeEvent read FOnTheaterMode write FOnTheaterMode;
      end;
     
    // Register procedure
    procedure Register;
     
    implementation
     
    function TIEEvents._AddRef: Integer;
    begin
     
      // No more than 2 counts
      result := 2;
     
    end;
     
    function TIEEvents._Release: Integer;
    begin
      // Always maintain 1 ref count (component holds the ref count)
      result := 1;
    end;
     
    function TIEEvents.QueryInterface(const IID: TGUID; out Obj): HResult;
    begin
      // Clear interface pointer
      Pointer(Obj) := nil;
     
      // Attempt to get the requested interface
      if (GetInterface(IID, Obj)) then
         // Success
        result := S_OK
      // Check to see if the guid requested is for the event
      else if (IsEqualIID(IID, FSinkIID)) then
      begin
         // Event is dispatch based, so get dispatch interface (closest we can come)
        if (GetInterface(IDispatch, Obj)) then
            // Success
          result := S_OK
        else
            // Failure
          result := E_NOINTERFACE;
      end
      else
         // Failure
        result := E_NOINTERFACE;
    end;
     
    function TIEEvents.GetIDsOfNames(const IID: TGUID; Names: Pointer; NameCount,
      LocaleID: Integer; DispIDs: Pointer): HResult;
    begin
      // Not implemented
      result := E_NOTIMPL;
    end;
     
    function TIEEvents.GetTypeInfo(Index, LocaleID: Integer; out TypeInfo): HResult;
    begin
      // Clear the result interface
      Pointer(TypeInfo) := nil;
      // No type info for our interface
      result := E_NOTIMPL;
    end;
     
    function TIEEvents.GetTypeInfoCount(out Count: Integer): HResult;
    begin
      // Zero type info counts
      Count := 0;
      // Return success
      result := S_OK;
    end;
     
    function TIEEvents.Invoke(DispID: Integer; const IID: TGUID; LocaleID: Integer; Flags: Word;
      var Params; VarResult, ExcepInfo, ArgErr: Pointer): HResult;
    var pdpParams: PDispParams;
      lpDispIDs: array[0..63] of TDispID;
      dwCount: Integer;
    begin
     
      // Get the parameters
      pdpParams := @Params;
     
      // Events can only be called with method dispatch, not property get/set
      if ((Flags and DISPATCH_METHOD) > 0) then
      begin
         // Clear DispID list
        ZeroMemory(@lpDispIDs, SizeOf(lpDispIDs));
         // Build dispatch ID list to handle named args
        if (pdpParams^.cArgs > 0) then
        begin
            // Reverse the order of the params because they are backwards
          for dwCount := 0 to Pred(pdpParams^.cArgs) do lpDispIDs[dwCount] := Pred(pdpParams^.cArgs) - dwCount;
            // Handle named arguments
          if (pdpParams^.cNamedArgs > 0) then
          begin
            for dwCount := 0 to Pred(pdpParams^.cNamedArgs) do
              lpDispIDs[pdpParams^.rgdispidNamedArgs^[dwCount]] := dwCount;
          end;
        end;
         // Unless the event falls into the "else" clause of the case statement the result is S_OK
        result := S_OK;
         // Handle the event
        case DispID of
          102: DoStatusTextChange(pdpParams^.rgvarg^[lpDispIds[0]].bstrval);
          104: DoDownloadComplete;
          105: DoCommandStateChange(pdpParams^.rgvarg^[lpDispIds[0]].lval,
              pdpParams^.rgvarg^[lpDispIds[1]].vbool);
          106: DoDownloadBegin;
          108: DoProgressChange(pdpParams^.rgvarg^[lpDispIds[0]].lval,
              pdpParams^.rgvarg^[lpDispIds[1]].lval);
          112: DoPropertyChange(pdpParams^.rgvarg^[lpDispIds[0]].bstrval);
          113: DoTitleChange(pdpParams^.rgvarg^[lpDispIds[0]].bstrval);
          250: DoBeforeNavigate2(IDispatch(pdpParams^.rgvarg^[lpDispIds[0]].dispval),
              POleVariant(pdpParams^.rgvarg^[lpDispIds[1]].pvarval)^,
              POleVariant(pdpParams^.rgvarg^[lpDispIds[2]].pvarval)^,
              POleVariant(pdpParams^.rgvarg^[lpDispIds[3]].pvarval)^,
              POleVariant(pdpParams^.rgvarg^[lpDispIds[4]].pvarval)^,
              POleVariant(pdpParams^.rgvarg^[lpDispIds[5]].pvarval)^,
              pdpParams^.rgvarg^[lpDispIds[6]].pbool^);
          251: DoNewWindow2(IDispatch(pdpParams^.rgvarg^[lpDispIds[0]].pdispval^),
              pdpParams^.rgvarg^[lpDispIds[1]].pbool^);
          252: DoNavigateComplete2(IDispatch(pdpParams^.rgvarg^[lpDispIds[0]].dispval),
              POleVariant(pdpParams^.rgvarg^[lpDispIds[1]].pvarval)^);
          253:
            begin
               // Special case handler. When Quit is called, IE is going away so we might
               // as well unbind from the interface by calling disconnect.
              DoOnQuit;
               //  Call disconnect
              Disconnect;
            end;
          254: DoOnVisible(pdpParams^.rgvarg^[lpDispIds[0]].vbool);
          255: DoOnToolBar(pdpParams^.rgvarg^[lpDispIds[0]].vbool);
          256: DoOnMenuBar(pdpParams^.rgvarg^[lpDispIds[0]].vbool);
          257: DoOnStatusBar(pdpParams^.rgvarg^[lpDispIds[0]].vbool);
          258: DoOnFullScreen(pdpParams^.rgvarg^[lpDispIds[0]].vbool);
          259: DoDocumentComplete(IDispatch(pdpParams^.rgvarg^[lpDispIds[0]].dispval),
              POleVariant(pdpParams^.rgvarg^[lpDispIds[1]].pvarval)^);
          260: DoOnTheaterMode(pdpParams^.rgvarg^[lpDispIds[0]].vbool);
        else
            // Have to idea of what event they are calling
          result := DISP_E_MEMBERNOTFOUND;
        end;
      end
      else
         // Called with wrong flags
        result := DISP_E_MEMBERNOTFOUND;
    end;
     
    constructor TIEEvents.Create(AOwner: TComponent);
    begin
      // Perform inherited
      inherited Create(AOwner);
     
      // Set the event sink IID
      FSinkIID := DWebBrowserEvents2;
    end;
     
    destructor TIEEvents.Destroy;
    begin
      // Disconnect
      Disconnect;
      // Perform inherited
      inherited Destroy;
    end;
     
    procedure TIEEvents.ConnectTo(Source: IWebBrowser2);
    var pvCPC: IConnectionPointContainer;
    begin
      // Disconnect from any currently connected event sink
      Disconnect;
      // Query for the connection point container and desired connection point.
      // On success, sink the connection point
      OleCheck(Source.QueryInterface(IConnectionPointContainer, pvCPC));
      OleCheck(pvCPC.FindConnectionPoint(FSinkIID, FCP));
      OleCheck(FCP.Advise(Self, FCookie));
      // Update internal state variables
      FSource := Source;
      // We are in a connected state
      FConnected := True;
      // Release the temp interface
      pvCPC := nil;
    end;
     
    procedure TIEEvents.Disconnect;
    begin
      // Do we have the IWebBrowser2 interface?
      if Assigned(FSource) then
      begin
        try
            // Unadvise the connection point
          OleCheck(FCP.Unadvise(FCookie));
            // Release the interfaces
          FCP := nil;
          FSource := nil;
        except
          Pointer(FCP) := nil;
          Pointer(FSource) := nil;
        end;
      end;
     
      // Disconnected state
      FConnected := False;
    end;
     
    procedure TIEEvents.DoStatusTextChange(const Text: WideString);
    begin
      // Call assigned event
      if Assigned(FStatusTextChange) then FStatusTextChange(Self, Text);
    end;
     
    procedure TIEEvents.DoProgressChange(Progress: Integer; ProgressMax: Integer);
    begin
      // Call assigned event
      if Assigned(FProgressChange) then FProgressChange(Self, Progress, ProgressMax);
    end;
     
    procedure TIEEvents.DoCommandStateChange(Command: Integer; Enable: WordBool);
    begin
      // Call assigned event
      if Assigned(FCommandStateChange) then FCommandStateChange(Self, Command, Enable);
    end;
     
    procedure TIEEvents.DoDownloadBegin;
    begin
      // Call assigned event
      if Assigned(FDownloadBegin) then FDownloadBegin(Self);
    end;
     
    procedure TIEEvents.DoDownloadComplete;
    begin
      // Call assigned event
      if Assigned(FDownloadComplete) then FDownloadComplete(Self);
    end;
     
    procedure TIEEvents.DoTitleChange(const Text: WideString);
    begin
      // Call assigned event
      if Assigned(FTitleChange) then FTitleChange(Self, Text);
    end;
     
    procedure TIEEvents.DoPropertyChange(const szProperty: WideString);
    begin
      // Call assigned event
      if Assigned(FPropertyChange) then FPropertyChange(Self, szProperty);
    end;
     
    procedure TIEEvents.DoBeforeNavigate2(const pDisp: IDispatch; var URL: OleVariant; var Flags:
      OleVariant; var TargetFrameName: OleVariant; var PostData: OleVariant; var Headers: OleVariant; var Cancel: WordBool);
    begin
      // Call assigned event
      if Assigned(FBeforeNavigate2) then FBeforeNavigate2(Self, pDisp, URL, Flags, TargetFrameName, PostData, Headers, Cancel);
    end;
     
    procedure TIEEvents.DoNewWindow2(var ppDisp: IDispatch; var Cancel: WordBool);
    var
      pvDisp: IDispatch;
    begin
      // Call assigned event
      if Assigned(FNewWindow2) then
      begin
        if Assigned(ppDisp) then
          pvDisp := ppDisp
        else
          pvDisp := nil;
        FNewWindow2(Self, pvDisp, Cancel);
        ppDisp := pvDisp;
      end;
    end;
     
    procedure TIEEvents.DoNavigateComplete2(const pDisp: IDispatch; var URL: OleVariant);
    begin
      // Call assigned event
      if Assigned(FNavigateComplete2) then FNavigateComplete2(Self, pDisp, URL);
    end;
     
    procedure TIEEvents.DoDocumentComplete(const pDisp: IDispatch; var URL: OleVariant);
    begin
      // Call assigned event
      if Assigned(FDocumentComplete) then FDocumentComplete(Self, pDisp, URL);
    end;
     
    procedure TIEEvents.DoOnQuit;
    begin
      // Call assigned event
      if Assigned(FOnQuit) then FOnQuit(Self);
    end;
     
    procedure TIEEvents.DoOnVisible(Visible: WordBool);
    begin
      // Call assigned event
      if Assigned(FOnVisible) then FOnVisible(Self, Visible);
    end;
     
    procedure TIEEvents.DoOnToolBar(ToolBar: WordBool);
    begin
      // Call assigned event
      if Assigned(FOnToolBar) then FOnToolBar(Self, ToolBar);
    end;
     
    procedure TIEEvents.DoOnMenuBar(MenuBar: WordBool);
    begin
      // Call assigned event
      if Assigned(FOnMenuBar) then FOnMenuBar(Self, MenuBar);
    end;
     
    procedure TIEEvents.DoOnStatusBar(StatusBar: WordBool);
    begin
      // Call assigned event
      if Assigned(FOnStatusBar) then FOnStatusBar(Self, StatusBar);
    end;
     
    procedure TIEEvents.DoOnFullScreen(FullScreen: WordBool);
    begin
      // Call assigned event
      if Assigned(FOnFullScreen) then FOnFullScreen(Self, FullScreen);
    end;
     
    procedure TIEEvents.DoOnTheaterMode(TheaterMode: WordBool);
    begin
      // Call assigned event
      if Assigned(FOnTheaterMode) then FOnTheaterMode(Self, TheaterMode);
    end;
     
    procedure Register;
    begin
      // Register the component on the Internet tab of the IDE
      RegisterComponents('Internet', [TIEEvents]);
    end;
     
    end.

Project source

    //Notes: Add a button and the IEEvents component to Form1. The button1 click event
    // shows  how the IE enumeration is achieved, and shows how the binding is done:
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, IEEvents, StdCtrls, ActiveX, SHDocVw;
     
    type
      TForm1 = class(TForm)
        IEEvents1: TIEEvents;
        Button1: TButton;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure IEEvents1Quit(Sender: TObject);
        procedure IEEvents1DownloadBegin(Sender: TObject);
        procedure IEEvents1DownloadComplete(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure IEEvents1ProgressChange(Sender: TObject; Progress,
          ProgressMax: Integer);
      private
        { Private declarations }
        FTimeList: TList;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      pvShell: IShellWindows;
      pvWeb2: IWebBrowser2;
      ovIE: OleVariant;
      dwCount: Integer;
    begin
      // Create the shell windows interface
      pvShell := CoShellWindows.Create;
      // Walk the internet explorer windows
      for dwCount := 0 to Pred(pvShell.Count) do
      begin
         // Get the interface
        ovIE := pvShell.Item(dwCount);
         // At this point you can evaluate the interface (LocationUrl, etc)
         // to decide if this is the one you want to connect to. For demo purposes,
         // the code will bind to the first one
        ShowMessage(ovIE.LocationURL);
         // QI for the IWebBrowser2
        if (IDispatch(ovIE).QueryInterface(IWebBrowser2, pvWeb2) = S_OK) then
        begin
          IEEvents1.ConnectTo(pvWeb2);
            // Release the interface
          pvWeb2 := nil;
        end;
         // Clear the variant
        ovIE := Unassigned;
         // Break if we connected
        if IEEvents1.Connected then break;
      end;
      // Release the shell windows interface
      pvShell := nil;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // Create the time list
      FTimeList := TList.Create;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      // Free the time list
      FTimeList.Free;
    end;
     
    procedure TForm1.IEEvents1DownloadBegin(Sender: TObject);
    begin
      // Add the current time to the list
      FTimeList.Add(Pointer(GetTickCount));
    end;
     
    procedure TForm1.IEEvents1DownloadComplete(Sender: TObject);
    var dwTime: LongWord;
    begin
      // Pull the top item off the list (make sure there is one)
      if (FTimeList.Count > 0) then
      begin
        dwTime := LongWord(FTimeList[Pred(FTimeList.Count)]);
        FTimeList.Delete(Pred(FTimeList.Count));
         // Now calculate total based on current time
        dwTime := GetTickCount - dwTime;
         // Display a message showing total download time
        ShowMessage(Format('Download time for "%s" was %d ms', [IEEvents1.WebObj.LocationURL, dwTime]));
      end;
    end;
     
    procedure TForm1.IEEvents1Quit(Sender: TObject);
    begin
      ShowMessage('About to disconnect');
    end;
     
    procedure TForm1.IEEvents1ProgressChange(Sender: TObject; Progress,
      ProgressMax: Integer);
    begin
      Caption := IntToStr(Progress);
    end;
     
    end.

