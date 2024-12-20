---
Title: Как изменить кодовую страницу шрифта принтера?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Как изменить кодовую страницу шрифта принтера?
==============================================

    uses Sysutils, Printers;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Dosya: TextFile
    begin
      with Printer do
      begin
        AssignPrn(Dosya);
        Rewrite(Dosya);
        Printer.Canvas.Font.Name := 'Courier New';
        Printer.Canvas.Font.Style := [fsBold];
        Printer.Canvas.Font.Size := 18;
     
        //****for Turkish special characters
        Writeln(Dosya, '?ьi??ц?');
     
        //****set Font CharSet to Turkish(162)
        Printer.Canvas.Font.Charset := 162;
        Writeln(Dosya, '?ьi??ц?');
     
        CloseFile(Dosya);
      end;
    end;

The following table lists the predefined constants provided for standard character sets: 

    type
      TFontCharset = 0..255;
     

Constant		|Value	|Description
------------------------|-------|-----
ANSI\_CHARSET		|0	|ANSI characters.
DEFAULT\_CHARSET	|1	|Font is chosen based solely on Name and Size. If the described font is not available on the system, Windows will substitute another font.
SYMBOL\_CHARSET		|2	|Standard symbol set.
MAC\_CHARSET		|77	|Macintosh characters. Not available on NT 3.51.
SHIFTJIS\_CHARSET	|128	|Japanese shift-jis characters.
HANGEUL\_CHARSET	|129	|Korean characters (Wansung).
JOHAB\_CHARSET		|130	|Korean characters (Johab). Not available on NT 3.51
GB2312\_CHARSET		|134	|Simplified Chinese characters (mainland china).
CHINESEBIG5\_CHARSET	|136	|Traditional Chinese characters (taiwanese).
GREEK\_CHARSET		|161	|Greek characters. Not available on NT 3.51.
TURKISH\_CHARSET	|162	|Turkish characters. Not available on NT 3.51
VIETNAMESE\_CHARSET	|163	|Vietnamese characters. Not available on NT 3.51.
HEBREW\_CHARSET		|177	|Hebrew characters. Not available on NT 3.51
ARABIC\_CHARSET		|178	|Arabic characters. Not available on NT 3.51
BALTIC\_CHARSET		|186	|Baltic characters. Not available on NT 3.51.
RUSSIAN\_CHARSET	|204	|Cyrillic characters. Not available on NT 3.51.
THAI\_CHARSET		|222	|Thai characters. Not available on NT 3.51
EASTEUROPE\_CHARSET	|238	|Includes diacritical marks for eastern european countries. Not available on NT 3.51.
OEM\_CHARSET		|255	|Depends on the codepage of the operating system.

