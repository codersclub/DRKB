---
Title: Save all TWebBrowser frame sources
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Save all TWebBrowser frame sources
==================================

    uses
      ActiveX;
     
    function TForm1.GetFrame(FrameNo: Integer): IWebbrowser2;
    var
      OleContainer: IOleContainer;
      enum: IEnumUnknown;
      unk: IUnknown;
      Fetched: PLongint;
    begin
      while Webbrowser1.ReadyState <> READYSTATE_COMPLETE do
        Application.ProcessMessages;
      if Assigned(Webbrowser1.document) then
      begin
        Fetched := nil;
        OleContainer := Webbrowser1.Document as IOleContainer;
        OleContainer.EnumObjects(OLECONTF_EMBEDDINGS, Enum);
        Enum.Skip(FrameNo);
        Enum.Next(1, Unk, Fetched);
        Result := Unk as IWebbrowser2;
      end
      else
        Result := nil;
    end;
     
    // Load sample page
    // Testseite laden
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Webbrowser1.Navigate('http://www.warebizprogramming.com/tutorials/html/framesEx1.htm');
    end;
     
    // Save all frames in single files
    // Alle Frameseiten in einzelne Dateien speichern
    procedure TForm1.Button2Click(Sender: TObject);
    var
      IpStream: IPersistStreamInit;
      AStream: TMemoryStream;
      iw: IWebbrowser2;
      i: Integer;
      sl: TStringList;
    begin
      for i := 0 to Webbrowser1.OleObject.Document.frames.Length - 1 do
      begin
        iw := GetFrame(i);
        AStream := TMemoryStream.Create;
        try
          IpStream := iw.document as IPersistStreamInit;
          if Succeeded(IpStream.save(TStreamadapter.Create(AStream), True)) then
          begin
            AStream.Seek(0, 0);
            sl := TStringList.Create;
            sl.LoadFromStream(AStream);
            sl.SaveToFile('c:\frame' + IntToStr(i) + '.txt');
            //  memo1.Lines.LoadFromStream(AStream);
            sl.Free;
          end;
        except
        end;
        AStream.Free;
      end;
    end;
     
    end.

