---
Title: Переход от Delphi 7 к Developer Studio 2006 - сравнивая компоненты
Author: Сергей Досюков, Dragon Soft
Date: 12.12.2005
---


Переход от Delphi 7 к Developer Studio 2006 - сравнивая компоненты
===================================================================

Каждая версия продукта представляет новые возможности, в то же время что
то может быть удалено как устаревшее или не используемое и Borland
Delphi или C++Builder не являются исключением.

Когда вы разрабатываете программный продукт разрабатывался на протяжении
нескольких лет всегда возникает вопрос при переходе на новую версию
среды разработки - "а все ли компоненты доступны, что появилось нового
и возможен ли переход вообще?".

10/10/2005 Borland представил новую версию Borland Delphi - Borland
Developer Studio 2006. Отличительной особенностью стала интеграция C++
как новой возможности в IDE. На данный момент это только предварительный
вариант кода.

В течении последних лет я старался отслеживать прогресс и изменения в
списке компонентов доступных в Delphi и теперь настало время включить
C++Builder.

> **Примечание**  
> Когда "\*" присутствует в какой либо колонке, это значит что поле
> "Примечание" содержит дополнительную информацию.

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|STANDARD|
|TActionList| | | | | | | | | | | | |
|TButton| | | | | | | | | | | | |
|TCheckBox| | | | | | | | | | | | |
|TComboBox| | | | | | | | | | | | |
|TEdit| | | | | \*| | | \*| | \*| \*|В WinForms.Net доступнокак TextBox.Multiline = False|
|TFrames| | | | | | | | | | | | |
|TGroupBox| | | | | | | | | | | | |
|TLabel| | | | | | | | | | | | |
|TLinkLabel| | | \*| | | \*| | | | | |www.dragonsoftru.com?go=vcl|
|TListBox| | | | | | | | | | | | |
|TMainMenu| | | | | | | | | | | \*|MenuStrip|
|TMemo| | | | | \*| | | \*| | \*| \*|В WinForms.Net доступнокак TextBox.Multiline = True|
|TPanel| | | | | | | | | | | | |
|TPopupMenu| | | | | | | | | | | \*|в VS2005 - ContextMenuStrip|
|TPropertyGrid| | | | | | | | | | | | |
|TRadioButton| | | | | | | | | | | | |
|TRadioGroup| | | | | | | | | | | | |
|TScrollBar| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|ADDITIONAL|
|TActionManager| | | | | | | | | | | | |
|TActionMainMenuBar| | | | | | | | | | | | |
|TActionToolBar| | | | | | | | | | | | |
|TApplicationEvents| | | | | | | | | | | | |
|TBevel| | | | | | | | | | | | |
|TBitBtn| | | | | | | | | | | | |
|TButtonGroup| | | | | | | | | | | | |
|TCategoryButtons| | | | | | | | | | | | |
|TChart| | | \*| \*| \*| \*| \*| \*| | \*|?|www.teechart.com|
|TCheckListBox| | | | | | | | | | | | |
|TColorBox| | | | | | | | | | | | |
|TColorListBox| | | | | | | | | | | | |
|TControlBar| | | | | | | | | | | | |
|TCustomizeDlg| | | | | | | | | | | | |
|TDockTabSet| | | | | | | | | | | | |
|TDrawGrid| | | | | | | | | | | | |
|TFlowPanel| | | | | | | | | | | \*|FlowLayoutPanel|
|TGridPanel| | | | | | | | | | \*| \*|TableLayoutPanel|
|TImage| | | | | | | | | | | \*|PictureBox|
|TLabeledEdit| | | | | | | | | | | | |
|TMaskEdit| | | | | | | | | | | \*|MaskedTextBox|
|TPopupActionBar| | | | | | | | | | | | |
|TScrollBox| | | | | | | | | | | | |
|TShape| | | | | | | | | | | | |
|TSpeedButton| | | | | | | | | | | | |
|TSplitter| | | | | | | | | | | | |
|TStandardColorMap| | | | | | | | | | | | |
|TStaticText| | | | | | | | | | | | |
|TStringGrid| | | | | | | | | | | | |
|TTabSet| | | | | | | | | | | | |
|TTwilightColorMap| | | | | | | | | | | | |
|TValueListEditor| | | | | | | | | | | | |
|TXPColorMap| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|SPECIAL IN VS 2005|
|BackgroundWorker| | | | | | | | | | | | |
|NumericUpDown| | | | | | | | | | | | |
|SerialPort| | | | | | | | | | | | |
|ServiceController| | | | | | | | | | | | |
|ToolStripContainer| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|WIN 32|
|TAnimate| | | | | | | | | | | | |
|TComboBoxEx| | | | | | | | | | | | |
|TCoolBar| | | | | | | | | | | | |
|TDateTimePicker| | | | | | | | | | | | |
|TDomainUpDown| | | | | | | | | | | | |
|THeaderControl| | | | | | | | | | | | |
|THotKey| | | | | | | | | | | | |
|TImageList| | | | | | | | | | | | |
|TListView| | | | | | | | | | | | |
|TMonthCalendar| | | | | | | | | | | | |
|TPageControl| | | | | | | | | | | | |
|TPageScroller| | | | | | | | | | | | |
|TProgressBar| | | | | | | | | | | | |
|TRichEdit| | | | | | | | | | | \*|RichTextBox|
|TStatusBar| | | | | | | | | | | \*|StatusStrip|
|TTabControl| | | | | | | | | | | | |
|TTrackBar| | | | | | | | | | | | |
|TTrayIcon| | | | | | | | | | | | |
|TToolBar| | | | | | | | | | | | |
|TTreeView| | | | | | | | | | | | |
|TUpDown| | | | | | | | | | | | |
|TXPManifest| | | | | | | | | | | | |
|HelpProvider| | | | | | | | | | | | |
|ErrorProvider| \*| | \*| | | \*| | | | | |www.dragonsoftru.com?go=vcl|
|NotifyIcon| | | | | | | | | | | | |
|ToolTip| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|SYSTEM|
|TPaintBox| | | | | | | | | | | | |
|TTimer| | | | | | | | | | | | |
|TMediaPlayer| | | | | | | | | | | | |
|TOleContainer| | | | | | | | | | | | |
|TCOMAdminCatalog| | | | | | | | | | | | |
|TDDEClientConv| | | | | | | | | | | | |
|TDDEClientItem| | | | | | | | | | | | |
|TDDEServerConv| | | | | | | | | | | | |
|TDDEServerItem| | | | | | | | | | | | |
|FileSystemWatcher| | | | | | | | | | | | |
|EventLog| | | | | | | | | | | |www.dragonsoftru.com?go=vcl|
|MessageQueue| | | | | | | | | | | | |
|PerformanceCounter| | | | | | | | | | | | |
|Process| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|WIN 3.1|
|TDBLookupList| | | | | | | | | | | | |
|TDBLookupCombo| | | | | | | | | | | | |
|TDirectoryListBox| | | | | | | | | | | | |
|TDirectorySearcher| | | | | | | | | | | | |
|TDriveComboBox| | | | | | | | | | | | |
|TFileListBox| | | | | | | | | | | | |
|TFilterComboBox| | | | | | | | | | | | |
|THeader| | | | | | | | | | | | |
|TOutline| | | | | | | | | | | | |
|TNotebook| | | | | | | | | | | | |
|TTabbedNotebook| | | | | | | | | | | | |
|TTabSet| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|DATA ACCESS|
|TClientDataSet| | | | | | | | | | | | |
|TDataSetProvider| | | | | | | | | | | | |
|TDataSource| | | | | | | | | | | | |
|TXMLTransform| | | | | | | | | | | | |
|TXMLTransformClient| | | | | | | | | | | | |
|TXMLTransformProvider| | | | | | | | | | | | |
|TBindingSource| | | | | | | | | | | | |
|TDataSet| | | | | | | | | | | | |
|TListConnector| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|DATA CONTROLS|
|TDBChart| | | \*| \*| \*| | \*| \*| | \*|?|www.teechart.com|
|TDBCheckBox| | | | | | | | | | | | |
|TDBComboBox| | | | | | | | | | | | |
|TDBCtrlGrid| | | | | | | | | | | | |
|TDBEdit| | | | | | | | | | | | |
|TDBGrid| | | | | | | | | | | |В VS2005 DataGridView|
|TDBImage| | | | | | | | | | | | |
|TDBListBox| | | | | | | | | | | | |
|TDBLookupComboBox| | | | | | | | | | | | |
|TDBLookupListBox| | | | | | | | | | | | |
|TDBMemo| | | | | | | | | | | | |
|TDBNavigator| | | | | | | | | | | \*|BindingNavigator|
|TDBRadioGroup| | | | | | | | | | | | |
|TDBRichEdit| | | | | | | | | | | | |
|TDBText| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|DATASNAP|
|TDCOMConnection| | | | | | | | | | | | |
|TSocketConnection| | | | | | | | | | | | |
|TSimpleObjectBroker| | | | | | | | | | | | |
|TWEBConnection| | | | | | | | | | | | |
|TConnectionBroker| | | | | | | | | | | | |
|TSharedConnection| | | | | | | | | | | | |
|TLocalConnection| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|ADO|
|TADOConnection| | | | | | | | | | | | |
|TADOCommand| | | | | | | | | | | | |
|TADODataSet| | | | | | | | | | | | |
|TADOTable| | | | | | | | | | | |В VS какчасть DataSet|
|TADOQuery| | | | | | | | | | | | |
|TADOStoredProc| | | | | | | | | | | | |
|TRDSConnection| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|BDE|
|TTable| | | | | | | | | | | | |
|TQuery| | | | | | | | | | | | |
|TStoredProc| | | | | | | | | | | | |
|TDatabase| | | | | | | | | | | | |
|TSession| | | | | | | | | | | | |
|TBatchMove| | | | | | | | | | | | |
|TUpdateSQL| | | | | | | | | | | | |
|TNestedTable| | | | | | | | | | | | |
|TBDEClientDataSet| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|INTERBASE|
|TIBTable| | | | | | | | | | | | |
|TIBQuery| | | | | | | | | | | | |
|TIBStoredProc| | | | | | | | | | | | |
|TIBDatabase| | | | | | | | | | | | |
|TIBTransaction| | | | | | | | | | | | |
|TIBUpdateSQL| | | | | | | | | | | | |
|TIBDataset| | | | | | | | | | | | |
|TIBSQL| | | | | | | | | | | | |
|TIBDatabaseInfo| | | | | | | | | | | | |
|TIBSQLMonitor| | | | | | | | | | | | |
|TIBEvents| | | | | | | | | | | | |
|TIBExtract| | | | | | | | | | | | |
|TIBClientDataset| | | | | | | | | | | | |
|TIBConnectionBroker| | | | | | | | | | | | |
|TIBScript| | | | | | | | | | | | |
|TIBSQLParser| | | | | | | | | | | | |
|TIBDatabaseINI| | | | | | | | | | | | |
|TIBFilterDialog| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|INTERBASE ADMIN|
|TIBConfigService| | | | | | | | | | | | |
|TIBBackupService| | | | | | | | | | | | |
|TIBRestoreService| | | | | | | | | | | | |
|TIBValidationService| | | | | | | | | | | | |
|TIBStatisticalService| | | | | | | | | | | | |
|TIBLogService| | | | | | | | | | | | |
|TIBSecurityService| | | | | | | | | | | | |
|TIBServerProperties| | | | | | | | | | | | |
|TIBLicensingService| | | | | | | | | | | | |
|TIBInstall| | | | | | | | | | | | |
|TIBUnInstall| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|DBEXPRESS|
|TSQLConnection| | | | | | | | | | | | |
|TSQLDataset| | | | | | | | | | | | |
|TSQLQuery| | | | | | | | | | | | |
|TSQLStoredProc| | | | | | | | | | | | |
|TSQLTable| | | | | | | | | | | | |
|TSQLMonitor| | | | | | | | | | | | |
|TSimpleDataset| | | | | | | | | | | | |
|TSQLClientDataSet| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|WEBSERVICES|
|THTTPRIO| | | | | | | | | | | | |
|THTTPReqResp| | | | | | | | | | | | |
|TOPToSoapDomConvert| | | | | | | | | | | | |
|TSOAPConnection| | | | | | | | | | | | |
|THTTPSoapDispatcher| | | | | | | | | | | | |
|TWSDLHTMLPublish| | | | | | | | | | | | |
|THTTPSoapPascalInvoker| | | | | | | | | | | | |
|THTTPSoapCppInvoker| | | | | | | | | | | | |
|INTERNETEXPRESS|
|TXMLBroker| | | | | | | | | | | | |
|TInetXPageProducer| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|INTERNET|
|TWebDispatcher| | | | | | | | | | | | |
|TPageProducer| | | | | | | | | | | | |
|TDatasetTableProducer| | | | | | | | | | | | |
|TDatasetPageProducer| | | | | | | | | | | | |
|TQueryTableProducer| | | | | | | | | | | | |
|TSQLQueryTableProducer| | | | | | | | | | | | |
|TTCPClient| | | | | | | | | | | | |
|TTCPServer| | | | | | | | | | | | |
|TUDPSocket| | | | | | | | | | | | |
|TXMLDocument| | | | | | | | | | | | |
|TWebBrowser| | \*| | | | | | | | | |TCppWebBrowser|
|TServerSocket| \*| | \*| | | | | | | | |Устарело (см. dclsocketsNN.bpl: ScktComp.pas длядоп. инфо). Используйте INDY илидр.|
|TClientSocket| \*| | \*| | | | | | | | |Устарело (см. dclsocketsNN.bpl: ScktComp.pas длядоп. инфо). Используйте INDY илидр.|

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|WEBSNAP|
|TAdapter| | | | | | | | | | | | |
|TPageAdapter| | | | | | | | | | | | |
|TDataSetAdapter| | | | | | | | | | | | |
|TLoginFormAdapter| | | | | | | | | | | | |
|TStringValuesList| | | | | | | | | | | | |
|TDataSetValuesList| | | | | | | | | | | | |
|TWEBAppНазвание компонентыs| | | | | | | | | | | | |
|TApplicationAdapter| | | | | | | | | | | | |
|TEndUserAdapter| | | | | | | | | | | | |
|TEndUserSessionAdapter| | | | | | | | | | | | |
|TPageDispatcher| | | | | | | | | | | | |
|TAdapterDispatcher| | | | | | | | | | | | |
|TLocateFileService| | | | | | | | | | | | |
|TSessionsService| | | | | | | | | | | | |
|TWebUserList| | | | | | | | | | | | |
|TXSLPageProducer| | | | | | | | | | | | |
|TAdapterPageProducer| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 предв.|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|DIALOGS|
|TColorDialog| | | | | | | | | | | | |
|TFolderBrowserDialog| | | | | | | | | | | |Delphi: какфункция|
|TFindDialog| | | | | | | | | | | | |
|TFontDialog| | | | | | | | | | | | |
|TOpenDialog| | | | | | | | | | | | |
|TOpenPictureDialog| | | | | | | | | | | | |
|TOpenTextFileDialog| | | | | | | | | | | | |
|TPageSetupDialog| | | | | | | | | | | | |
|TPrintDialog| | | | | | | | | | | | |
|TPrinterSetupDialog| | | | | | | | | | | | |
|TReplaceDialog| | | | | | | | | | | | |
|TSaveDialog| | | | | | | | | | | | |
|TSavePictureDialog| | | | | | | | | | | | |
|TSaveTextFileDialog| | | | | | | | | | | | |
|PrintPreviewControl| | | | | | | | | | | | |
|PrintPreviewDialog| | | | | | | | | | | | |
|PrintDocument| | | | | | | | | | | | |
|ReportDocument| | | | | | | | | | | | |
|CrystalReportViewer| | | | | | | | | | | | |

