---
Title: Как сохранить все картинки TWebBrowser?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как сохранить все картинки TWebBrowser?
=======================================

    uses
      UrlMon;
     
    function DownloadFile(SourceFile, DestFile: string): Boolean;
    begin
      try
        Result := UrlDownloadToFile(nil, PChar(SourceFile), PChar(DestFile), 0,
          nil) = 0;
      except
        Result := False;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      k, p: Integer;
      Source, dest, ext: string;
    begin
      for k := 0 to WebBrowser1.OleObject.Document.Images.Length - 1 do
      begin
        Source := WebBrowser1.OleObject.Document.Images.Item(k).Src;
        p := LastDelimiter('.', Source);
        ext := UpperCase(Copy(Source, p + 1, Length(Source)));
        if (ext = 'GIF') or (ext = 'JPG') then
        begin
          p  := LastDelimiter('/', Source);
          dest := ExtractFilePath(ParamStr(0)) + Copy(Source, p + 1,
            Length(Source));
          DownloadFile(Source, dest);
        end;
      end;
    end;

