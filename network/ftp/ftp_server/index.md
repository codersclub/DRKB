---
Title: Пример FTP-сервера
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Пример FTP-сервера
==================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, IdBaseComponent, IdComponent, IdUDPBase, IdUDPServer,
      IdTrivialFTPServer, StdCtrls, IdUDPClient, IdTrivialFTP;
     
    type
      TForm1 = class(TForm)
        IdTrivialFTPServer1: TIdTrivialFTPServer;
        IdTrivialFTP1: TIdTrivialFTP;
        Button1: TButton;
        Button2: TButton;
        procedure FormCreate(Sender: TObject);
        procedure IdTrivialFTPServer1ReadFile(Sender: TObject;
          var FileName: string; const PeerInfo: TPeerInfo;
          var GrantAccess: Boolean; var AStream: TStream;
          var FreeStreamOnComplete: Boolean);
        procedure IdTrivialFTPServer1TransferComplete(Sender: TObject;
          const Success: Boolean; const PeerInfo: TPeerInfo; AStream: TStream;
          const WriteOperation: Boolean);
        procedure IdTrivialFTPServer1WriteFile(Sender: TObject;
          var FileName: string; const PeerInfo: TPeerInfo;
          var GrantAccess: Boolean; var AStream: TStream;
          var FreeStreamOnComplete: Boolean);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        TFTPPath: string;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      IdTrivialFTPServer1.ThreadedEvent := True;
      IdTrivialFTPServer1.Active := True;
      { Set the path to where the files will be stored/retreived }
      TFTPPath := IncludeTrailingPathDelimiter('C:\Temp');
    end;
     
    procedure TForm1.IdTrivialFTPServer1ReadFile(Sender: TObject;
      var FileName: string; const PeerInfo: TPeerInfo;
      var GrantAccess: Boolean; var AStream: TStream;
      var FreeStreamOnComplete: Boolean);
    var
      FS: TFileStream;
    begin
      FreeStreamOnComplete := True;
      try
        { Convert UNIX style filenames to WINDOWS style }
        while Pos('/', Filename) <> 0 do
          Filename[Pos('/', Filename)] := '\';
        { Assure that the filename DOES NOT CONTAIN any path information }
        Filename := ExtractFileName(Filename);
        { Check if file exists }
        if FileExists(TFTPPath + Filename) then
        begin
          { Open file in READ ONLY mode }
          FS := TFileStream.Create(TFTPPath + Filename,
            fmOpenRead or fmShareDenyWrite);
          { Assign stream to variable }
          AStream := FS;
          { Set parameters }
          GrantAccess := True;
        end
        else
        begin
          GrantAccess := False;
        end;
      except
        { On errors, deny access }
        GrantAccess := False;
        if Assigned(FS) then
          FreeAndNil(FS);
      end;
    end;
     
    procedure TForm1.IdTrivialFTPServer1WriteFile(Sender: TObject;
      var FileName: string; const PeerInfo: TPeerInfo;
      var GrantAccess: Boolean; var AStream: TStream;
      var FreeStreamOnComplete: Boolean);
    var
      FS: TFileStream;
    begin
      try
        { Convert UNIX style filenames to WINDOWS style }
        while Pos('/', Filename) <> 0 do
          Filename[Pos('/', Filename)] := '\';
        { Assure that the filename DOES NOT CONTAIN any path information }
        Filename := ExtractFileName(Filename);
        { Open file in WRITE ONLY mode }
        FS := TFileStream.Create(TFTPPath + Filename,
          fmCreate or fmShareExclusive);
        { Copy all the data }
        AStream := FS;
        { Set parameters }
        FreeStreamOnComplete := True;
        GrantAccess := True;
      except
        { On errors, deny access }
        GrantAccess := False;
        if Assigned(FS) then
          FreeAndNil(FS);
      end;
    end;
     
    procedure TForm1.IdTrivialFTPServer1TransferComplete(Sender: TObject;
      const Success: Boolean; const PeerInfo: TPeerInfo; AStream: TStream;
      const WriteOperation: Boolean);
    begin
      // Success = TRUE if the read/write operation was successfull
      // WriteOperation = TRUE if the client SENT a file to the server
      try
        { Close the FileStream }
        if Assigned(AStream) then
          FreeAndNil(AStream);
      except
      end;
    end;
     
    // Example of how to DOWNLOAD a file from the server
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      ST: TMemoryStream;
    begin
      ST := TMemoryStream.Create;
      IdTrivialFTP1.Get('testfile.dat', ST);
      if Assigned(ST) then
      begin
        ShowMessage('Filesize=' + IntToStr(ST.Size));
        FreeAndNil(ST);
      end;
    end;
     
    // Example of how to UPLOAD a file to the server
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      ST: TMemoryStream;
      I: Integer;
      S: string;
    begin
      { Create stream }
      ST := TMemoryStream.Create;
      { Initialize data }
      S := 'This is a test file. It whould appear in the ' +
        'TFTP Server upload directory.' + #13#10;
      { Store in stream }
      ST.Write(S[1], Length(S));
      ST.Position := 0;
      { Send Stream to TFTP Server }
      IdTrivialFTP1.Put(ST, 'textfile.txt');
      { Free Stream }
      if Assigned(ST) then
        FreeAndNil(ST);
      { Show a dialog }
      ShowMessage('Done!');
    end;
     
    end.

