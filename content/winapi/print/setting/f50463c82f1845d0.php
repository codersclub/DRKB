<h1>Как изменить кодовую страницу шрифта принтера?</h1>
<div class="date">01.01.2007</div>


<pre>
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
 
</pre>

<p>Constant Value Description </p>

<p>ANSI_CHARSET 0 ANSI characters. </p>
<p>DEFAULT_CHARSET 1 Font is chosen based solely on Name and Size. If the described font is not available on the system, Windows will substitute another font. </p>
<p>SYMBOL_CHARSET 2 Standard symbol set. </p>
<p>MAC_CHARSET 77 Macintosh characters. Not available on NT 3.51. </p>
<p>SHIFTJIS_CHARSET 128 Japanese shift-jis characters. </p>
<p>HANGEUL_CHARSET 129 Korean characters (Wansung). </p>
<p>JOHAB_CHARSET 130 Korean characters (Johab). Not available on NT 3.51 </p>
<p>GB2312_CHARSET 134 Simplified Chinese characters (mainland china). </p>
<p>CHINESEBIG5_CHARSET 136 Traditional Chinese characters (taiwanese). </p>
<p>GREEK_CHARSET 161 Greek characters. Not available on NT 3.51. </p>
<p>TURKISH_CHARSET 162 Turkish characters. Not available on NT 3.51 </p>
<p>VIETNAMESE_CHARSET 163 Vietnamese characters. Not available on NT 3.51. </p>
<p>HEBREW_CHARSET 177 Hebrew characters. Not available on NT 3.51 </p>
<p>ARABIC_CHARSET 178 Arabic characters. Not available on NT 3.51 </p>
<p>BALTIC_CHARSET 186 Baltic characters. Not available on NT 3.51. </p>
<p>RUSSIAN_CHARSET 204 Cyrillic characters. Not available on NT 3.51. </p>
<p>THAI_CHARSET 222 Thai characters. Not available on NT 3.51 </p>
<p>EASTEUROPE_CHARSET 238 Includes diacritical marks for eastern european countries. Not available on NT 3.51. </p>
<p>OEM_CHARSET 255 Depends on the codepage of the operating system. </p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
