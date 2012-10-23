<h1>Произвести поиск байта или слова в строке</h1>
<div class="date">01.01.2007</div>

<p>У семейства x86 есть группа специализированных строковых инструкций, одна из которых - scasb/scasw - производит поиск байта/слова в строке. Использовать преимущества этой инструкции в Delphi позволяют длинные строки, которых в старых паскалях не было.</p>
<p>Никаких сложностей с пониманием, на мой взгляд, быть не должно. Единственное это смена режима открытия файла (FileMode := 0), которая позволит открыть файлы заблокированные ядром Windows и сдвиг указателя файла при чтении нового блока влево на длину искомой строки. Сдвиг делается на случай разрезания искомой строки на части при чтении файла. Полный текст проверенной программы:</p>
<pre>
program search;
{$APPTYPE CONSOLE}
uses  SysUtils;
const buffSize  = 16384;
var F           : File;
var buff        : AnsiString;
var oldFileMode : integer;
var SearchString: shortString='SunSB';
var SearchPos   : integer = -1;
var readed      : integer;
var blockStart: integer;
begin
   SetLength( buff, buffSize);
   assignFile( F, 'Speedometer2.exe');
   oldFileMode := FileMode;
   FileMode := 0;
   reset( F,1);
   while not eof( F ) do begin
      blockStart := filePos( F );
      blockRead( F, buff[1], buffSize, readed);
      SearchPos:=Pos( SearchString, buff );
      if SearchPos &gt;  0 then begin
         WriteLn( 'Substr found at pos ',
                        blockStart+SearchPos );
         break;
      end;
      if readed=buffSize then
         seek( F, ( filePos( F ) -
                    length( SearchString )));
   end;
   closeFile( F );
   FileMode := oldFileMode;
   SetLength( buff, 0 );
   if SearchPos = 0 then
      WriteLn( 'Substr not found.');
   readLn;
end.
 
 
</pre>
<p><a href="https://sunsb.dax.ru" target="_blank">https://sunsb.dax.ru</a></p>

