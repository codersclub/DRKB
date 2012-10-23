<h1>CRC-32</h1>
<div class="date">01.01.2007</div>


<pre>

 
function CRC32(const IniCRC:Integer;Source:AnsiString):Integer;
asm
Push EBX
Push ESI
Push EDI
Or EDX,EDX
Jz @Done
Mov ESI,EDX
Mov ECX,[EDX-4]
Jecxz @Done
Lea EDI,@CRCTbl
Mov EDX,EAX
Xor EAX,EAX
Cld
@L1:
Lodsb
Mov EBX,EDX
Xor EBX,EAX
And EBX,$FF
Shl EBX,2
Shr EDX,8
And EDX,$FFFFFF
Xor EDX,[EDI+EBX]
Dec ECX
Jnz @L1
Mov EAX,EDX
@Done:
Pop EDI
Pop ESI
Pop EBX
Ret
@CRCTbl:
DD $00000000, $77073096, $ee0e612c, $990951ba
DD $076dc419, $706af48f, $e963a535, $9e6495a3
DD $0edb8832, $79dcb8a4, $e0d5e91e, $97d2d988
DD $09b64c2b, $7eb17cbd, $e7b82d07, $90bf1d91
DD $1db71064, $6ab020f2, $f3b97148, $84be41de
DD $1adad47d, $6ddde4eb, $f4d4b551, $83d385c7
DD $136c9856, $646ba8c0, $fd62f97a, $8a65c9ec
DD $14015c4f, $63066cd9, $fa0f3d63, $8d080df5
DD $3b6e20c8, $4c69105e, $d56041e4, $a2677172
DD $3c03e4d1, $4b04d447, $d20d85fd, $a50ab56b
DD $35b5a8fa, $42b2986c, $dbbbc9d6, $acbcf940
DD $32d86ce3, $45df5c75, $dcd60dcf, $abd13d59
DD $26d930ac, $51de003a, $c8d75180, $bfd06116
DD $21b4f4b5, $56b3c423, $cfba9599, $b8bda50f
DD $2802b89e, $5f058808, $c60cd9b2, $b10be924
DD $2f6f7c87, $58684c11, $c1611dab, $b6662d3d
DD $76dc4190, $01db7106, $98d220bc, $efd5102a
DD $71b18589, $06b6b51f, $9fbfe4a5, $e8b8d433
DD $7807c9a2, $0f00f934, $9609a88e, $e10e9818
DD $7f6a0dbb, $086d3d2d, $91646c97, $e6635c01
DD $6b6b51f4, $1c6c6162, $856530d8, $f262004e
DD $6c0695ed, $1b01a57b, $8208f4c1, $f50fc457
DD $65b0d9c6, $12b7e950, $8bbeb8ea, $fcb9887c
DD $62dd1ddf, $15da2d49, $8cd37cf3, $fbd44c65
DD $4db26158, $3ab551ce, $a3bc0074, $d4bb30e2
DD $4adfa541, $3dd895d7, $a4d1c46d, $d3d6f4fb
DD $4369e96a, $346ed9fc, $ad678846, $da60b8d0
DD $44042d73, $33031de5, $aa0a4c5f, $dd0d7cc9
DD $5005713c, $270241aa, $be0b1010, $c90c2086
DD $5768b525, $206f85b3, $b966d409, $ce61e49f
DD $5edef90e, $29d9c998, $b0d09822, $c7d7a8b4
DD $59b33d17, $2eb40d81, $b7bd5c3b, $c0ba6cad
DD $edb88320, $9abfb3b6, $03b6e20c, $74b1d29a
DD $ead54739, $9dd277af, $04db2615, $73dc1683
DD $e3630b12, $94643b84, $0d6d6a3e, $7a6a5aa8
DD $e40ecf0b, $9309ff9d, $0a00ae27, $7d079eb1
DD $f00f9344, $8708a3d2, $1e01f268, $6906c2fe
DD $f762575d, $806567cb, $196c3671, $6e6b06e7
DD $fed41b76, $89d32be0, $10da7a5a, $67dd4acc
DD $f9b9df6f, $8ebeeff9, $17b7be43, $60b08ed5
DD $d6d6a3e8, $a1d1937e, $38d8c2c4, $4fdff252
DD $d1bb67f1, $a6bc5767, $3fb506dd, $48b2364b
DD $d80d2bda, $af0a1b4c, $36034af6, $41047a60
DD $df60efc3, $a867df55, $316e8eef, $4669be79
DD $cb61b38c, $bc66831a, $256fd2a0, $5268e236
DD $cc0c7795, $bb0b4703, $220216b9, $5505262f
DD $c5ba3bbe, $b2bd0b28, $2bb45a92, $5cb36a04
DD $c2d7ffa7, $b5d0cf31, $2cd99e8b, $5bdeae1d
DD $9b64c2b0, $ec63f226, $756aa39c, $026d930a
DD $9c0906a9, $eb0e363f, $72076785, $05005713
DD $95bf4a82, $e2b87a14, $7bb12bae, $0cb61b38
DD $92d28e9b, $e5d5be0d, $7cdcefb7, $0bdbdf21
DD $86d3d2d4, $f1d4e242, $68ddb3f8, $1fda836e
DD $81be16cd, $f6b9265b, $6fb077e1, $18b74777
DD $88085ae6, $ff0f6a70, $66063bca, $11010b5c
DD $8f659eff, $f862ae69, $616bffd3, $166ccf45
DD $a00ae278, $d70dd2ee, $4e048354, $3903b3c2
DD $a7672661, $d06016f7, $4969474d, $3e6e77db
DD $aed16a4a, $d9d65adc, $40df0b66, $37d83bf0
DD $a9bcae53, $debb9ec5, $47b2cf7f, $30b5ffe9
DD $bdbdf21c, $cabac28a, $53b39330, $24b4a3a6
DD $bad03605, $cdd70693, $54de5729, $23d967bf
DD $b3667a2e, $c4614ab8, $5d681b02, $2a6f2b94
DD $b40bbe37, $c30c8ea1, $5a05df1b, $2d02ef8d
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Быстрый алгоритм подсчета CRC32
 
