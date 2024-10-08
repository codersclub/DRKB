---
Title: Написание Terminal Services Client
Author: Carlo Pasolini, ccpasolini@libero.it
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
Date: 01.01.2007
---

Написание Terminal Services Client
==================================

    {
    "WINDOWS2000 SERVER" / "WINDOWS XP" terminal services are very important in a computer 
    network: each client computer can emulate server's desktop by using a simple executable 
    named "mstsc.exe". This executable uses the ActiveX control "MStscax" defined in 
    "mstscax.dll". 
    These files are automatically installed in Windows XP and Windows 2000 Server but not 
    in Windows2000 Professional or Windows98. You can download the entire package containing
    these file at the following url: 
     
    http://www.microsoft.com/windows2000/downloads/recommended/TSAC/tsmsi.asp?Lang=
     
    After downloading the executable "tsmsisetup.exe", run it to unpack. Now let's
    take into consideration the folder "System32": this is the folder containing 
    "mstsc.exe" and "mstscax.dll".
    Now register the ActiveX control "MsTscAx":
     
      1)Start->Run->
      2)type the following command line: regsvr32 <path to mstscax.dll>\mstscax.dll
     
    where <path to mstscax.dll> is the complete path to the file "mstscax.dll".
     
    In this article I will show you how to embed the ActiveX control "MsTscAx" 
    in a Delphi application in order to build a substitute of "mstsc.exe". 
     
    First of all you must import the ActiveX control "mstscax":
    in the Delphi IDE:
    1)Component->Import ActiveX Control
    2)Select "Microsoft Terminal Services Control" 
      the class name will be "TMsTscAx"
    3)Select the unit dir name and press "Create Unit": you have created the import Unit.
    4)Create a package or select an existing one and add the created unit to this package
      Recompile the package and now delphi palette will contain (in the ActiveX tab if you
      haven't changed it in the importing process) the MstScax component.
     
    Now create a new Delphi project and add the Mstscax component to it.
    Let's go to analize the interesting properties of this new component: 
     
    1)Server: this is the IP of the Windows2000 Server computer whose desktop we want
      to emulate
    2)BitmapPeristence: 
      1 if you want to cache Bitmaps or 0 otherwise 
    3)Compress:
      1 if you want to cache data or 0 otherwise  
     
    With the "Connect" method I open a terminal emulation session.
    With the "Disconnect" method I disconnect from a terminal emulation session but the
    session itself isn't closed on the server.
     
    Another important feature of "Client Terminal Service" is the ability to define a
    program that automatically run when the client machine opens a terminal 
    emulation session. You can programatically achieve this target in this manner:
     
    Set_StartProgram(<Path to Exe>\<Exe filename>);
     
    Once defined an automatically running program, the client computer will see a remote
    desktop which is clear except for the presence of the program itself; this is
    useful if you want to restrict the operative range of your client computers to the 
    program itself. When the program is closed, the connection is closed and the session
    on the windows 2000 server computer is closed.
     
    this is the code of my example project:
    }
     
    unit Main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      OleCtrls, ExtCtrls, StdCtrls,
      MSTSCLib_TLB;//the import Unit: substitute it with the name you assigned
                   //during the import process if this is different to it
     
    type
      TForm1 = class(TForm)
        MsTscAx1: TMsTscAx;
        Panel1: TPanel;
        btConnect: TButton;
        procedure btConnectClick(Sender: TObject); //connection button
        procedure FormCreate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure MsTscAx1Disconnected(Sender: TObject;
          DisconnectReason: Integer);
        procedure MsTscAx1Connecting(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.btConnectClick(Sender: TObject);
    begin
      MsTscAx1.Connect;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Left   := 0;
      Top    := 0;
      Height := Screen.Height - 20;
      Width  := Screen.Width;
     
      MsTscAx1.Server := '1.2.3.4'; //substitute it with the IP Address of your server 
      with MsTscAx1.AdvancedSettings do
      begin
        BitmapPeristence := 1;//enable bitmap cache
        Compress         := 1;//enable data cache
      end;
      with MsTscAx1.SecuredSettings do
      begin
        Set_StartProgram('C:\Sviluppo\Delphi\DbBrowser.exe');
        //the program I want to run 
      end;
    end;
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      if not btConnect.Enabled then 
      //I must close the automatically running program before closing
      //my terminal emulation program
      begin
        MessageDlg('Close "DbBrowser.exe" before closing the application!',
          mtInformation, [mbOK], 0);
        Action := caNone;
      end;
    end;
     
    procedure TForm1.MsTscAx1Disconnected(Sender: TObject;
      DisconnectReason: Integer);
    begin
      btConnect.Enabled := True;
    end;
     
    procedure TForm1.MsTscAx1Connecting(Sender: TObject);
    begin
      btConnect.Enabled := False;
    end;
     
    end. 
     
    {
    In order to run this application in another computer you must copy the file
    "mstscax.dll" on the target 
    computer and register it with "regsvr32" as shown at the beginning of this
    article. You can automate this
    process by embedding the file in your executable, etc..
     
    Carlo Pasolini, Riccione(Italy), ccpasolini@libero.it
    }