|Название компоненты|D7 VCL32|CB6 W32|D2005 VCL32|D2005 VCL.Net|D2005 WForms|D2006 VCL32|D2006 VCL.Net|D2006 WForms|C++ 2006 preview|VS.Net|VS.Net 2005|Примечания|
|-------------------|:------:|:-----:|:---------:|:-----------:|:----------:|:---------:|:-----------:|:----------:|:-------------:|:----:|:---------:|----------|
|ECO/BOLD|
|...| | | | | | | | | | | |ECO заменило BOLD в D2005Bold для Win32/VCL и ECO для .Net/.Net+Winforms|
|DECISION CUBE|
|...| | | | | | | | | | | | |
|SAMPLES|
|...| | | | | | | | | | | | |
|ColorGrid| | | | | | | | | | | | |
|Gauge| | | | | | | | | \*| | |TCGaude|
|CollapsePanel| | | | | | | | | | | | |
|FASTNET|
|...| | | | | | | | | | | | |
|ACTIVEX|
|...| | | | | | | | | | | | |
|RAVE REPORTS|
|...| | | | | | | | | | | | |
|INDY|
|...| | | | | \*| | | \*| | \*| |www.indyproject.org|
|COM+|
|...| | | | | | | | | | | | |
|IntraWeb|
|...| | | | | | | | | | \*| | |
|SERVERS|
|...| | | | | | | | | | | | |

