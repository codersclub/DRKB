---
Title: Как конвертировать кодовую страницу?
Author: Daniel Wischnewski
Date: 12.12.2002
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Как конвертировать кодовую страницу?
====================================

All Systems (Win 95+ and WinNT4+) with MS Internet Explorer 4 and newer
have a library named mlang.dll in the Winnt\\System32 directory. Usually
you can tell Delphi to simply import these COM Libraries. This one
however, Delphi did not. I started to convert the "most wanted"
interface for myself. The results I present you here.

First I give you the code for the conversion unit, that allows you
simply convert any text from code page interpretation into another one.
Following I will shortly discuss the code and give you a sample of how
to use it.

**uCodePageConverter**

    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    *
    * Unit Name : uCodePageConverter
    * Autor     : Daniel Wischnewski
    * Copyright : Copyright © 2002 by gate(n)etwork. All Right Reserved.
    * Urheber   : Daniel Wischnewski
    *
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *}
     
    unit uCodePageConverter;
     
    interface
     
    uses
      Windows;
     
    const
      IID_MLangConvertCharset: TGUID = '{D66D6F98-CDAA-11D0-B822-00C04FC9B31F}';
      CLASS_MLangConvertCharset: TGUID = '{D66D6F99-CDAA-11D0-B822-00C04FC9B31F}';
     
    type
      tagMLCONVCHARF = DWORD;
     
    const
      MLCONVCHARF_AUTODETECT: tagMLCONVCHARF = 1;
      MLCONVCHARF_ENTITIZE: tagMLCONVCHARF = 2;
     
    type
      tagCODEPAGE = UINT;
     
    const
      CODEPAGE_Thai: tagCODEPAGE = 0874;
      CODEPAGE_Japanese: tagCODEPAGE = 0932;
      CODEPAGE_Chinese_PRC: tagCODEPAGE = 0936;
      CODEPAGE_Korean: tagCODEPAGE = 0949;
      CODEPAGE_Chinese_Taiwan: tagCODEPAGE = 0950;
      CODEPAGE_UniCode: tagCODEPAGE = 1200;
      CODEPAGE_Windows_31_EastEurope: tagCODEPAGE = 1250;
      CODEPAGE_Windows_31_Cyrillic: tagCODEPAGE = 1251;
      CODEPAGE_Windows_31_Latin1: tagCODEPAGE = 1252;
      CODEPAGE_Windows_31_Greek: tagCODEPAGE = 1253;
      CODEPAGE_Windows_31_Turkish: tagCODEPAGE = 1254;
      CODEPAGE_Hebrew: tagCODEPAGE = 1255;
      CODEPAGE_Arabic: tagCODEPAGE = 1256;
      CODEPAGE_Baltic: tagCODEPAGE = 1257;
     
    type
      IMLangConvertCharset = interface
        ['{D66D6F98-CDAA-11D0-B822-00C04FC9B31F}']
        function Initialize(
          uiSrcCodePage: tagCODEPAGE; uiDstCodePage: tagCODEPAGE;
          dwProperty: tagMLCONVCHARF
          ): HResult; stdcall;
        function GetSourceCodePage(
          out puiSrcCodePage: tagCODEPAGE
          ): HResult; stdcall;
        function GetDestinationCodePage(
          out puiDstCodePage: tagCODEPAGE
          ): HResult; stdcall;
        function GetProperty(out pdwProperty: tagMLCONVCHARF): HResult; stdcall;
        function DoConversion(
          pSrcStr: PChar; pcSrcSize: PUINT; pDstStr: PChar; pcDstSize: PUINT
          ): HResult; stdcall;
        function DoConversionToUnicode(
          pSrcStr: PChar; pcSrcSize: PUINT; pDstStr: PWChar; pcDstSize: PUINT
          ): HResult; stdcall;
        function DoConversionFromUnicode(
          pSrcStr: PWChar; pcSrcSize: PUINT; pDstStr: PChar; pcDstSize: PUINT
          ): HResult; stdcall;
      end;
     
      CoMLangConvertCharset = class
        class function Create: IMLangConvertCharset;
        class function CreateRemote(const MachineName: string): IMLangConvertCharset;
      end;
     
    implementation
     
    uses
      ComObj;
     
    { CoMLangConvertCharset }
     
    class function CoMLangConvertCharset.Create: IMLangConvertCharset;
    begin
      Result := CreateComObject(CLASS_MLangConvertCharset) as IMLangConvertCharset;
    end;
     
    class function CoMLangConvertCharset.CreateRemote(
      const MachineName: string
      ): IMLangConvertCharset;
    begin
      Result := CreateRemoteComObject(
        MachineName, CLASS_MLangConvertCharset
        ) as IMLangConvertCharset;
    end;
     
    end.
     

As you can see, I did translate only one of the many interfaces, however
this one is the most efficient (according to Microsoft) and will do the
job. Further I added some constants to simplify the task of finding the
most important values.

When using this unit to do any code page conersions you must not forget,
that the both code pages (source and destination) must be installed and
supported on the computer that does the translation. OIn the computer
that is going to show the result only the destination code page must be
installed and supported.

To test the unit simple create a form with a memo and a button. Add the
following code to the buttons OnClick event. (Do not forget to add the
conversion unit to the uses clause!)

**SAMPLE**

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Conv: IMLangConvertCharset;
      Source: PWChar;
      Dest: PChar;
      SourceSize, DestSize: UINT;
    begin
      // connect to MS multi-language lib
      Conv := CoMLangConvertCharset.Create;
      // initialize UniCode Translation to Japanese
      Conv.Initialize(CODEPAGE_UniCode, CODEPAGE_Japanese, MLCONVCHARF_ENTITIZE);
      // load source (from memo)
      Source := PWChar(WideString(Memo1.Text));
      SourceSize := Succ(Length(Memo1.Text));
      // prepare destination
      DestSize := 0;
      // lets calculate size needed
      Conv.DoConversionFromUnicode(Source, @SourceSize, nil, @DestSize);
      // reserve memory
      GetMem(Dest, DestSize);
      try
        // convert
        Conv.DoConversionFromUnicode(Source, @SourceSize, Dest, @DestSize);
        // show
        Memo1.Text := Dest;
      finally
        // free memory
        FreeMem(Dest);
      end;
    end;