Использован BASM.
 
Зависимости: нет
Автор:       Александр Шарахов, alsha@mailru.com, Москва
Copyright:   Александр Шарахов
Дата:        18 января 2003 г.
***************************************************** }
 
unit CRCunit;
 
interface
function GetNewCRC(OldCRC: cardinal; StPtr: pointer; StLen: integer): cardinal;
procedure UpdateCRC(StPtr: pointer; StLen: integer; var CRC: cardinal);
function GetZipCRC(StPtr: pointer; StLen: integer): cardinal;
function GetFileCRC(const FileName: string): cardinal;
 
implementation
var
  CRCtable: array[0..255] of cardinal;
 
function GetNewCRC(OldCRC: cardinal; StPtr: pointer; StLen: integer): cardinal;
asm
  test edx,edx;
  jz @ret;
  neg ecx;
  jz @ret;
  sub edx,ecx; // Address after last element
 
  push ebx;
  mov ebx,0; // Set ebx=0 &amp; align @next
@next:
  mov bl,al;
  xor bl,byte [edx+ecx];
  shr eax,8;
  xor eax,cardinal [CRCtable+ebx*4];
  inc ecx;
  jnz @next;
  pop ebx;
 
@ret:
end;
 
procedure UpdateCRC(StPtr: pointer; StLen: integer; var CRC: cardinal);
begin
  CRC := GetNewCRC(CRC, StPtr, StLen);
end;
 
function GetZipCRC(StPtr: pointer; StLen: integer): cardinal;
begin
  Result := not GetNewCRC($FFFFFFFF, StPtr, StLen);
end;
 
function GetFileCRC(const FileName: string): cardinal;
const
  BufSize = 64 * 1024;
var
  Fi: file;
  pBuf: PChar;
  Count: integer;
begin
  Assign(Fi, FileName);
  Reset(Fi, 1);
  GetMem(pBuf, BufSize);
  Result := $FFFFFFFF;
  repeat
    BlockRead(Fi, pBuf^, BufSize, Count);
    if Count = 0 then
      break;
    Result := GetNewCRC(Result, pBuf, Count);
  until false;
  Result := not Result;
  FreeMem(pBuf);
  CloseFile(Fi);
end;
 
procedure CRCInit;
var
  c: cardinal;
  i, j: integer;
begin
  for i := 0 to 255 do
  begin
    c := i;
    for j := 1 to 8 do
      if odd(c) then
        c := (c shr 1) xor $EDB88320
      else
        c := (c shr 1);
    CRCtable[i] := c;
  end;
end;
 
initialization
  CRCinit;
end.
 
//Пример использования: 
 
uses
  CRCunit;
 
procedure TForm1.Button1Click(Sender: TObject);
const
  FileName = 'CRCunit.pas';
