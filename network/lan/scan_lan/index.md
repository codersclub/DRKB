---
Title: Сканирование локальной сети
Date: 01.01.2007
Author: Rouse_
Source: <https://rouse.drkb.ru>
---


Сканирование локальной сети
===========================

Пример демонстрирующий быстрое сканирование диапазона адресов на наличие
ресурсов общего доступа.

```delphi
////////////////////////////////////////////////////////////////////////////////
//
//  Демонстрационная программа сканирования сети на основе
//  NetShareEnum и перебора диапазона адресов
//
//  Автор: Александр (Rouse_) Багель
//  mailto:rouse79@yandex.ru
//
//  Сепциально для форумов Мастера Дельфи
//  http://www.delphimaster.ru
//

unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ComCtrls, CommCtrl, Winsock, XPMan, ImgList;

resourcestring
  RES_UNKNOWN = 'Неизвестно';
  RES_THREADCOUNT = 'Запущено потоков: %d';
  RES_COMPCOUNT = 'Найдено: %d';
  RES_ERR_RANGE = 'Недопустимый диапазон';

const
  WSA_TYPE = $101;  

type
  LMSTR = LPWSTR;
  NET_API_STATUS = DWORD;

  PShareInfo1 = ^_SHARE_INFO_1;
  _SHARE_INFO_1 = record
   shi1_netname: LMSTR;
   shi1_type: DWORD;
   shi1_remark: LMSTR;
  end;
  TShareInfo1 = _SHARE_INFO_1;

  TIPEdit = class
  private
    FHandle: THandle;
    FIP: Integer;
    FFont: Integer;
    function GetText: String;
    procedure SetText(const Value: String);
  public
    constructor Create(AOwner: TWinControl; Rect: TRect);
    destructor Destroy; override;
    property Text: String read GetText write SetText;
  end;

  TScanThread = class(TThread)
  private
    FIP: Integer;
    FRes: TStringList;
    function GetCompName(const Addr: Integer): String;
    procedure Scan;
    procedure UpdateTree;
    procedure IncCount;
    procedure DecCount; 
  protected
    procedure Execute; override;
  public
    property IP: Integer read FIP write FIP;
  end;

  TMainForm = class(TForm)
    btnStart: TButton;
    gbAddrRange: TGroupBox;
    Label1: TLabel;
    Label2: TLabel;
    ProgressBar: TProgressBar;
    GroupBox2: TGroupBox;
    tvResult: TTreeView;
    Status: TStatusBar;
    XPManifest1: TXPManifest;
    ImageList1: TImageList;
    procedure btnStartClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    IPFrom, IPTo: TIPEdit;
    FThreadCount, FCompFound: Integer;
    procedure SetThreadCount(const Value: Integer);
    procedure SetCompFound(const Value: Integer);
  public
    property ThreadCount: Integer read FThreadCount write SetThreadCount;
    property CompFound: Integer read FCompFound write SetCompFound;
  end;

  function NetShareEnum(servername: LMSTR; level: DWORD; var bufptr: Pointer;
   prefmaxlen: DWORD; entriesread, totalentries,
   resume_handle: LPDWORD): NET_API_STATUS; stdcall; external 'Netapi32.dll';
  function NetApiBufferFree(Buffer: Pointer): NET_API_STATUS; stdcall; external 'Netapi32.dll';

var
  MainForm: TMainForm;

implementation

{$R *.dfm}

{ TIPEdit }

constructor TIPEdit.Create(AOwner: TWinControl; Rect: TRect);
begin
  InitCommonControl(ICC_INTERNET_CLASSES);
  FHandle:= CreateWindow(WC_IPADDRESS, nil, WS_CHILD or WS_VISIBLE,
    Rect.Left, Rect.Top, Rect.Right, Rect.Bottom, AOwner.Handle, 0, hInstance, nil);
  FFont := CreateFont(-11, 0, 0, 0, 400, 0, 0, 0, DEFAULT_CHARSET,
    OUT_DEFAULT_PRECIS, CLIP_DEFAULT_PRECIS, DEFAULT_QUALITY,
    DEFAULT_PITCH or FF_DONTCARE, 'MS Sans Serif');
  SendMessage(FHandle, WM_SETFONT, FFont, 0);
  Text := '0.0.0.0';
end;

destructor TIPEdit.Destroy;
begin
  DeleteObject(FFont);
  inherited;
end;

function TIPEdit.GetText: String;
begin
  SendMessage(FHandle, IPM_GETADDRESS, 0, Longint(PDWORD(@FIP)));
  Result := IntToStr(FIRST_IPADDRESS(FIP))+
      '.' + IntToStr(SECOND_IPADDRESS(FIP)) +
      '.' + IntToStr(THIRD_IPADDRESS(FIP)) +
      '.' + IntToStr(FOURTH_IPADDRESS(FIP));
end;

procedure TIPEdit.SetText(const Value: String);

  function MakeIPAddressEx(b1, b2, b3, b4: Char):LPARAM;
  begin
    Result := MAKEIPADDRESS(DWORD(b1), DWORD(b2), DWORD(b3), DWORD(b4));
  end;

var
  Tmp: TInAddr;
begin
  Tmp.S_addr := inet_addr(PChar(Value));
  if Tmp.S_addr = INADDR_NONE then Exit;
  with Tmp.S_un_b do
    FIP := MakeIPAddressEx(s_b1, s_b2, s_b3, s_b4);
  SendMessage(FHandle, IPM_SETADDRESS, 0, FIP);
end;

{ TScanThread }

procedure TScanThread.DecCount;
begin
  MainForm.ThreadCount := MainForm.ThreadCount - 1;
end;

procedure TScanThread.Execute;
begin
  inherited;
  Synchronize(IncCount);
  Scan;
  Synchronize(DecCount);
end;

function TScanThread.GetCompName(const Addr: Integer): String;
var
  WSA: TWSAData;
  Host: PHostEnt;
  Err: Integer;
begin
  Result := RES_UNKNOWN;
  Err := WSAStartup(WSA_TYPE, WSA);
  if Err <> 0 then  // Лучше пользоваться такой конструкцией,
  begin             // чтобы в случае ошибки можно было увидеть ее код.
    //ShowMessage(SysErrorMessage(GetLastError));
    Exit;
  end;
  try
    if Addr = INADDR_NONE then Exit;
    Host := gethostbyaddr(@Addr, SizeOf(Addr), PF_INET);
    if Assigned(Host) then  // Обязательная проверка, в противном случае, при
      Result := Host.h_name // отсутствии компьютера с заданым IP, получим AV
    else
      //ShowMessage(SysErrorMessage(GetLastError));
  finally
    WSACleanup;
  end;
end;

procedure TScanThread.IncCount;
begin
  MainForm.ThreadCount := MainForm.ThreadCount + 1;
end;

procedure TScanThread.Scan;
type
  TShareInfo1Array = array of TShareInfo1;
var
  entriesread, totalentries: DWORD;
  Info: Pointer;
  I: Integer;
  CompName: PWideChar;
begin
  CompName := StringToOleStr(GetCompName(FIP));
  if CompName = RES_UNKNOWN then Exit;
  FRes := TStringList.Create;
  try
    Fres.Add(CompName);
    if NetShareEnum(CompName, 1, Info, DWORD(-1), @entriesread,
      @totalentries, nil) = 0 then
    try
     if entriesread > 0 then
     begin
       for I := 0 to entriesread - 1 do
         FRes.Add(TShareInfo1Array(@(Info^))[I].shi1_netname);
       Synchronize(UpdateTree);
     end;
    finally
     NetApiBufferFree(Info);
    end;
  finally
    FRes.Free;
  end;
end;

procedure TScanThread.UpdateTree;
var
  I: Integer;
  Root: TTreeNode;
begin
  MainForm.tvResult.Items.BeginUpdate;
  try
    Root := MainForm.tvResult.Items.Add(nil, FRes.Strings[0]);
    for I := 1 to FRes.Count - 1 do
      MainForm.tvResult.Items.AddChild(Root, FRes.Strings[I]);
    MainForm.CompFound := MainForm.CompFound + 1;
  finally
    MainForm.tvResult.Items.EndUpdate;
  end;    
end;

{ TMainForm }

procedure TMainForm.btnStartClick(Sender: TObject);
var
  I, AFrom, ATo: Integer;
  Prefix: String;

  function ValidRange: Boolean;
  var
    F, T: TInAddr;
  begin
    F.S_addr := inet_addr(PChar(IPFrom.Text));
    T.S_addr := inet_addr(PChar(IPTo.Text));
    Result := (F.S_un_b.s_b1 = T.S_un_b.s_b1) and
              (F.S_un_b.s_b2 = T.S_un_b.s_b2) and
              (F.S_un_b.s_b3 = T.S_un_b.s_b3);
    if Result then
    begin
      AFrom := Integer(F.S_un_b.s_b4);
      ATo := Integer(T.S_un_b.s_b4);
      Prefix := IntToStr(Integer(F.S_un_b.s_b1)) + '.' +
                IntToStr(Integer(F.S_un_b.s_b2)) + '.' +
                IntToStr(Integer(F.S_un_b.s_b3)) + '.';
      ProgressBar.Max := ATo - AFrom;
      ProgressBar.Position := 0;
    end
    else
      MessageDlg(RES_ERR_RANGE, mtError, [mbOK], 0);
  end;

begin
  CompFound := 0;
  ThreadCount := 0;
  tvResult.Items.Clear;
  if ValidRange then
  begin
    btnStart.Enabled := False;
    for I := AFrom to ATo do
      with TScanThread.Create(False) do
      begin
        IP := inet_addr(PChar(Prefix + IntToStr(I)));
        FreeOnTerminate := True;
        Resume;
      end;
  end;
end;

procedure TMainForm.FormCreate(Sender: TObject);
begin
  IPFrom := TIPEdit.Create(gbAddrRange, Rect(32, 16, 121, 21));
  IPFrom.Text := '192.168.24.1';
  IPTo := TIPEdit.Create(gbAddrRange, Rect(32, 40, 121, 21));
  IPTo.Text := '192.168.24.254';
end;

procedure TMainForm.SetCompFound(const Value: Integer);
begin
  FCompFound := Value;
  Status.Panels.Items[1].Text := Format(RES_COMPCOUNT, [Value]);
  Application.ProcessMessages;
end;

procedure TMainForm.SetThreadCount(const Value: Integer);
begin
  if Value < FThreadCount then
    ProgressBar.Position := ProgressBar.Max - Value;
  FThreadCount := Value;
  Status.Panels.Items[0].Text := Format(RES_THREADCOUNT, [Value]);
  if Value = 0 then
  begin
    ProgressBar.Position := 0;
    btnStart.Enabled := True;
  end;
  Application.ProcessMessages;
end;

end.
```


Скачать демонстрационный пример: [fastscan.zip](fastscan.zip) 5K

