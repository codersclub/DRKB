---
Title: Как прочитать/изменить свойства Word документа?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как прочитать/изменить свойства Word документа?
===============================================


    { 1. Change MS Word properties via OLE } 
     
    uses 
      ComObj; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    const 
      wdPropertyTitle = $00000001; 
      wdPropertySubject = $00000002; 
      wdPropertyAuthor = $00000003; 
      wdPropertyKeywords = $00000004; 
      wdPropertyComments = $00000005; 
      wdPropertyTemplate = $00000006; 
      wdPropertyLastAuthor = $00000007; 
      wdPropertyRevision = $00000008; 
      wdPropertyAppName = $00000009; 
      wdPropertyTimeLastPrinted = $0000000A; 
      wdPropertyTimeCreated = $0000000B; 
      wdPropertyTimeLastSaved = $0000000C; 
      wdPropertyVBATotalEdit = $0000000D; 
      wdPropertyPages = $0000000E; 
      wdPropertyWords = $0000000F; 
      wdPropertyCharacters = $00000010; 
      wdPropertySecurity = $00000011; 
      wdPropertyCategory = $00000012; 
      wdPropertyFormat = $00000013; 
      wdPropertyManager = $00000014; 
      wdPropertyCompany = $00000015; 
      wdPropertyBytes = $00000016; 
      wdPropertyLines = $00000017; 
      wdPropertyParas = $00000018; 
      wdPropertySlides = $00000019; 
      wdPropertyNotes = $0000001A; 
      wdPropertyHiddenSlides = $0000001B; 
      wdPropertyMMClips = $0000001C; 
      wdPropertyHyperlinkBase = $0000001D; 
      wdPropertyCharsWSpaces = $0000001E; 
    const 
      AWordDoc = 'C:\Test.doc'; 
      wdSaveChanges = $FFFFFFFF; 
    var 
      WordApp: OLEVariant; 
      SaveChanges: OleVariant; 
    begin 
      try 
        WordApp := CreateOleObject('Word.Application'); 
      except 
        // Error.... 
        Exit; 
      end; 
      try 
        WordApp.Visible := False; 
        WordApp.Documents.Open(AWordDoc); 
        WordApp.ActiveDocument.BuiltInDocumentProperties[wdPropertyTitle].Value := 'Your Title...'; 
        WordApp.ActiveDocument.BuiltInDocumentProperties[wdPropertySubject].Value := 'Your Subject...'; 
        // ... 
        // ... 
      finally 
        SaveChanges := wdSaveChanges; 
        WordApp.Quit(SaveChanges, EmptyParam, EmptyParam); 
      end; 
    end; 


    { 
      2. Read MS Word properties via Structured Storage. 
      by Serhiy Perevoznyk 
    } 
    uses 
      ComObj, ActiveX; 
     
    const 
      FmtID_SummaryInformation: TGUID = 
        '{F29F85E0-4FF9-1068-AB91-08002B27B3D9}'; 
     
    function FileTimeToDateTimeStr(F: TFileTime): string; 
    var 
      LocalFileTime: TFileTime; 
      SystemTime: TSystemTime; 
      DateTime: TDateTime; 
    begin 
      if Comp(F) = 0 then Result := '-' 
      else  
      begin 
        FileTimeToLocalFileTime(F, LocalFileTime); 
        FileTimeToSystemTime(LocalFileTime, SystemTime); 
        with SystemTime do 
          DateTime := EncodeDate(wYear, wMonth, wDay) + 
            EncodeTime(wHour, wMinute, wSecond, wMilliseconds); 
        Result := DateTimeToStr(DateTime); 
      end; 
    end; 
     
    function GetDocInfo(const FileName: WideString): string; 
    var 
      I: Integer; 
      PropSetStg: IPropertySetStorage; 
      PropSpec: array[2..19] of TPropSpec; 
      PropStg: IPropertyStorage; 
      PropVariant: array[2..19] of TPropVariant; 
      Rslt: HResult; 
      S: string; 
      Stg: IStorage; 
    begin 
      Result := ''; 
      try 
        OleCheck(StgOpenStorage(PWideChar(FileName), nil, STGM_READ or 
          STGM_SHARE_DENY_WRITE, 
          nil, 0, Stg)); 
        PropSetStg := Stg as IPropertySetStorage; 
        OleCheck(PropSetStg.Open(FmtID_SummaryInformation, 
          STGM_READ or STGM_SHARE_EXCLUSIVE, PropStg)); 
        for I := 2 to 19 do 
        begin 
          PropSpec[I].ulKind := PRSPEC_PROPID; 
          PropSpec[I].PropID := I; 
        end; 
        Rslt := PropStg.ReadMultiple(18, @PropSpec, @PropVariant); 
        OleCheck(Rslt); 
        if Rslt <> S_FALSE then for I := 2 to 19 do 
          begin 
            S := ''; 
            if PropVariant[I].vt = VT_LPSTR then 
              if Assigned(PropVariant[I].pszVal) then 
                S := PropVariant[I].pszVal; 
            case I of 
              2:  S  := Format('Title: %s', [S]); 
              3:  S  := Format('Subject: %s', [S]); 
              4:  S  := Format('Author: %s', [S]); 
              5:  S  := Format('Keywords: %s', [S]); 
              6:  S  := Format('Comments: %s', [S]); 
              7:  S  := Format('Template: %s', [S]); 
              8:  S  := Format('Last saved by: %s', [S]); 
              9:  S  := Format('Revision number: %s', [S]); 
              10: S := Format('Total editing time: %g sec', 
                  [Comp(PropVariant[I].filetime) / 1.0E9]); 
              11: S := Format('Last printed: %s', 
                  [FileTimeToDateTimeStr(PropVariant[I].filetime)]); 
              12: S := Format('Create time/date: %s', 
                  [FileTimeToDateTimeStr(PropVariant[I].filetime)]); 
              13: S := Format('Last saved time/date: %s', 
                  [FileTimeToDateTimeStr(PropVariant[I].filetime)]); 
              14: S := Format('Number of pages: %d', [PropVariant[I].lVal]); 
              15: S := Format('Number of words: %d', [PropVariant[I].lVal]); 
              16: S := Format('Number of characters: %d', 
                  [PropVariant[I].lVal]); 
              17:; // thumbnail 
              18: S := Format('Name of creating application: %s', [S]); 
              19: S := Format('Security: %.8x', [PropVariant[I].lVal]); 
            end; 
            if S <> '' then Result := Result + S + #13; 
          end; 
      finally 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if Opendialog1.Execute then 
        ShowMessage(GetDocInfo(opendialog1.FileName)); 
    end; 

