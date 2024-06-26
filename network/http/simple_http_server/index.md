---
Title: Пример простейшего HTTP-сервера
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Пример простейшего HTTP-сервера
===============================

    unit uMainForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      IdBaseComponent, IdComponent, IdTCPServer, IdHTTPServer, StdCtrls,
      ExtCtrls, HTTPApp;
     
    type
      TfrmServer = class(TForm)
        httpServer: TIdHTTPServer;
        chkActive: TCheckBox;
        Label1: TLabel;
        edtRootFolder: TEdit;
        btnGetFolder: TButton;
        Label2: TLabel;
        edtDefaultDoc: TEdit;
        lstLog: TListBox;
        Bevel1: TBevel;
        btnClearLog: TButton;
        procedure btnGetFolderClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure chkActiveClick(Sender: TObject);
        procedure btnClearLogClick(Sender: TObject);
        procedure httpServerCommandGet(AThread: TIdPeerThread;
          RequestInfo: TIdHTTPRequestInfo; ResponseInfo: TIdHTTPResponseInfo);
        procedure pgpEHTMLHTMLTag(Sender: TObject; Tag: TTag;
          const TagString: string; TagParams: TStrings;
          var ReplaceText: string);
      private
        procedure Log(Data: string);
        procedure LogServerState;
      public
      end;
     
    var
      frmServer: TfrmServer;
     
    implementation
     
    uses
      ShlObj, FileCtrl;
     
    {$R *.DFM}
     
    // copied from the last "Latium Software - Pascal Newsletter #33"
     
    function BrowseCallbackProc(Wnd: HWND; uMsg: UINT;
      lParam, lpData: LPARAM): Integer stdcall;
    var
      Buffer: array[0..MAX_PATH - 1] of char;
    begin
      case uMsg of
        BFFM_INITIALIZED:
          if lpData <> 0 then
            SendMessage(Wnd, BFFM_SETSELECTION, 1, lpData);
        BFFM_SELCHANGED:
          begin
            SHGetPathFromIDList(PItemIDList(lParam), Buffer);
            SendMessage(Wnd, BFFM_SETSTATUSTEXT, 0, Integer(@Buffer));
          end;
      end;
      Result := 0;
    end;
     
    // copied from the last "Latium Software - Pascal Newsletter #33"
     
    function BrowseForFolder(Title: string; RootCSIDL: integer = 0;
      InitialFolder: string = ''): string;
    var
      BrowseInfo: TBrowseInfo;
      Buffer: array[0..MAX_PATH - 1] of char;
      ResultPItemIDList: PItemIDList;
    begin
      with BrowseInfo do
      begin
        hwndOwner := Application.Handle;
        if RootCSIDL = 0 then
          pidlRoot := nil
        else
          SHGetSpecialFolderLocation(hwndOwner, RootCSIDL,
            pidlRoot);
        pszDisplayName := @Buffer;
        lpszTitle := PChar(Title);
        ulFlags := BIF_RETURNONLYFSDIRS or BIF_STATUSTEXT;
        lpfn := BrowseCallbackProc;
        lParam := Integer(Pointer(InitialFolder));
        iImage := 0;
      end;
      Result := '';
      ResultPItemIDList := SHBrowseForFolder(BrowseInfo);
      if ResultPItemIDList <> nil then
      begin
        SHGetPathFromIDList(ResultPItemIDList, Buffer);
        Result := Buffer;
        GlobalFreePtr(ResultPItemIDList);
      end;
      with BrowseInfo do
        if pidlRoot <> nil then
          GlobalFreePtr(pidlRoot);
    end;
     
    // clear log file
     
    procedure TfrmServer.btnClearLogClick(Sender: TObject);
    begin
      lstLog.Clear;
    end;
     
    // got http server root folder
     
    procedure TfrmServer.btnGetFolderClick(Sender: TObject);
    var
      NewFolder: string;
    begin
      NewFolder := BrowseForFolder('Web Root Folder', 0, edtRootFolder.Text);
      if NewFolder <> '' then
        if DirectoryExists(NewFolder) then
          edtRootFolder.Text := NewFolder;
    end;
     
    // de-activate http server
     
    procedure TfrmServer.chkActiveClick(Sender: TObject);
    begin
      if chkActive.Checked then
      begin
        // root folder must exists
        if AnsiLastChar(edtRootFolder.Text)^ = '\' then
          edtRootFolder.Text :=
            Copy(edtRootFolder.Text, 1, Pred(Length(edtRootFolder.Text)));
        chkActive.Checked := DirectoryExists(edtRootFolder.Text);
        if not chkActive.Checked then
          ShowMessage('Root Folder does not exist.');
      end;
      // de-/activate server
      httpServer.Active := chkActive.Checked;
      // log to list box
      LogServerState;
      // set interactive state for user fields
      edtRootFolder.Enabled := not chkActive.Checked;
      edtDefaultDoc.Enabled := not chkActive.Checked;
    end;
     
    // prepare !
     
    procedure TfrmServer.FormCreate(Sender: TObject);
    begin
      edtRootFolder.Text := ExtractFilePath(Application.ExeName) + 'WebSite';
      ForceDirectories(edtRootFolder.Text);
    end;
     
    // incoming client request for download
     
    procedure TfrmServer.httpServerCommandGet(AThread: TIdPeerThread;
      RequestInfo: TIdHTTPRequestInfo; ResponseInfo: TIdHTTPResponseInfo);
    var
      I: Integer;
      RequestedDocument, FileName, CheckFileName: string;
      EHTMLParser: TPageProducer;
    begin
      // requested document
      RequestedDocument := RequestInfo.Document;
      // log request
      Log('Client: ' + RequestInfo.RemoteIP + ' request for: ' + RequestedDocument);
     
      // 001
      if Copy(RequestedDocument, 1, 1) <> '/' then
        // invalid request
        raise Exception.Create('invalid request: ' + RequestedDocument);
     
      // 002
      // convert all '/' to '\'
      FileName := RequestedDocument;
      I := Pos('/', FileName);
      while I > 0 do
      begin
        FileName[I] := '\';
        I := Pos('/', FileName);
      end;
      // locate requested file
      FileName := edtRootFolder.Text + FileName;
     
      try
        // check whether file or folder was requested
        if AnsiLastChar(FileName)^ = '\' then
          // folder - reroute to default document
          CheckFileName := FileName + edtDefaultDoc.Text
        else
          // file - use it
          CheckFileName := FileName;
        if FileExists(CheckFileName) then
        begin
          // file exists
          if LowerCase(ExtractFileExt(CheckFileName)) = '.ehtm' then
          begin
            // Extended HTML - send through internal tag parser
            EHTMLParser := TPageProducer.Create(Self);
            try
              // set source file name
              EHTMLParser.HTMLFile := CheckFileName;
              // set event handler
              EHTMLParser.OnHTMLTag := pgpEHTMLHTMLTag;
              // parse !
              ResponseInfo.ContentText := EHTMLParser.Content;
            finally
              EHTMLParser.Free;
            end;
          end
          else
          begin
            // return file as-is
            // log
            Log('Returning Document: ' + CheckFileName);
            // open file stream
            ResponseInfo.ContentStream :=
              TFileStream.Create(CheckFileName, fmOpenRead or fmShareCompat);
          end;
        end;
      finally
        if Assigned(ResponseInfo.ContentStream) then
        begin
          // response stream does exist
          // set length
          ResponseInfo.ContentLength := ResponseInfo.ContentStream.Size;
          // write header
          ResponseInfo.WriteHeader;
          // return content
          ResponseInfo.WriteContent;
          // free stream
          ResponseInfo.ContentStream.Free;
          ResponseInfo.ContentStream := nil;
        end
        else if ResponseInfo.ContentText <> '' then
        begin
          // set length
          ResponseInfo.ContentLength := Length(ResponseInfo.ContentText);
          // write header
          ResponseInfo.WriteHeader;
          // return content
        end
        else
        begin
          if not ResponseInfo.HeaderHasBeenWritten then
          begin
            // set error code
            ResponseInfo.ResponseNo := 404;
            ResponseInfo.ResponseText := 'Document not found';
            // write header
            ResponseInfo.WriteHeader;
          end;
          // return content
          ResponseInfo.ContentText := 'The document requested is not availabe.';
          ResponseInfo.WriteContent;
        end;
      end;
    end;
     
    procedure TfrmServer.Log(Data: string);
    begin
      lstLog.Items.Add(DateTimeToStr(Now) + ' - ' + Data);
    end;
     
    procedure TfrmServer.LogServerState;
    begin
      if httpServer.Active then
        Log(httpServer.ServerSoftware + ' is active')
      else
        Log(httpServer.ServerSoftware + ' is not active');
    end;
     
    procedure TfrmServer.pgpEHTMLHTMLTag(Sender: TObject; Tag: TTag;
      const TagString: string; TagParams: TStrings; var ReplaceText: string);
    var
      LTag: string;
    begin
      LTag := LowerCase(TagString);
      if LTag = 'date' then
        ReplaceText := DateToStr(Now)
      else if LTag = 'time' then
        ReplaceText := TimeToStr(Now)
      else if LTag = 'datetime' then
        ReplaceText := DateTimeToStr(Now)
      else if LTag = 'server' then
        ReplaceText := httpServer.ServerSoftware;
    end;
     
    end.