begin
  ShowMessage('CRC32 файла=' + IntToHex(GetFileCRC(FileName), 8));
  ShowMessage('CRC32 имени=' + IntToHex(GetZipCRC(PChar(FileName),
    Length(FileName)), 8));
end;
 
</pre>
<hr />
<p>Приведен модуль для Delphi 1.0 (для Delphi 2.0 должны быть сделаны небольшие изменения): </p>
<pre>
unit CRC32;
 
{CRC32 рассчитывает код циклической избыточности (cyclic redundancy code - CRC),
известный как CRC-32, с использованием алгоритма byte-wise ("мудрый байт").
 
(C) Авторские права 1989, 1995-1996 Earl F. Glynn, Overland Park, KS.
Все права защищены.
 
Данный модуль является производным от программы CRCT FORTRAN 77, опубликованной
в "Byte-wise CRC Calculations" за авторством Aram Perez из IEEE Micro, Июнь 1983,
страницы 40-50. Константы для полиномиального генератора CRC-32, приведенные
здесь, опубликованы в "Microsoft Systems Journal", Март 1995, страницы 107-108.
 
Данный CRC алгоритм имеет бОльшую скорость за счет 512 элементов таблицы
поиска.}
 
interface
 
procedure CalcCRC32(p: pointer; nbyte: WORD; var CRCvalue: LongInt);
procedure CalcFileCRC32(FromName: string; var CRCvalue: LongInt;
  var IOBuffer: pointer; BufferSize: WORD; var TotalBytes: LongInt;
  var error: WORD);
 
implementation
 
const
  table: array[0..255] of LongInt =
  ($00000000, $77073096, $EE0E612C, $990951BA,
    $076DC419, $706AF48F, $E963A535, $9E6495A3,
    $0EDB8832, $79DCB8A4, $E0D5E91E, $97D2D988,
    $09B64C2B, $7EB17CBD, $E7B82D07, $90BF1D91,
    $1DB71064, $6AB020F2, $F3B97148, $84BE41DE,
    $1ADAD47D, $6DDDE4EB, $F4D4B551, $83D385C7,
    $136C9856, $646BA8C0, $FD62F97A, $8A65C9EC,
    $14015C4F, $63066CD9, $FA0F3D63, $8D080DF5,
    $3B6E20C8, $4C69105E, $D56041E4, $A2677172,
    $3C03E4D1, $4B04D447, $D20D85FD, $A50AB56B,
    $35B5A8FA, $42B2986C, $DBBBC9D6, $ACBCF940,
    $32D86CE3, $45DF5C75, $DCD60DCF, $ABD13D59,
    $26D930AC, $51DE003A, $C8D75180, $BFD06116,
    $21B4F4B5, $56B3C423, $CFBA9599, $B8BDA50F,
    $2802B89E, $5F058808, $C60CD9B2, $B10BE924,
    $2F6F7C87, $58684C11, $C1611DAB, $B6662D3D,
 
    $76DC4190, $01DB7106, $98D220BC, $EFD5102A,
    $71B18589, $06B6B51F, $9FBFE4A5, $E8B8D433,
    $7807C9A2, $0F00F934, $9609A88E, $E10E9818,
    $7F6A0DBB, $086D3D2D, $91646C97, $E6635C01,
    $6B6B51F4, $1C6C6162, $856530D8, $F262004E,
    $6C0695ED, $1B01A57B, $8208F4C1, $F50FC457,
    $65B0D9C6, $12B7E950, $8BBEB8EA, $FCB9887C,
    $62DD1DDF, $15DA2D49, $8CD37CF3, $FBD44C65,
    $4DB26158, $3AB551CE, $A3BC0074, $D4BB30E2,
    $4ADFA541, $3DD895D7, $A4D1C46D, $D3D6F4FB,
    $4369E96A, $346ED9FC, $AD678846, $DA60B8D0,
    $44042D73, $33031DE5, $AA0A4C5F, $DD0D7CC9,
    $5005713C, $270241AA, $BE0B1010, $C90C2086,
    $5768B525, $206F85B3, $B966D409, $CE61E49F,
    $5EDEF90E, $29D9C998, $B0D09822, $C7D7A8B4,
    $59B33D17, $2EB40D81, $B7BD5C3B, $C0BA6CAD,
 
    $EDB88320, $9ABFB3B6, $03B6E20C, $74B1D29A,
    $EAD54739, $9DD277AF, $04DB2615, $73DC1683,
    $E3630B12, $94643B84, $0D6D6A3E, $7A6A5AA8,
    $E40ECF0B, $9309FF9D, $0A00AE27, $7D079EB1,
    $F00F9344, $8708A3D2, $1E01F268, $6906C2FE,
    $F762575D, $806567CB, $196C3671, $6E6B06E7,
    $FED41B76, $89D32BE0, $10DA7A5A, $67DD4ACC,
    $F9B9DF6F, $8EBEEFF9, $17B7BE43, $60B08ED5,
    $D6D6A3E8, $A1D1937E, $38D8C2C4, $4FDFF252,
    $D1BB67F1, $A6BC5767, $3FB506DD, $48B2364B,
    $D80D2BDA, $AF0A1B4C, $36034AF6, $41047A60,
    $DF60EFC3, $A867DF55, $316E8EEF, $4669BE79,
    $CB61B38C, $BC66831A, $256FD2A0, $5268E236,
    $CC0C7795, $BB0B4703, $220216B9, $5505262F,
    $C5BA3BBE, $B2BD0B28, $2BB45A92, $5CB36A04,
    $C2D7FFA7, $B5D0CF31, $2CD99E8B, $5BDEAE1D,
 
    $9B64C2B0, $EC63F226, $756AA39C, $026D930A,
    $9C0906A9, $EB0E363F, $72076785, $05005713,
    $95BF4A82, $E2B87A14, $7BB12BAE, $0CB61B38,
    $92D28E9B, $E5D5BE0D, $7CDCEFB7, $0BDBDF21,
    $86D3D2D4, $F1D4E242, $68DDB3F8, $1FDA836E,
    $81BE16CD, $F6B9265B, $6FB077E1, $18B74777,
    $88085AE6, $FF0F6A70, $66063BCA, $11010B5C,
    $8F659EFF, $F862AE69, $616BFFD3, $166CCF45,
    $A00AE278, $D70DD2EE, $4E048354, $3903B3C2,
    $A7672661, $D06016F7, $4969474D, $3E6E77DB,
    $AED16A4A, $D9D65ADC, $40DF0B66, $37D83BF0,
    $A9BCAE53, $DEBB9EC5, $47B2CF7F, $30B5FFE9,
    $BDBDF21C, $CABAC28A, $53B39330, $24B4A3A6,
    $BAD03605, $CDD70693, $54DE5729, $23D967BF,
    $B3667A2E, $C4614AB8, $5D681B02, $2A6F2B94,
    $B40BBE37, $C30C8EA1, $5A05DF1B, $2D02EF8D);
 
