---
Title: Демонстрационная программа сканирования сети
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Демонстрационная программа сканирования сети
============================================

Демонстрационная программа сканирования сети на основе WNetOpenEnum,
WNetEnumResource, WNetCloseEnum

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  Демонстрационная программа сканирования сети на основе
    //  WNetOpenEnum, WNetEnumResource, WNetCloseEnum
    //
    //  Автор: Александр (Rouse_) Багель
    //  mailto:rouse79@yandex.ru
    //
    //  Специально для форумов Мастера Дельфи и Исходники.RU
    //  http://www.delphimaster.ru
    //  http://forum.sources.ru
    //
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ComCtrls, Winsock, ImgList, ShellAPI;
     
    const
      STR_START    =  'Начать сканирование';
      STR_STOP     =  'Остановить сканирование';
      STR_STARTED  =  '   Идет сканирование ...';
      STR_STOPPED  =  '   Сканирование завершено ...';
      STR_END      =  '   Завершение потока ...';
      STR_FIELD    =  '   Поле не выбрано ...';
     
    type
      TDemoThread = class(TThread)
      private
        TreeNetWrk: TTreeNode;
        TreeDomain: TTreeNode;
        TreeServer: TTreeNode;
        TreeShares: TTreeNode;
        Param_dwType: Byte;
        Param_dwDisplayType: Byte;
        Param_lpRemoteName: String;
        Param_lpIP: String;
      protected
        procedure Execute; override;
        procedure Scan(Res: TNetResource; Root: boolean);
        procedure AddElement;
        procedure Stop;
      end;
     
      TForm1 = class(TForm)
        Button1: TButton;
        TreeView1: TTreeView;
        StatusBar1: TStatusBar;
        ImageList1: TImageList;
        procedure Button1Click(Sender: TObject);
        procedure TreeView1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure TreeView1DblClick(Sender: TObject);
      private
        Thread: TDemoThread;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    function GetIPAddress(NetworkName: String): String;
    var
     Error: DWORD;
     HostEntry: PHostEnt;
     Data: WSAData;
     Address: In_Addr;
    begin
      Delete(NetworkName, 1, 2);
      Error:=WSAStartup(MakeWord(1, 1), Data);
      if Error = 0 then
      begin
        HostEntry:=gethostbyname(PChar(NetworkName));
        Error:=GetLastError;
        if Error = 0 then
        begin
          Address:=PInAddr(HostEntry^.h_addr_list^)^;
          Result:=inet_ntoa(Address);
        end
        else
         Result:='Unknown';
      end
      else
        Result:='Error';
      WSACleanup;
    end;
     
    { TDemoThread }
     
    procedure TDemoThread.Execute;
    var
      R:TNetResource;
    begin
      inherited;
      Priority := tpIdle;
      FreeOnTerminate := True;
      Resume;
      Scan(R, True);
      TreeDomain := nil;
      TreeServer := nil;
      Synchronize(Stop);
    end;
     
    procedure TDemoThread.Scan(Res: TNetResource; Root: boolean);
    var
     hEnum: Cardinal;
     nrResource: array[0..512] of TNetResource;
     dwSize: DWORD;
     numEntries: DWORD;
     I: DWORD;
     dwResult: DWORD;
    begin
      if Root then
        dwResult := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY,
          0, nil, hEnum)
      else
        dwResult := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_ANY,
          0, @Res, hEnum);
      if dwResult = NO_ERROR then
      begin
        dwSize := SizeOf(nrResource);
        numEntries := DWORD(-1);                                   // ERROR_NO_MORE_ITEMS
        if WNetEnumResource(hEnum, numEntries, @nrResource, dwSize) = NO_ERROR then
        begin
          for i := 0 to numEntries - 1 do
          begin
            if Terminated then Break;
            with nrResource[i] do
            begin
              Param_dwType := dwType;
              Param_dwDisplayType := dwDisplayType;
              Param_lpRemoteName := lpRemoteName;
              if Param_dwDisplayType = RESOURCEDISPLAYTYPE_SERVER then
                Param_lpIP := GetIPAddress(Param_lpRemoteName);
            end;
            if Assigned(nrResource[i].lpRemoteName) then
              Synchronize(AddElement);
            Scan(nrResource[i], false);
          end;
        WNetCloseEnum(hEnum);
        end;
      end;
    end;
     
    procedure TDemoThread.AddElement;
    begin
      Application.ProcessMessages;
      case Param_dwDisplayType of
        RESOURCEDISPLAYTYPE_NETWORK:
        begin
          TreeNetWrk := Form1.TreeView1.Items.Add(nil, Param_lpRemoteName);
          TreeNetWrk.StateIndex := 1;
        end;
        RESOURCEDISPLAYTYPE_DOMAIN:
        begin
          TreeDomain := Form1.TreeView1.Items.AddChild(TreeNetWrk, Param_lpRemoteName);
          TreeDomain.StateIndex := 2;
        end;
        RESOURCEDISPLAYTYPE_SERVER:
        begin
          TreeServer := Form1.TreeView1.Items.AddChild(TreeDomain, Param_lpRemoteName + ' IP: ' + Param_lpIP);
          TreeServer.StateIndex := 3;
        end;
        RESOURCEDISPLAYTYPE_SHARE:
        begin
          TreeShares := Form1.TreeView1.Items.AddChild(TreeServer, Param_lpRemoteName);
          TreeShares.StateIndex := 3 + Param_dwType;
        end;
      end;
    end;
     
    procedure TDemoThread.Stop;
    begin
      Form1.StatusBar1.Panels[1].Text := STR_STOPPED;
      Form1.Button1.Caption := STR_START;
      Form1.Button1.Enabled := True;
      Form1.Tag := 0;
    end;
     
    { TForm1 }
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Tag := 0;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Tag := Tag + 1;
      if (Tag mod 2) = 1 then
      begin
        TreeView1.Items.Clear;
        StatusBar1.Panels[1].Text := STR_STARTED;
        Button1.Caption := STR_STOP;
        Thread := TDemoThread.Create(False);
      end
      else
      begin
        StatusBar1.Panels[1].Text := STR_END;
        Button1.Enabled := False;
        Thread.Terminate;
      end;
    end;
     
    procedure TForm1.TreeView1Click(Sender: TObject);
    begin
      if Assigned(TreeView1.Selected) then
        StatusBar1.Panels[0].Text := '   ' + TreeView1.Selected.Text
      else
        StatusBar1.Panels[0].Text := STR_FIELD;
    end;
     
    procedure TForm1.TreeView1DblClick(Sender: TObject);
    var
      Str: String;
    begin
      if Assigned(TreeView1.Selected) then
      begin
        Str := TreeView1.Selected.Text;
        if Copy(Str, 1, 2) <> '\\' then Exit;
        if Pos(' IP:', Str) <> 0 then
          ShellExecute(Handle, 'explore', PChar(Copy(Str, 1, Pos(' IP:', Str))), nil, nil, SW_SHOW)
        else
          ShellExecute(Handle, 'explore', PChar(Str), nil, nil, SW_SHOW);
      end;
    end;
     
    end.

Скачать демонстрационный пример: [netscan.zip](netscan.zip) 10K

