---
Title: Как выключить удаленный компьютер?
Author: Stewart Moss
Date: 27.02.2002 16:30
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как выключить удаленный компьютер?
==================================

    {-----------------------------------------------------------------------------
     Unit Name:     formClient
     Author:        Stewart Moss
     
     Creation Date: 27 February, 2002 (16:30)
     Documentation Date: 27 February, 2002 (16:30)
     
     Version 1.0
     -----------------------------------------------------------------------------
     
     Description:
     
      This is to demonstrate shutting down a machine over the network.
     
      ** Tobias R. requests the article "How to send a shutdown command in a network?" **
     
      This is not really what you want. I think you are looking for some kind
      of IPC or RPC command. But this will work. Each machine needs to run
      a copy of this server.
     
      It uses the standard delphi ServerSocket found in the "ScktComp" unit.
     
      Create a form (name frmClient) with a TServerSocket on it (name ServerSocket)
      set the Port property of ServerSocket to 5555. Add a TMemo called Memo1.
     
      It listens on port 5555 using TCP/IP.
     
      It has a very simple protocol.
      Z = Show message with "Z"
      B = Beep
      S = Shutdown windows
     
      Run the program.. Then from the command prompt type in
      "telnet localhost 5555". Type in one of the three commands above
      (all in uppercase) and the server will respond.
     
     Copyright 2002 by Stewart Moss. All rights reserved.
    -----------------------------------------------------------------------------}
     
    unit formClient;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ScktComp, StdCtrls;
     
    type
      TfrmClient = class(TForm)
        ServerSocket: TServerSocket;
        Memo1: TMemo;
        procedure ServerSocketClientRead(Sender: TObject;
          Socket: TCustomWinSocket);
        procedure FormCreate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      frmClient: TfrmClient;
     
    implementation
     
    {$R *.DFM}
     
    procedure TfrmClient.ServerSocketClientRead(Sender: TObject;
      Socket: TCustomWinSocket);
    var
      Incomming: string;
    begin
      // read off the socket
      Incomming := Socket.ReceiveText;
     
      memo1.Lines.Add(incomming);
     
      if Incomming = 'S' then // Shutdown Protocol
        ExitWindowsEx(EWX_FORCE or EWX_SHUTDOWN, 0);
     
      if Incomming = 'B' then // Beep Protocol
        Beep;
     
      if Incomming = 'Z' then // Z protocol
        showmessage('Z');
    end;
     
    procedure TfrmClient.FormCreate(Sender: TObject);
    begin
      ServerSocket.Active := true;
    end;
     
    procedure TfrmClient.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      ServerSocket.Active := false;
    end;
     
    end.