type
  buffer = array[1..65521] of BYTE; { самый большой буфер, который     }
  { только можно распределить в Куче }
var
  i: WORD;
  q: ^buffer;
 
procedure CalcCRC32(p: pointer; nbyte: WORD; var CRCvalue: LongInt);
{Ниже выполняется небольшое криптование (но выполняется очень быстро).
Алгоритм работает следующим образом:
1.  совершаем операцию "И/ИЛИ" (XOR) входного байта с младшей
частью регистра CRC для получения INDEX
2.  сдвигаем регистр CRC на восемь битов вправо
3.  совершаем операцию "И/ИЛИ" (XOR) с CRC регистром и
Table[INDEX]
4.  повторяем шаги с 1 по 3 для всех байтов }
begin
  q := p;
  for i := 1 to nBYTE do
    CRCvalue := (CRCvalue shr 8) xor
      Table[q^[i] xor (CRCvalue and $000000FF)]
end {CalcCRC32};
 
procedure CalcFileCRC32(FromName: string; var CRCvalue: LongInt;
  var IOBuffer: pointer; BufferSize: WORD; var TotalBytes: LongInt;
  var error: WORD);
var
  BytesRead: WORD;
  FromFile: file;
  i: WORD;
begin
  FileMode := 0; {Turbo по умолчанию 2 для R/W и 0 для R/O}
  CRCValue := $FFFFFFFF;
  ASSIGN(FromFile, FromName);
{$I-}RESET(FromFile, 1);
{$I+}
  error := IOResult;
  if error = 0 then
  begin
    TotalBytes := 0;
    repeat
      BlockRead(FromFile, IOBuffer^, BufferSize, BytesRead);
      CalcCRC32(IOBuffer, BytesRead, CRCvalue);
      INC(TotalBytes, BytesRead)
    until BytesRead = 0;
    CLOSE(FromFile)
  end;
  CRCvalue := not CRCvalue
end {CalcFileCRC32};
 
end {CRC}.
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
