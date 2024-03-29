---
Title: Как получить RTF из Word без буффера обмена?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как получить RTF из Word без буффера обмена?
============================================


    uses
      Word_TLB, ActiveX, ComObj;
     
    function GetRTFFormat(DataObject: IDataObject; var RTFFormat: TFormatEtc): Boolean;
    var
      Formats: IEnumFORMATETC;
      TempFormat: TFormatEtc;
      pFormatName: PChar;
      Found: Boolean;
    begin
      try
        OleCheck(DataObject.EnumFormatEtc(DATADIR_GET, Formats));
        Found := False;
        while (not Found) and (Formats.Next(1, TempFormat, nil) = S_OK) do
        begin
          pFormatName := AllocMem(255);
          GetClipBoardFormatName(TempFormat.cfFormat, pFormatName, 254);
          if (string(pFormatName) = 'Rich Text Format') then
          begin
            RTFFormat := TempFormat;
            Found := True;
          end;
          FreeMem(pFormatName);
        end;
        Result := Found;
      except
        Result := False;
      end;
    end;
     
    function GetRTF: string;
    var
      DataObject: IDataObject;
      RTFFormat: TFormatEtc;
      ReturnData: TStgMedium;
      Buffer: PChar;
      WordDoc: _Document;
      WordApp: _Application;
    begin
      Result := '';
      try
        GetActiveOleObject('Word.Application').QueryInterface(_Application, WordApp);
      except
        ShowMessage('Error: MSWord is not running');
        Exit;
      end;
      if (WordApp <> nil) then
        try
          WordDoc := WordApp.ActiveDocument;
          WordDoc.QueryInterface(IDataObject, DataObject);
          if GetRTFFormat(DataObject, RTFFormat) then
          begin
            OleCheck(DataObject.GetData(RTFFormat, ReturnData));
            //RTF is passed through global memory
            Buffer := GlobalLock(ReturnData.hglobal);
            //Buffer is a pointer to the RTF text
            Result := StrPas(Buffer);
            GlobalUnlock(ReturnData.hglobal);
            ReleaseStgMedium(ReturnData);
          end;
        except
          // Error occured...
        end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      ss: TStringstream;
      rtfText: string;
    begin
      rtfText := GetRTF;
      ss := TStringStream.Create(rtfText);
      try
        ss.Position := 0;
        Memo1.Text := rtfText;
        RichEdit1.Lines.LoadFromStream(ss);
      finally
        ss.Free
      end;
    end;

