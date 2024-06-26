---
Title: Как сделать загрузчик приложений с TCP?
Author: Max Kleiner
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как сделать загрузчик приложений с TCP?
==================================

> How to do an application loader with TCP?

    {
    Loading Delphi apps without a browser and on Win as Linux as well needs a
    decision once.
    With a loader on the client side, no further installation is in charge.
    We had the requirement starting different Delphi apps from a
    linux or windows server, wherever you are.
    We call it Delphi Web Start (DWS).
    The dws-client gets a list and after clicking on it, the app is
    loading from server to client with just a stream.
    First we had to choose between a ftp and a tcp solution. The
    advantage of tcp is the freedom to define a separate port, which
    was "services, port 9010 - DelphiWebStart".
    You will need indy. Because it is simple to use and very fast.
    The tcp-server comes from indy which has one great advantage:
     
     
    CommandHandlers is a collection of text commands that will be
    processed by the server. This property greatly simplify the
    process of building servers based on text protocols.
     
     
    First we start with DWS_Server,
    so we define two command handlers:
    }
     
    CTR_LIST = 'return_list';
    CTR_FILE = 'return_file';
     
    {
    By starting the tcp-server it returns with the first command
    handler "CTR_LIST" a list of the apps:
    }
     
    procedure TForm1.IdTCPServer1Execute(AThread: TIdPeerThread);
    ...
    // comes with writeline from client
    if sRequest = CTR_LIST then begin
      for idx:= 0 to meData.Lines.Count - 1 do
      athread.Connection.WriteLn(ExtractFileName(meData.Lines[idx]));
      aThread.Connection.WriteLn('::END::');
      aThread.Connection.Disconnect;
     
     
    {
    One word concerning the thread:
    In the internal architecture there are 2 threads categories.
     
    First is a listener thread that "listen" and waits for a
    connection. So we don't have to worry about threads, the built in
    thread will be served by indy though parameter:
    }
     
    IdTCPServer1Execute(AThread: TIdPeerThread)
     
    {
    When our dws-client is connected, this thread transfer all the
    communication operations to another thread.
    This technique is very efficient because your client application
    will be able to connect any time, even if there are many
    different connections to the server.
    }
     
     
    //The second command "CTR_FILE" transfers the app to the client:
    if Pos(CTR_FILE, sRequest) > 0 then begin
        iPos := Pos(CTR_FILE, sRequest);
        FileName := GetFullPath(FileName);
        if FileExists(FileName) then begin
          lbStatus.Items.Insert(0, Format('%-20s %s',
            [DateTimeToStr(now), 'Transfer starts ...']));
         FileStream := TFileStream.Create(FileName, fmOpenRead +
         fmShareDenyNone);
         aThread.Connection.OpenWriteBuffer;
         aThread.Connection.WriteStream(FileStream);
         aThread.Connection.CloseWriteBuffer;
         FreeAndNil(FileStream);
         aThread.Connection.Disconnect;
     
     
    {
    Now let's have a look at the client side. The client connects to
    the server, using the connect method of TIdTcpClient. In this
    moment, the client sends any command to the server, in our case
    (you remember DelphiWebStart) he gets the list of available apps:
    }
     
        with IdTCPClient1 do begin
          if Connected then DisConnect;
          showStatus;
          Host:= edHost.Text;
          Port:= StrToInt(edPort.Text);
          Connect;
          WriteLn(CTR_LIST);
     
    //After clicking on his choice, the app will be served:
     
    with IdTCPClient1 do begin
    ExtractFileName(lbres.Items[lbres.ItemIndex])]));
    WriteLn(CTR_FILE + lbres.Items[lbres.ItemIndex]);
    FileName:= ExpandFileName(edPath.Text + '/' +
    ExtractFileName(lbres.Items[lbres.ItemIndex]));
    ...
    FileStream := TFileStream.Create(FileName, fmCreate);
       while connected do begin
         ReadStream(FileStream, -1, true);
      ....
        {$IFDEF LINUX}
            execv(pchar(filename),NIL);
          //libc.system(pchar(filename));
         {$ENDIF}
         {$IFDEF MSWINDOWS}
         // shellapi.WinExec('c:\testcua.bat', SW_SHOW);
         with lbstatus.items do begin
           case  shellapi.shellExecute(0,'open', pchar(filename), '',NIL,
                        SW_SHOWNORMAL) of
             0: insert(0, 'out of memory or resources');
             ERROR_BAD_FORMAT: insert(0, 'file is invalid in image');
             ERROR_FILE_NOT_FOUND: insert(0,'file was not found');
             ERROR_PATH_NOT_FOUND: insert(0,'path was not found');
           end;
           Insert(0, Format('%-20s %s',
                   [DateTimeToStr(now), filename + ' Loaded...']));
         end
         {$ENDIF}
     
    {
    One note about execution on linux with libc-commands; there will
    be better solutions (execute and wait and so on) and we still
     
    work on it, so I'm curious about comments on
     
       "Delphi Web Start"
     
    therfore my aim is to publish improvments in a basic framework on
    sourceforge.net depends on your feedback ;)
     
    Many thanks to Dr. Karlheinz Morth with a first glance.
     
    Test your server with the telnet program. Type telnet
    hostname:9010 and then: 'return_list' and you'll get the list
    from the apps you defined in a txt-file on the server.
    }
     
    meData.Lines.LoadFromFile(ExpandFileName(FILE_PATH));
     
    {
    I know that we haven't implement an error handling procedure,
    but for our scope this example is almost
    sufficient.
    Code is available: http://max.kleiner.com/download/dws.zip
    }

