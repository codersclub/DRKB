---
Title: Иерархия классов
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Иерархия классов
================

Следующий модуль строит дерево классов

    unit InfoForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      StdCtrls, ExtCtrls, Buttons, Clipbrd, Comctrls, Db, Dbcgrids,
      Dbctrls, Dbgrids, Dblookup, Dbtables, Dialogs,
      Filectrl, Grids, Mask, Menus, Mplayer, Oleconst, Olectnrs,
      Olectrls, Outline, Tabnotbk, Tabs, IniFiles, Printers,
      Registry, DsgnIntf, Provider, BdeProv, DBClient,
      ComObj, ActiveX, DDEMan, IBCtrls, Math, Nsapi, Isapi,
      ScktComp, Axctrls, Calendar, CgiApp, checklst,
      ColorGrd, ComServ, syncobjs, httpapp, dbweb, DirOutln,
      Gauges, DsIntf, ToolIntf, EditINtf, ExptIntf, VirtIntf,
      istreams, isapiapp, dblogdlg, masks, ExtDlgs, Spin;
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        Label1: TLabel;
        Edit1: TEdit;
        Label2: TLabel;
        Panel1: TPanel;
        TreeView1: TTreeView;
        ProgressBar1: TProgressBar;
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure TreeView1Change(Sender: TObject; Node: TTreeNode);
        procedure Button2Click(Sender: TObject);
      private
        function AddClass (NewClass: TClass): TTreeNode;
        function GetNode (BaseClass: TClass): TTreeNode;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    type
      TClassArray = array [1..498] of TClass;
     
    const
      ClassArray: TClassArray = (
    EAbort,
    EAccessViolation,
    EAssertionFailed,
    EBitsError,
    EClassNotFound,
    EComponentError,
    EControlC,
    EConvertError,
    EDatabaseError,
    EDateTimeError,
    EDBClient,
    EDBEditError,
    EDBEngineError,
    EDivByZero,
    EExternalException,
    EFCreateError,
    EFilerError,
    EFOpenError,
    EIBError,
    EInOutError,
    EIntError,
    EIntfCastError,
    EIntOverflow,
    EInvalidArgument,
    EInvalidCast,
    EInvalidContainer,
    EInvalidGraphic,
    EInvalidGraphicOperation,
    EInvalidGridOperation,
    EInvalidImage,
    EInvalidInsert,
    EInvalidOp,
    EInvalidOperation,
    EInvalidPointer,
    EListError,
    EMathError,
    EMCIDeviceError,
    EMenuError,
    EMethodNotFound,
    ENoResultSet,
    EOleCtrlError,
    EOleError,
    EOleException,
    EOleException,
    EOleSysError,
    EOutlineError,
    EOutOfMemory,
    EOutOfResources,
    EOverflow,
    EPackageError,
    EParserError,
    EPrinter,
    EPrivilege,
    EPropertyError,
    EPropReadOnly,
    EPropWriteOnly,
    ERangeError,
    EReadError,
    EReconcileError,
    ERegistryException,
    EResNotFound,
    ESocketError,
    EStackOverflow,
    EStreamError,
    EStringListError,
    EThread,
    ETreeViewError,
    EUnderflow,
    EUpdateError,
    EVariantError,
    EWin32Error,
    EWriteError,
    Exception,
    EZeroDivide,
    OutlineError,
    TActiveForm,
    TActiveFormControl,
    TActiveFormFactory,
    TActiveXControl,
    TActiveXControlFactory,
    TActiveXPropertyPage,
    TActiveXPropertyPageFactory,
    TAdapterNotifier,
    TAggregatedObject,
    TAnimate,
    TApplication,
    TAutoIncField,
    TAutoIntfObject,
    TAutoObject,
    TAutoObjectFactory,
    TBatchMove,
    TBCDField,
    TBDECallback,
    TBDEDataSet,
    TBevel,
    TBinaryField,
    TBitBtn,
    TBitmap,
    TBitmapImage,
    TBits,
    TBlobField,
    TBlobStream,
    TBookmarkList,
    TBooleanField,
    TBoolProperty,
    TBrush,
    TButton,
    TButtonControl,
    TBytesField,
    TCalendar,
    TCanvas,
    TCaptionProperty,
    TCGIApplication,
    TCGIRequest,
    TCGIResponse,
    TChangeLink,
    TCharProperty,
    TCheckBox,
    TCheckConstraint,
    TCheckConstraints,
    TCheckListBox,
    TClassProperty,
    TClientDataSet,
    TClientSocket,
    TClientWinSocket,
    TClipboard,
    TCollection,
    TCollectionItem,
    TColorDialog,
    TColorGrid,
    TColorProperty,
    TColumn,
    TColumnTitle,
    TComboBox,
    TComboButton,
    TComClassManager,
    TCommonDialog,
    TCommonDialog,
    TComObject,
    TComObjectFactory,
    TComponent,
    TComponentEditor,
    TComponentList,
    TComponentNameProperty,
    TComponentProperty,
    TComServer,
    TComServerObject,
    TComServerObject,
    TConnectionPoint,
    TConnectionPoints,
    TContainedObject,
    TControl,
    TControlCanvas,
    TControlScrollBar,
    TConversion,
    TCoolBand,
    TCoolBands,
    TCoolBar,
    TCriticalSection,
    TCurrencyField,
    TCursorProperty,
    TCustomAdapter,
    TCustomAdapter,
    TCustomCheckBox,
    TCustomComboBox,
    TCustomControl,
    TCustomDBGrid,
    TCustomEdit,
    TCustomForm,
    TCustomGrid,
    TCustomGroupBox,
    TCustomHotKey,
    TCustomImageList,
    TCustomLabel,
    TCustomListBox,
    TCustomListView,
    TCustomMaskEdit,
    TCustomMemo,
    TCustomMemoryStream,
    TCustomModule,
    TCustomOutline,
    TCustomPageProducer,
    TCustomPanel,
    TCustomProvider,
    TCustomRadioGroup,
    TCustomRemoteServer,
    TCustomRemoteServer,
    TCustomRichEdit,
    TCustomServerSocket,
    TCustomSocket,
    TCustomStaticText,
    TCustomTabControl,
    TCustomTreeView,
    TCustomUpDown,
    TCustomWebDispatcher,
    TCustomWinSocket,
    TDatabase,
    TDataLink,
    TDataModule,
    TDataSet,
    TDataSetDesigner,
    TDataSetTableProducer,
    TDataSetUpdateObject,
    TDataSetUpdateObject,
    TDataSource,
    TDataSourceLink,
    TDateField,
    TDateProperty,
    TDateTimeColors,
    TDateTimeField,
    TDateTimePicker,
    TDBCheckBox,
    TDBComboBox,
    TDBCtrlGrid,
    TDBCtrlGridLink,
    TDBCtrlPanel,
    TDBDataSet,
    TDBEdit,
    TDBError,
    TDBGrid,
    TDBGridColumns,
    TDBImage,
    TDBListBox,
    TDBLookupCombo,
    TDBLookupComboBox,
    TDBLookupControl,
    TDBLookupList,
    TDBLookupListBox,
    TDBMemo,
    TDBNavigator,
    TDBRadioGroup,
    TDBRichEdit,
    TDBText,
    TDdeClientConv,
    TDdeClientItem,
    TDdeMgr,
    TDdeServerConv,
    TDdeServerItem,
    TDefaultEditor,
    TDesigner,
    TDirectoryListBox,
    TDirectoryOutline,
    TDragControlObject,
    TDragObject,
    TDrawGrid,
    TDriveComboBox,
    TDSTableProducer,
    TDSTableProducerEditor,
    TEdit,
    TEnumPropDesc,
    TEnumProperty,
    TEvent,
    TEventDispatch,
    TField,
    TFieldDataLink,
    TFieldDef,
    TFieldDefs,
    TFileListBox,
    TFiler,
    TFileStream,
    TFilterComboBox,
    TFindDialog,
    TFloatField,
    TFloatProperty,
    TFont,
    TFontAdapter,
    TFontCharsetProperty,
    TFontDialog,
    TFontNameProperty,
    TFontProperty,
    TForm,
    TFormDesigner,
    TGauge,
    TGraphic,
    TGraphicControl,
    TGraphicField,
    TGraphicsObject,
    TGridDataLink,
    TGroupBox,
    THandleObject,
    THandleStream,
    THeader,
    THeaderControl,
    THeaderSection,
    THeaderSections,
    THintWindow,
    THotKey,
    THTMLTableAttributes,
    THTMLTableCellAttributes,
    THTMLTableColumn,
    THTMLTableColumns,
    THTMLTableElementAttributes,
    THTMLTableHeaderAttributes,
    THTMLTableRowAttributes,
    THTMLTagAttributes,
    THTTPDataLink,
    TIBComponent,
    TIBEventAlerter,
    TIComponentInterface,
    TIcon,
    TIconImage,
    TIconOptions,
    TIEditorInterface,
    TIEditReader,
    TIEditView,
    TIEditWriter,
    TIExpert,
    TIFileStream,
    TIFormInterface,
    TImage,
    TImageList,
    TIMainMenuIntf,
    TIMemoryStream,
    TImeNameProperty,
    TIMenuItemIntf,
    TIModuleCreator,
    TIModuleInterface,
    TIModuleNotifier,
    TIndexDef,
    TIndexDefs,
    TIndexFiles,
    TIniFile,
    TInplaceEdit,
    TIntegerField,
    TIntegerProperty,
    TInterface,
    TInterfacedObject,
    TIProjectCreator,
    TIResourceEntry,
    TIResourceFile,
    TISAPIApplication,
    TISAPIRequest,
    TISAPIResponse,
    TIStream,
    TIStreamAdapter,
    TIToolServices,
    TIVCLStreamAdapter,
    TLabel,
    TList,
    TListBox,
    TListColumn,
    TListColumns,
    TListColumns,
    TListItem,
    TListItems,
    TListSourceLink,
    TListView,
    TLoginDialog,
    TLookupList,
    TMainMenu,
    TMask,
    TMaskEdit,
    TMediaPlayer,
    TMemo,
    TMemoField,
    TMemoryStream,
    TMenu,
    TMenuItem,
    TMetafile,
    TMetafileCanvas,
    TMetafileImage,
    TMethodProperty,
    TModalResultProperty,
    TMPFilenameProperty,
    TNavButton,
    TNavButton,
    TNavDataLink,
    TNotebook,
    TNumericField,
    TObject,
    TOleContainer,
    TOleControl,
    TOleForm,
    TOleGraphic,
    TOleStream,
    TOpenDialog,
    TOpenPictureDialog,
    TOrdinalProperty,
    TOutline,
    TOutlineNode,
    TPage,
    TPageControl,
    TPageProducer,
    TPaintBox,
    TPaintControl,
    TPanel,
    TParaAttributes,
    TParam,
    TParamList,
    TParams,
    TParser,
    TPen,
    TPersistent,
    TPicture,
    TPictureAdapter,
    TPopupDataList,
    TPopupGrid,
    TPopupMenu,
    TPrintDialog,
    TPrinter,
    TPrinterSetupDialog,
    TProgressBar,
    TPropertyEditor,
    TPropertyPage,
    TProvider,
    TProviderObject,
    TQuery,
    TQueryTableProducer,
    TRadioButton,
    TRadioGroup,
    TReader,
    TRegIniFile,
    TRegistry,
    TRemoteServer,
    TReplaceDialog,
    TResourceStream,
    TRichEdit,
    TSaveDialog,
    TSavePictureDialog,
    TScreen,
    TScrollBox,
    TScroller,
    TScrollingWinControl,
    TServerAcceptThread,
    TServerClientThread,
    TServerClientWinSocket,
    TServerSocket,
    TServerWinSocket,
    dbtables.TSession,
    TSessionList,
    TSetElementProperty,
    TSetProperty,
    TShape,
    TSharedImage,
    TShortCutProperty,
    TSimpleEvent,
    TSmallintField,
    TSpeedButton,
    TSpinButton,
    TSpinEdit,
    TSplitter,
    TStaticText,
    TStatusBar,
    TStatusBar,
    TStatusPanel,
    TStatusPanels,
    TStoredProc,
    TStream,
    TStringField,
    TStringGrid,
    TStringGrid,
    TStringGridStrings,
    TStringList,
    TStringProperty,
    TStrings,
    TStringsAdapter,
    TStringStream,
    TSynchroObject,
    TTabbedNotebook,
    TTabControl,
    TTable,
    TTabList,
    TTabOrderProperty,
    TTabPage,
    TTabSet,
    TTabSheet,
    TTextAttributes,
    TThread,
    TThreadList,
    TTimeField,
    TTimeProperty,
    TTimer,
    TTimerSpeedButton,
    TToolBar,
    TToolButton,
    TTrackBar,
    TTreeNode,
    TTreeNodes,
    TTreeView,
    TTypedComObject,
    TTypedComObjectFactory,
    TUpdateSQL,
    TUpDown,
    TVarBytesField,
    TVirtualStream,
    TWebActionItem,
    TWebActionItems,
    TWebApplication,
    TWebDispatcher,
    TWebModule,
    TWebRequest,
    TWebResponse,
    TWinCGIRequest,
    TWinCGIResponse,
    TWinControl,
    TWinSocketStream,
    TWordField,
    TWriter
    );
     
    function TForm1.AddClass (NewClass: TClass): TTreeNode;
    var
      ParentNode: TTreeNode;
    begin
      // if the class is not there...
      Result := GetNode (NewClass);
      if Result = nil then
      begin
        // look for the parent (eventually adding it)
        ParentNode := AddClass (NewClass.ClassParent);
        // add the new class
        Result := TreeView1.Items.AddChildObject (
          ParentNode,
          NewClass.ClassName,
          Pointer (NewClass));
      end;
    end;
     
    function TForm1.GetNode (BaseClass: TClass): TTreeNode;
    var
      Node1: TTreeNode;
    begin
      Result := nil; // not found
      // find the node in the tree
      Node1 := TreeView1.Items.GetFirstNode;
      while Node1 <> nil do
      begin
        if Node1.Text = BaseClass.ClassName then
        begin
          Result := Node1;
          Exit;
        end;
        Node1 := Node1.GetNext;
        Forms.Application.ProcessMessages;
      end;
    (* slower loop...
      for I := 0 to TreeView1.Items.Count - 1 do
      begin
        if TreeView1.Items [I].Text = BaseClass.ClassName then
        begin
          Result := TreeView1.Items [I];
          Exit;
        end;
        Application.ProcessMessages;
      end;*)
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      I: Integer;
    begin
      // don't restart this loop
      Button1.Enabled := False;
      // add the root class
      TreeView1.Items.AddObject (nil, 'TObject',
        Pointer (TObject));
      // add each class to the tree
      ProgressBar1.Min := Low (ClassArray);
      ProgressBar1.Max := High (ClassArray);
      for I := Low (ClassArray) to High (ClassArray) do
      begin
        AddClass (ClassArray [I]);
        ProgressBar1.Position := I;
      end;
      Beep;
      ShowMessage ('Tree Completed');
      Button2.Enabled := True;
      Button1.Enabled := False;
    end;
     
    procedure TForm1.TreeView1Change (
      Sender: TObject; Node: TTreeNode);
    var
      MyClass: TClass;
    begin
      MyClass := TClass (Node.Data);
      Edit1.Text := Format ('Name: %s - Size: %d bytes',
        [MyClass.ClassName, MyClass.InstanceSize]);
      with Listbox1.Items do
      begin
        Clear;
        while MyClass.ClassParent <> nil do
        begin
          MyClass := MyClass.ClassParent;
          Add (MyClass.ClassName);
        end; // while
      end; // with
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      Screen.Cursor := crHourglass;
      TreeView1.SortType := stText;
      Screen.Cursor := crDefault;
      Button2.Enabled := False;
    end;
     
    end.

