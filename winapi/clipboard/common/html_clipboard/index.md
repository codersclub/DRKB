---
Title: Скопировать HTML-код в буфер обмена
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Скопировать HTML-код в буфер обмена
===================================

    { 
      If you've ever tried sticking html into the clipboard using the usual CF_TEXT 
      format then you might have been disappointed to discover that wysiwyg html 
      editors paste your offering as if it were just text, 
      rather than recognising it as html. For that you need the CF_HTML format. 
      CF_HTML is entirely text format and uses the transformation format UTF-8. 
      It includes a description, a context, and within the context, the fragment. 
     
      As you may know one can place multiple items of data onto the clipboard for 
      a single clipboard entry, which means that the same data can be pasted in a 
      variety of different formats in order to cope with target 
      applications of varying sophistocation. 
     
      The following example shows how to stick CF_TEXT (and CF_HTML) 
      into the clipboard. 
    }
     
     
    function FormatHTMLClipboardHeader(HTMLText: string): string;
    const
      CrLf = #13#10;
    begin
      Result := 'Version:0.9' + CrLf;
      Result := Result + 'StartHTML:-1' + CrLf;
      Result := Result + 'EndHTML:-1' + CrLf;
      Result := Result + 'StartFragment:000081' + CrLf;
      Result := Result + 'EndFragment:°°°°°°' + CrLf;
      Result := Result + HTMLText + CrLf;
      Result := StringReplace(Result, '°°°°°°', Format('%.6d', [Length(Result)]), []);
    end;
     
    //The second parameter is optional and is put into the clipboard as CF_HTML. 
    //Function can be used standalone or in conjunction with the VCL clipboard so long as 
    //you use the USEVCLCLIPBOARD conditional define 
    //($define USEVCLCLIPBOARD} 
    //(and clipboard.open, clipboard.close). 
    //Code from http://www.lorriman.com 
    procedure CopyHTMLToClipBoard(const str: string; const htmlStr: string = '');
    var
      gMem: HGLOBAL;
      lp: PChar;
      Strings: array[0..1] of string;
      Formats: array[0..1] of UINT;
      i: Integer;
    begin
      gMem := 0;
      {$IFNDEF USEVCLCLIPBOARD}
      Win32Check(OpenClipBoard(0));
      {$ENDIF}
      try
        //most descriptive first as per api docs 
        Strings[0] := FormatHTMLClipboardHeader(htmlStr);
        Strings[1] := str;
        Formats[0] := RegisterClipboardFormat('HTML Format');
        Formats[1] := CF_TEXT;
        {$IFNDEF USEVCLCLIPBOARD}
        Win32Check(EmptyClipBoard);
        {$ENDIF}
        for i := 0 to High(Strings) do
        begin
          if Strings[i] = '' then Continue;
          //an extra "1" for the null terminator 
          gMem := GlobalAlloc(GMEM_DDESHARE + GMEM_MOVEABLE, Length(Strings[i]) + 1);
          {Succeeded, now read the stream contents into the memory the pointer points at}
          try
            Win32Check(gmem <> 0);
            lp := GlobalLock(gMem);
            Win32Check(lp <> nil);
            CopyMemory(lp, PChar(Strings[i]), Length(Strings[i]) + 1);
          finally
            GlobalUnlock(gMem);
          end;
          Win32Check(gmem <> 0);
          SetClipboardData(Formats[i], gMEm);
          Win32Check(gmem <> 0);
          gmem := 0;
        end;
      finally
        {$IFNDEF USEVCLCLIPBOARD}
        Win32Check(CloseClipBoard);
        {$ENDIF}
      end;
    end;
    
    // Example: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      CopyHTMLToClipBoard('SwissDelphiCenter', 'SwissDelphiCenter');
    end;

