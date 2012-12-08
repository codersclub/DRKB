---
Title: Как вставить RTF в Word?
Date: 01.01.2007
---


Как вставить RTF в Word?
========================

::: {.date}
01.01.2007
:::

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
     
    procedure WriteToMSWord(const RTFText: String);
    var
      WordDoc: _Document;
      WordApp: _Application;
      DataObj : IDataObject;
      Formats : IEnumFormatEtc;
      RTFFormat: TFormatEtc;
      Medium : TStgMedium;
      pGlobal : Pointer;
    begin
        try
          GetActiveOleObject('Word.Application').QueryInterface(_Application, WordApp);
        except
          WordApp := CoWordApplication.Create;
        end;
        WordApp.Documents.Add(EmptyParam, EmptyParam, EmptyParam, EmptyParam);
        WordApp.Visible := True;
        WordDoc := WordApp.ActiveDocument;
        OleCheck(WordDoc.QueryInterface(IDataObject,DataObj));
        GetRTFFormat(DataObj, RTFFormat);
        FillChar(Medium,SizeOf(Medium),0);
        Medium.tymed := RTFFormat.tymed;
        Medium.hGlobal := GlobalAlloc(GMEM_MOVEABLE, Length(RTFText)+1);
        try
         pGlobal := GlobalLock(Medium.hGlobal);
         CopyMemory(PGlobal,PChar(RTFText),Length(RTFText)+1);
         GlobalUnlock(Medium.hGlobal);
         OleCheck(DataOBJ.SetData(RTFFormat,Medium,True));
        finally
          GlobalFree(Medium.hGlobal);
          ReleaseStgMedium(Medium);
        end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      WriteToMSWord(Memo1.Text); // may be rtf-formatted text
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
