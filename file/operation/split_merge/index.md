---
Title: Split / merge files
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Split / merge files
===================

    // Split file
         
    {
      Parameters:
     
      FileToSplit: Specify a file to split.
      SizeofFiles: Specify the size of the files you want to split to (in bytes)
      Progressbar: Specify a TProgressBar to show the splitting progress
     
      Result:
      SplitFile() will create files  FileName.001, FileName.002, FileName.003 and so on
      that are SizeofFiles bytes in size.
     }
     
    function SplitFile(FileName : TFileName; SizeofFiles : Integer; ProgressBar : TProgressBar) : Boolean;
    var
      i : Word;
      fs, sStream: TFileStream;
      SplitFileName: String;
    begin
      ProgressBar.Position := 0;
      fs := TFileStream.Create(FileName, fmOpenRead or fmShareDenyWrite);
      try
        for i := 1 to Trunc(fs.Size / SizeofFiles) + 1 do
        begin
          SplitFileName := ChangeFileExt(FileName, '.'+ FormatFloat('000', i));
          sStream := TFileStream.Create(SplitFileName, fmCreate or fmShareExclusive);
          try
            if fs.Size - fs.Position < SizeofFiles then
              SizeofFiles := fs.Size - fs.Position;
            sStream.CopyFrom(fs, SizeofFiles);
            ProgressBar.Position := Round((fs.Position / fs.Size) * 100);
          finally
            sStream.Free;
          end;
        end;
      finally
        fs.Free;
      end;
     
    end;
     
    // Combine files / Dateien zusammenfuhren
     
    {
      Parameters:
     
      FileName: Specify the first piece of the splitted files
      CombinedFileName: Specify the combined file name. (the output file)
     
      Result:
      CombineFiles() will create one large file from the pieces
     }
     
    function CombineFiles(FileName, CombinedFileName : TFileName) : Boolean;
    var
      i: integer;
      fs, sStream: TFileStream;
      filenameOrg: String;
    begin
      i := 1;
      fs := TFileStream.Create(CombinedFileName, fmCreate or fmShareExclusive);
      try
        while FileExists(FileName) do
        begin
          sStream := TFileStream.Create(FileName, fmOpenRead or fmShareDenyWrite);
          try
            fs.CopyFrom(sStream, 0);
          finally
            sStream.Free;
          end;
          Inc(i);
          FileName := ChangeFileExt(FileName, '.'+ FormatFloat('000', i));
        end;
      finally
        fs.Free;
      end;
    end;

    // Examples:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SplitFile('C:\temp\FileToSplit.chm',1000000, ProgressBar1);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      CombineFiles('C:\temp\FileToSplit.001','H:\temp\FileToSplit.chm');
    end;

