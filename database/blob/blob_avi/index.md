---
Title: Storing / Playing an AVI file in a database
Date: 01.01.2007
---


Storing / Playing an AVI file in a database
===========================================

> How can I store an AVI file in a database and then play AVI files?

AVI files can be stored in BLOB (binary large object) fields.

The easiest way to play an AVI file stored in a BLOB is to write
the BLOB data to a temporary file, then let the mulimedia player
play the file. The following example demonstrates how to store
an AVI file to a BLOB field, and also play the AVI file from the
BLOB field.

    var
      FileName : string;
     
    {This function gets a temporary file name form the system}
    function GetTemporaryFileName : string;
    {$IFNDEF WIN32}
      const MAX_PATH = 144;
    {$ENDIF}
    var
     {$IFDEF WIN32}
      lpPathBuffer : PChar;
     {$ENDIF}
      lpbuffer : PChar;
    begin
     {Get the file name buffer}
      GetMem(lpBuffer, MAX_PATH);
     {$IFDEF WIN32}
     {Get the temp path buffer}
      GetMem(lpPathBuffer, MAX_PATH);
     {Get the temp path}
      GetTempPath(MAX_PATH, lpPathBuffer);
     {Get the temp file name}
      GetTempFileName(lpPathBuffer,
                      'tmp',
                      0,
                      lpBuffer);
     {Free the temp path buffer}
      FreeMem(lpPathBuffer, MAX_PATH);
     {$ELSE}
     {Get the temp file name}
      GetTempFileName(GetTempDrive('C'),
                      'tmp',
                      0,
                      lpBuffer);
     {$ENDIF}
     {Create a pascal string containg}
     {the  temp file name and return it}
      result := StrPas(lpBuffer);
     {Free the file name buffer}
      FreeMem(lpBuffer, MAX_PATH);
    end;
     
    {Read a AVI file into a blob field}
    procedure TForm1.Button1Click(Sender: TObject);
    var
      FileStream: TFileStream; {to load the avi file}
      BlobStream: TBlobStream; {to save to the blob}
    begin
     {Allow the button to repaint}
      Application.ProcessMessages;
     {Turn off the buttons}
      Button1.Enabled := false;
      Button2.Enabled := false;
     {Assign the avi file name to read}
      FileStream := TFileStream.Create(
        'C:\PROGRA~1\BORLAND\DELPHI~1\DEMOS\COOLSTUF\COOL.AVI',
        fmOpenRead);
      Table1.Edit;
     {Create a BlobStream for the TField Table1AVI}
      BlobStream := TBlobStream.Create(Table1AVI, bmReadWrite);
     {Seek to the Beginning of the stream}
      BlobStream.Seek(0, soFromBeginning);
     {Delete any data that may be there}
      BlobStream.Truncate;
     {Copy from the FileStream to the BlobStream}
      BlobStream.CopyFrom(FileStream, FileStream.Size);
     {Free the streams}
      FileStream.Free;
      BlobStream.Free;
     {Post the record}
      Table1.Post;
     {Enable the buttons}
      Button1.Enabled := true;
      Button2.Enabled := true;
    end;
     
    {Read an avi stored in a blob, and play it}
    procedure TForm1.Button2Click(Sender: TObject);
    var
      FileStream: TFileStream; {a temp file}
      BlobStream: TBlobStream; {the AVI Blob}
    begin
     {Create a blob stream for the AVI blob}
      BlobStream := TBlobStream.Create(Table1AVI, bmRead);
      if BlobStream.Size = 0 then begin
       BlobStream.Free;
       Exit;
      end;
     {Close the media player}
      MediaPlayer1.Close;
     {Reset the file name}
      MediaPlayer1.FileName := '';
     {Refresh the play window}
      MediaPlayer1.Display := Panel1;
      Panel1.Refresh;
     {if we have a temp file then erase it}
      if FileName  '' then
        DeleteFile(FileName);
     {Get a temp file name}
      FileName := GetTemporaryFileName;
     {Create a temp file stream}
      FileStream := TFileStream.Create(FileName,
                                       fmCreate or fmOpenWrite);
     {Copy the blob to the temp file}
      FileStream.CopyFrom(BlobStream, BlobStream.Size);
     {Free the streams}
      FileStream.Free;
      BlobStream.Free;
     {Setup the Media player to play the AVI file}
      MediaPlayer1.FileName := filename;
      MediaPlayer1.DeviceType := dtAviVideo;
      MediaPlayer1.Open;
      MediaPlayer1.Play;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     {Unassign the temp file from the media player}
      MediaPlayer1.Close;
      MediaPlayer1.FileName := '';
     {Erase the temp file}
      if FileName  '' then
        DeleteFile(FileName);
    end;
