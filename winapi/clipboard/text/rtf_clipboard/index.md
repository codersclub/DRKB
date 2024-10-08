---
Title: Копировать RTF-текст в буфер обмена
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Копировать RTF-текст в буфер обмена
===================================

    { 
    You have to dig into the Rich Text Format if you want to copy text to the 
    clipboard that has format information embedded. The application you paste 
    this text into has to understand RTF, or the formatting will not show up. 
     
    OK, the first step is to register a clipboard format for RTF, since this is 
    not a predefined format: 
    }
     
    Var
      CF_RTF : Word;
    
      CF_RTF := RegisterClipboardFormat('Rich Text Format');
    
    { 
    The format name has to appear as typed above, this is the name used by MS 
    Word for Windows and similar MS products. 
     
    NOTE: The Richedit Unit declares a constant CF_RTF, which is NOT the 
    clipboard format handle but the string you need to pass to RegisterClipboard 
    format! So you can place Richedit into your uses clause and change the line 
    above to 
    }
     
      CF_RTF := RegisterClipboardFormat(Richedit.CF_RTF);
    
    { 
    The next step is to build a RTF string with the embedded format information. 
    You will get a shock if you inspect the mess of RTF stuff W4W will put into 
    the clipboard if you copy just a few characters (the app below allows you to 
    inspect the clipboard), but you can get away with a lot less. The bare 
    minimum would be something like this (inserts an underlined 44444): 
    }
     
    const
      testtext: PChar = '{\rtf1\ansi\pard\plain 12{\ul 44444}}';
    
    { 
    The correct balance of opening and closing braces is extremely important, one 
    mismatch and the target app will not be able to interpret the text 
    correctly. If you want to control the font used for the pasted text you need 
    to add a fonttable (the default font is Tms Rmn, not the active font in the 
    target app!). See example app below, testtext2. If you want more info, the 
    full RTF specs can be found on www.microsoft.com, a subset is also described 
    in the Windows help compiler docs (hcw.hlp, comes with Delphi). 
    }
     
     
    unit Clipfmt1;
    
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
    
    type
      TForm1 = class(TForm)
        MemFormats: TMemo;
        label1: TLabel;
        BtnShowFormats: TButton;
        BtnGetRTF: TButton;
        BtnSetRTF: TButton;
        MemExample: TMemo;
        procedure FormCreate(Sender: TObject);
        procedure BtnShowFormatsClick(Sender: TObject);
        procedure BtnGetRTFClick(Sender: TObject);
        procedure BtnSetRTFClick(Sender: TObject);
      private
      public
        CF_RTF: Word;
      end;
    
    var
      Form1: TForm1;
    
    implementation
    
    uses Clipbrd;
    
    {$R *.DFM}
    
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // register clipboard format rtf 
      CF_RTF := RegisterClipboardFormat('Rich Text Format');
      if CF_RTF = 0 then
      begin
        ShowMessage('Unable to register the Rich Text clipboard format!');
        Application.Terminate;
      end;
      BtnShowFormats.Click;
    end;
    
    // show clipboard formats 
    procedure TForm1.BtnShowFormatsClick(Sender: TObject);
    var
      buf: array [0..60] of Char;
      n: Integer;
      fmt: Word;
      Name: string[30];
    begin
      MemFormats.Clear;
      for n := 0 to Clipboard.FormatCount - 1 do
      begin
        fmt := Clipboard.Formats[n];
        if GetClipboardFormatName(fmt, buf, Pred(SizeOf(buf))) <> 0 then
          MemFormats.Lines.Add(StrPas(buf))
        else
        begin
          case fmt of
            1: Name := 'CF_TEXT';
            2: Name := 'CF_BITMAP';
            3: Name := 'CF_METAFILEPICT';
            4: Name := 'CF_SYLK';
            5: Name := 'CF_DIF';
            6: Name := 'CF_TIFF';
            7: Name := 'CF_OEMTEXT';
            8: Name := 'CF_DIB';
            9: Name := 'CF_PALETTE';
            10: Name := 'CF_PENDATA';
            11: Name := 'CF_RIFF';
            12: Name := 'CF_WAVE';
            13: Name := 'CF_UNICODETEXT';
            14: Name := 'CF_ENHMETAFILE';
            15: Name := 'CF_HDROP (Win 95)';
            16: Name := 'CF_LOCALE (Win 95)';
            17: Name := 'CF_MAX (Win 95)';
            $0080: Name := 'CF_OWNERDISPLAY';
            $0081: Name := 'CF_DSPTEXT';
            $0082: Name := 'CF_DSPBITMAP';
            $0083: Name := 'CF_DSPMETAFILEPICT';
            $008E: Name := 'CF_DSPENHMETAFILE';
            $0200..$02FF: Name := 'private format';
            $0300..$03FF: Name := 'GDI object';
            else
              Name := 'unknown format';
          end;
          MemFormats.Lines.Add(Name);
        end;
      end;
    end;
    
    // get rtf code from clipboard 
    procedure TForm1.BtnGetRTFClick(Sender: TObject);
    var
      MemHandle: THandle;
    begin
      with Clipboard do
      begin
        Open;
        try
          if HasFormat(CF_RTF) then
          begin
            MemHandle := GetAsHandle(CF_RTF);
            MemExample.SetTextBuf(GlobalLock(MemHandle));
            GlobalUnlock(MemHandle);
          end
          else
            MessageDlg('The clipboard contains no RTF text!',
              mtError, [mbOK], 0);
        finally
          Close;
        end;
      end;
    end;
    
    // set rtf code to the clipboard 
    procedure TForm1.BtnSetRTFClick(Sender: TObject);
    const
      testtext: PChar = '{\rtf1\ansi\pard\plain 12{\ul 44444}}';
      testtext2: PChar = '{\rtf1\ansi' +
        '\deff4\deflang1033{\fonttbl{\f4\froman\fcharset0\fprq2 Times New Roman;}}' +
        '\pard\plain 12{\ul 44444}}';
      flap: Boolean = False;
    var
      MemHandle: THandle;
      rtfstring: PChar;
    begin
      with Clipboard do
      begin
        if flap then
          rtfstring := testtext2
        else
          rtfstring := testtext;
        flap := not flap;
        MemHandle := GlobalAlloc(GHND or GMEM_SHARE, StrLen(rtfstring) + 1);
        if MemHandle <> 0 then
        begin
          StrCopy(GlobalLock(MemHandle), rtfstring);
          GlobalUnlock(MemHandle);
          Open;
          try
            AsText := '1244444';
            SetAsHandle(CF_RTF, MemHandle);
          finally
            Close;
          end;
        end
        else
          MessageDlg('Global Alloc failed!',
            mtError, [mbOK], 0);
      end;
    end;
    
    end.

