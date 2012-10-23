<h1>Алгоритм хэширования MD5</h1>
<div class="date">01.01.2007</div>


<pre>
Function md5(s:string):string; 
 

 
 var a:array[0..15] of byte; 
     i:integer; 
 
  LenHi, LenLo: longword; 
  Index: DWord; 
  HashBuffer: array[0..63] of byte; 
  CurrentHash: array[0..3] of DWord; 
 
  procedure Burn; 
  begin 
    LenHi:= 0; LenLo:= 0; 
    Index:= 0; 
    FillChar(HashBuffer,Sizeof(HashBuffer),0); 
    FillChar(CurrentHash,Sizeof(CurrentHash),0); 
  end; 
 
 procedure Init; 
 begin 
   Burn; 
   CurrentHash[0]:= $67452301; 
   CurrentHash[1]:= $efcdab89; 
   CurrentHash[2]:= $98badcfe; 
   CurrentHash[3]:= $10325476; 
 end; 
 
 function LRot32(a, b: longword): longword; 
 begin 
   Result:= (a shl b) or (a shr (32-b)); 
 end; 
 
 procedure Compress; 
 var 
   Data: array[0..15] of dword; 
   A, B, C, D: dword; 
 begin 
   Move(HashBuffer,Data,Sizeof(Data)); 
   A:= CurrentHash[0]; 
   B:= CurrentHash[1]; 
   C:= CurrentHash[2]; 
   D:= CurrentHash[3]; 
 
   A:= B + LRot32(A + (D xor (B and (C xor D))) + Data[ 0] + $d76aa478,7); 
   D:= A + LRot32(D + (C xor (A and (B xor C))) + Data[ 1] + $e8c7b756,12); 
   C:= D + LRot32(C + (B xor (D and (A xor B))) + Data[ 2] + $242070db,17); 
   B:= C + LRot32(B + (A xor (C and (D xor A))) + Data[ 3] + $c1bdceee,22); 
   A:= B + LRot32(A + (D xor (B and (C xor D))) + Data[ 4] + $f57c0faf,7); 
   D:= A + LRot32(D + (C xor (A and (B xor C))) + Data[ 5] + $4787c62a,12); 
   C:= D + LRot32(C + (B xor (D and (A xor B))) + Data[ 6] + $a8304613,17); 
   B:= C + LRot32(B + (A xor (C and (D xor A))) + Data[ 7] + $fd469501,22); 
   A:= B + LRot32(A + (D xor (B and (C xor D))) + Data[ 8] + $698098d8,7); 
   D:= A + LRot32(D + (C xor (A and (B xor C))) + Data[ 9] + $8b44f7af,12); 
   C:= D + LRot32(C + (B xor (D and (A xor B))) + Data[10] + $ffff5bb1,17); 
   B:= C + LRot32(B + (A xor (C and (D xor A))) + Data[11] + $895cd7be,22); 
   A:= B + LRot32(A + (D xor (B and (C xor D))) + Data[12] + $6b901122,7); 
   D:= A + LRot32(D + (C xor (A and (B xor C))) + Data[13] + $fd987193,12); 
   C:= D + LRot32(C + (B xor (D and (A xor B))) + Data[14] + $a679438e,17); 
   B:= C + LRot32(B + (A xor (C and (D xor A))) + Data[15] + $49b40821,22); 
 
   A:= B + LRot32(A + (C xor (D and (B xor C))) + Data[ 1] + $f61e2562,5); 
   D:= A + LRot32(D + (B xor (C and (A xor B))) + Data[ 6] + $c040b340,9); 
   C:= D + LRot32(C + (A xor (B and (D xor A))) + Data[11] + $265e5a51,14); 
   B:= C + LRot32(B + (D xor (A and (C xor D))) + Data[ 0] + $e9b6c7aa,20); 
   A:= B + LRot32(A + (C xor (D and (B xor C))) + Data[ 5] + $d62f105d,5); 
   D:= A + LRot32(D + (B xor (C and (A xor B))) + Data[10] + $02441453,9); 
   C:= D + LRot32(C + (A xor (B and (D xor A))) + Data[15] + $d8a1e681,14); 
   B:= C + LRot32(B + (D xor (A and (C xor D))) + Data[ 4] + $e7d3fbc8,20); 
   A:= B + LRot32(A + (C xor (D and (B xor C))) + Data[ 9] + $21e1cde6,5); 
   D:= A + LRot32(D + (B xor (C and (A xor B))) + Data[14] + $c33707d6,9); 
   C:= D + LRot32(C + (A xor (B and (D xor A))) + Data[ 3] + $f4d50d87,14); 
   B:= C + LRot32(B + (D xor (A and (C xor D))) + Data[ 8] + $455a14ed,20); 
   A:= B + LRot32(A + (C xor (D and (B xor C))) + Data[13] + $a9e3e905,5); 
   D:= A + LRot32(D + (B xor (C and (A xor B))) + Data[ 2] + $fcefa3f8,9); 
   C:= D + LRot32(C + (A xor (B and (D xor A))) + Data[ 7] + $676f02d9,14); 
   B:= C + LRot32(B + (D xor (A and (C xor D))) + Data[12] + $8d2a4c8a,20); 
 
   A:= B + LRot32(A + (B xor C xor D) + Data[ 5] + $fffa3942,4); 
   D:= A + LRot32(D + (A xor B xor C) + Data[ 8] + $8771f681,11); 
   C:= D + LRot32(C + (D xor A xor B) + Data[11] + $6d9d6122,16); 
   B:= C + LRot32(B + (C xor D xor A) + Data[14] + $fde5380c,23); 
   A:= B + LRot32(A + (B xor C xor D) + Data[ 1] + $a4beea44,4); 
   D:= A + LRot32(D + (A xor B xor C) + Data[ 4] + $4bdecfa9,11); 
   C:= D + LRot32(C + (D xor A xor B) + Data[ 7] + $f6bb4b60,16); 
   B:= C + LRot32(B + (C xor D xor A) + Data[10] + $bebfbc70,23); 
   A:= B + LRot32(A + (B xor C xor D) + Data[13] + $289b7ec6,4); 
   D:= A + LRot32(D + (A xor B xor C) + Data[ 0] + $eaa127fa,11); 
   C:= D + LRot32(C + (D xor A xor B) + Data[ 3] + $d4ef3085,16); 
   B:= C + LRot32(B + (C xor D xor A) + Data[ 6] + $04881d05,23); 
   A:= B + LRot32(A + (B xor C xor D) + Data[ 9] + $d9d4d039,4); 
   D:= A + LRot32(D + (A xor B xor C) + Data[12] + $e6db99e5,11); 
   C:= D + LRot32(C + (D xor A xor B) + Data[15] + $1fa27cf8,16); 
   B:= C + LRot32(B + (C xor D xor A) + Data[ 2] + $c4ac5665,23); 
 
   A:= B + LRot32(A + (C xor (B or (not D))) + Data[ 0] + $f4292244,6); 
   D:= A + LRot32(D + (B xor (A or (not C))) + Data[ 7] + $432aff97,10); 
   C:= D + LRot32(C + (A xor (D or (not B))) + Data[14] + $ab9423a7,15); 
   B:= C + LRot32(B + (D xor (C or (not A))) + Data[ 5] + $fc93a039,21); 
   A:= B + LRot32(A + (C xor (B or (not D))) + Data[12] + $655b59c3,6); 
   D:= A + LRot32(D + (B xor (A or (not C))) + Data[ 3] + $8f0ccc92,10); 
   C:= D + LRot32(C + (A xor (D or (not B))) + Data[10] + $ffeff47d,15); 
   B:= C + LRot32(B + (D xor (C or (not A))) + Data[ 1] + $85845dd1,21); 
   A:= B + LRot32(A + (C xor (B or (not D))) + Data[ 8] + $6fa87e4f,6); 
   D:= A + LRot32(D + (B xor (A or (not C))) + Data[15] + $fe2ce6e0,10); 
   C:= D + LRot32(C + (A xor (D or (not B))) + Data[ 6] + $a3014314,15); 
   B:= C + LRot32(B + (D xor (C or (not A))) + Data[13] + $4e0811a1,21); 
   A:= B + LRot32(A + (C xor (B or (not D))) + Data[ 4] + $f7537e82,6); 
   D:= A + LRot32(D + (B xor (A or (not C))) + Data[11] + $bd3af235,10); 
   C:= D + LRot32(C + (A xor (D or (not B))) + Data[ 2] + $2ad7d2bb,15); 
   B:= C + LRot32(B + (D xor (C or (not A))) + Data[ 9] + $eb86d391,21); 
 
   Inc(CurrentHash[0],A); 
   Inc(CurrentHash[1],B); 
   Inc(CurrentHash[2],C); 
   Inc(CurrentHash[3],D); 
   Index:= 0; 
   FillChar(HashBuffer,Sizeof(HashBuffer),0); 
 end; 
 
 
 procedure Update(const Buffer; Size: longword); 
 var 
   PBuf: ^byte; 
 begin 
   Inc(LenHi,Size shr 29); 
   Inc(LenLo,Size*8); 
   if LenLo&lt; (Size*8) then 
     Inc(LenHi); 
 
   PBuf:= @Buffer; 
   while Size&gt; 0 do 
   begin 
     if (Sizeof(HashBuffer)-Index)&lt;= DWord(Size) then 
     begin 
       Move(PBuf^,HashBuffer[Index],Sizeof(HashBuffer)-Index); 
       Dec(Size,Sizeof(HashBuffer)-Index); 
       Inc(PBuf,Sizeof(HashBuffer)-Index); 
       Compress; 
     end 
     else 
     begin 
       Move(PBuf^,HashBuffer[Index],Size); 
       Inc(Index,Size); 
       Size:= 0; 
     end; 
   end; 
 end; 
 
 procedure Final(var Digest); 
 begin 
   HashBuffer[Index]:= $80; 
   if Index&gt;= 56 then Compress; 
   PDWord(@HashBuffer[56])^:= LenLo; 
   PDWord(@HashBuffer[60])^:= LenHi; 
   Compress; 
   Move(CurrentHash,Digest,Sizeof(CurrentHash)); 
   Burn; 
 end; 
 
 
begin 
 Init; 
 Update(s[1],Length(s)); 
 Final(a); 
 result:=''; 
 for i:=0 to 15 do 
   result:=result+IntToHex(a[i],2); 
 Burn; 
end;
</pre>

<div class="author">Автор: Vit</div>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Вычисление хеш-суммы MD5
 
Зависимости: Windows, SysUtils, Classes
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   http://www.faqs.org/rfcs/rfc1321.html
Дата:        19 июня 2002 г.
********************************************** }
 
{******************************************************************}
{ MD5 Hashsum Evaluation Unit For Borland Delphi }
{ }
{ Copyright © 2002 by Dimka Maslov }
{ E-mail: mainbox@endimus.com, }
{ Web-site: http://www.endimus.com }
{ }
{ Derived from the RSA Data Security, Inc. }
{ MD5 Message-Digest Algorithm described in RFC 1321 }
{ http://www.faqs.org/rfcs/rfc1321.html }
{******************************************************************}
 
unit md5;
 
interface
 
uses Windows, SysUtils, Classes;
 
type
 { Тип TMD5Digest используется для получения
   результата функций вычисления хеш-суммы.
   Содержимое записи можно использовать
   как набор из 4 целых чисел, или как 
   массив из 16 байт }
 PMD5Digest = ^TMD5Digest;
 TMD5Digest = record
  case Integer of
   0: (A, B, C, D: LongInt);
   1: (v: array [0..15] of Byte);
 end;
 
// вычисление хеш-суммы для строки
function MD5String(const S: string): TMD5Digest;
 
// вычисление хеш-суммы для файла
function MD5File(const FileName: string): TMD5Digest;
 
// вычисление хеш-суммы для содержиого потока Stream
function MD5Stream(const Stream: TStream): TMD5Digest;
 
// вычисление хеш-суммы для произвольного буфера
function MD5Buffer(const Buffer; Size: Integer): TMD5Digest;
 
// преобразование хеш-суммы в строку из шестнадцатеричных цифр
function MD5DigestToStr(const Digest: TMD5Digest): string;
 
// сравнение двух хеш-сумм
function MD5DigestCompare(const Digest1, Digest2: TMD5Digest): Boolean;
 
implementation
 
{
Copyright (C) 1991-2, RSA Data Security, Inc. Created 1991. All
rights reserved.
 
License to copy and use this software is granted provided that it
is identified as the "RSA Data Security, Inc. MD5 Message-Digest
Algorithm" in all material mentioning or referencing this software
or this function.
 
License is also granted to make and use derivative works provided
that such works are identified as "derived from the RSA Data
Security, Inc. MD5 Message-Digest Algorithm" in all material
mentioning or referencing the derived work.
 
RSA Data Security, Inc. makes no representations concerning either
the merchantability of this software or the suitability of this
software for any particular purpose. It is provided "as is"
without express or implied warranty of any kind.
 
These notices must be retained in any copies of any part of this
documentation and/or software.
}
 
type
 UINT4 = LongWord;
 
 PArray4UINT4 = ^TArray4UINT4;
 TArray4UINT4 = array [0..3] of UINT4;
 PArray2UINT4 = ^TArray2UINT4;
 TArray2UINT4 = array [0..1] of UINT4;
 PArray16Byte = ^TArray16Byte;
 TArray16Byte = array [0..15] of Byte;
 PArray64Byte = ^TArray64Byte;
 TArray64Byte = array [0..63] of Byte;
 
 PByteArray = ^TByteArray;
 TByteArray = array [0..0] of Byte;
 
 PUINT4Array = ^TUINT4Array;
 TUINT4Array = array [0..0] of UINT4;
 
 PMD5Context = ^TMD5Context;
 TMD5Context = record
   state: TArray4UINT4;
   count: TArray2UINT4;
   buffer: TArray64Byte;
 end;
 
const
  S11 = 7;
  S12 = 12;
  S13 = 17;
  S14 = 22;
  S21 = 5;
  S22 = 9;
  S23 = 14;
  S24 = 20;
  S31 = 4;
  S32 = 11;
  S33 = 16;
  S34 = 23;
  S41 = 6;
  S42 = 10;
  S43 = 15;
  S44 = 21;
 
var
 Padding : TArray64Byte =
 ($80, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
  0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
  0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
 
 
function _F(x, y, z: UINT4): UINT4;
begin
 Result := (((x) and (y)) or ((not x) and (z)));
end;
 
function _G(x, y, z: UINT4): UINT4;
begin
 Result := (((x) and (z)) or ((y) and (not z)));
end;
 
function _H(x, y, z: UINT4): UINT4;
begin
 Result := ((x) xor (y) xor (z));
end;
 
function _I(x, y, z: UINT4): UINT4;
begin
 Result := ((y) xor ((x) or ( not z)));
end;
 
function ROTATE_LEFT(x, n: UINT4): UINT4;
begin
 Result := (((x) shl (n)) or ((x) shr (32-(n))));
end;
 
procedure FF(var a: UINT4; b, c, d, x, s, ac: UINT4);
begin
  a := a + _F(b, c, d) + x + ac;
  a := ROTATE_LEFT (a, s);
  a := a + b;
end;
 
procedure GG(var a: UINT4; b, c, d, x, s, ac: UINT4);
begin
 a := a + _G(b, c, d) + x + ac;
 a := ROTATE_LEFT(a, s);
 a := a + b;
end;
 
procedure HH(var a: UINT4; b, c, d, x, s, ac: UINT4);
begin
 a := a + _H(b, c, d) + x + ac;
 a := ROTATE_LEFT(a, s);
 a := a + b;
end;
 
procedure II(var a: UINT4; b, c, d, x, s, ac: UINT4);
begin
 a := a + _I(b, c, d) + x + ac;
 a := ROTATE_LEFT(a, s);
 a := a + b;
end;
 
procedure MD5Encode(Output: PByteArray; Input: PUINT4Array; Len: LongWord);
var
 i, j: LongWord;
begin
 j:=0;
 i:=0;
 while j &lt; Len do begin
  output[j] := Byte(input[i] and $ff);
  output[j+1] := Byte((input[i] shr 8) and $ff);
  output[j+2] := Byte((input[i] shr 16) and $ff);
  output[j+3] := Byte((input[i] shr 24) and $ff);
  Inc(j, 4);
  Inc(i);
 end;
end;
 
procedure MD5Decode(Output: PUINT4Array; Input: PByteArray; Len: LongWord);
var
 i, j: LongWord;
begin
 j:=0;
 i:=0;
 while j &lt; Len do begin
  Output[i] := UINT4(input[j]) or (UINT4(input[j+1]) shl 8) or
   (UINT4(input[j+2]) shl 16) or ( UINT4(input[j+3]) shl 24);
  Inc(j, 4);
  Inc(i);
 end;
end;
 
procedure MD5_memcpy(Output: PByteArray; Input: PByteArray; Len: LongWord);
begin
 Move(Input^, Output^, Len);
end;
 
procedure MD5_memset(Output: PByteArray; Value: Integer; Len: LongWord);
begin
 FillChar(Output^, Len, Byte(Value));
end;
 
procedure MD5Transform(State: PArray4UINT4; Buffer: PArray64Byte);
var
 a, b, c, d: UINT4;
 x : array[0..15] of UINT4;
begin
 a:=State[0]; b:=State[1]; c:=State[2]; d:=State[3];
 MD5Decode(PUINT4Array(@x), PByteArray(Buffer), 64);
 
 FF (a, b, c, d, x[ 0], S11, $d76aa478);
 FF (d, a, b, c, x[ 1], S12, $e8c7b756);
 FF (c, d, a, b, x[ 2], S13, $242070db);
 FF (b, c, d, a, x[ 3], S14, $c1bdceee);
 FF (a, b, c, d, x[ 4], S11, $f57c0faf);
 FF (d, a, b, c, x[ 5], S12, $4787c62a);
 FF (c, d, a, b, x[ 6], S13, $a8304613);
 FF (b, c, d, a, x[ 7], S14, $fd469501);
 FF (a, b, c, d, x[ 8], S11, $698098d8);
 FF (d, a, b, c, x[ 9], S12, $8b44f7af);
 FF (c, d, a, b, x[10], S13, $ffff5bb1);
 FF (b, c, d, a, x[11], S14, $895cd7be);
 FF (a, b, c, d, x[12], S11, $6b901122);
 FF (d, a, b, c, x[13], S12, $fd987193);
 FF (c, d, a, b, x[14], S13, $a679438e);
 FF (b, c, d, a, x[15], S14, $49b40821);
 
 GG (a, b, c, d, x[ 1], S21, $f61e2562);
 GG (d, a, b, c, x[ 6], S22, $c040b340);
 GG (c, d, a, b, x[11], S23, $265e5a51);
 GG (b, c, d, a, x[ 0], S24, $e9b6c7aa);
 GG (a, b, c, d, x[ 5], S21, $d62f105d);
 GG (d, a, b, c, x[10], S22, $2441453);
 GG (c, d, a, b, x[15], S23, $d8a1e681);
 GG (b, c, d, a, x[ 4], S24, $e7d3fbc8);
 GG (a, b, c, d, x[ 9], S21, $21e1cde6);
 GG (d, a, b, c, x[14], S22, $c33707d6);
 GG (c, d, a, b, x[ 3], S23, $f4d50d87);
 
 GG (b, c, d, a, x[ 8], S24, $455a14ed);
 GG (a, b, c, d, x[13], S21, $a9e3e905);
 GG (d, a, b, c, x[ 2], S22, $fcefa3f8);
 GG (c, d, a, b, x[ 7], S23, $676f02d9);
 GG (b, c, d, a, x[12], S24, $8d2a4c8a);
 
 HH (a, b, c, d, x[ 5], S31, $fffa3942);
 HH (d, a, b, c, x[ 8], S32, $8771f681);
 HH (c, d, a, b, x[11], S33, $6d9d6122);
 HH (b, c, d, a, x[14], S34, $fde5380c);
 HH (a, b, c, d, x[ 1], S31, $a4beea44);
 HH (d, a, b, c, x[ 4], S32, $4bdecfa9);
 HH (c, d, a, b, x[ 7], S33, $f6bb4b60);
 HH (b, c, d, a, x[10], S34, $bebfbc70);
 HH (a, b, c, d, x[13], S31, $289b7ec6);
 HH (d, a, b, c, x[ 0], S32, $eaa127fa);
 HH (c, d, a, b, x[ 3], S33, $d4ef3085);
 HH (b, c, d, a, x[ 6], S34, $4881d05);
 HH (a, b, c, d, x[ 9], S31, $d9d4d039);
 HH (d, a, b, c, x[12], S32, $e6db99e5);
 HH (c, d, a, b, x[15], S33, $1fa27cf8);
 HH (b, c, d, a, x[ 2], S34, $c4ac5665);
 
 II (a, b, c, d, x[ 0], S41, $f4292244);
 II (d, a, b, c, x[ 7], S42, $432aff97);
 II (c, d, a, b, x[14], S43, $ab9423a7);
 II (b, c, d, a, x[ 5], S44, $fc93a039);
 II (a, b, c, d, x[12], S41, $655b59c3);
 II (d, a, b, c, x[ 3], S42, $8f0ccc92);
 II (c, d, a, b, x[10], S43, $ffeff47d);
 II (b, c, d, a, x[ 1], S44, $85845dd1);
 II (a, b, c, d, x[ 8], S41, $6fa87e4f);
 II (d, a, b, c, x[15], S42, $fe2ce6e0);
 II (c, d, a, b, x[ 6], S43, $a3014314);
 II (b, c, d, a, x[13], S44, $4e0811a1);
 II (a, b, c, d, x[ 4], S41, $f7537e82);
 II (d, a, b, c, x[11], S42, $bd3af235);
 II (c, d, a, b, x[ 2], S43, $2ad7d2bb);
 II (b, c, d, a, x[ 9], S44, $eb86d391);
 
 Inc(State[0], a);
 Inc(State[1], b);
 Inc(State[2], c);
 Inc(State[3], d);
 
 MD5_memset (PByteArray(@x), 0, SizeOf (x));
end;
 
 
procedure MD5Init(var Context: TMD5Context);
begin
 FillChar(Context, SizeOf(Context), 0);
 Context.state[0] := $67452301;
 Context.state[1] := $efcdab89;
 Context.state[2] := $98badcfe;
 Context.state[3] := $10325476;
end;
 
procedure MD5Update(var Context: TMD5Context; Input: PByteArray; InputLen: LongWord);
var
 i, index, partLen: LongWord;
 
begin
 index := LongWord( (context.count[0] shr 3) and $3F);
 Inc(Context.count[0], UINT4(InputLen) shl 3);
 if Context.count[0] &lt; UINT4(InputLen) shl 3 then Inc(Context.count[1]);
 Inc(Context.count[1], UINT4(InputLen) shr 29);
 partLen := 64 - index;
 if inputLen &gt;= partLen then begin
  MD5_memcpy(PByteArray(@Context.buffer[index]), Input, PartLen);
  MD5Transform(@Context.state, @Context.buffer);
  i := partLen;
  while i + 63 &lt; inputLen do begin
   MD5Transform(@Context.state, PArray64Byte(@Input[i]));
   Inc(i, 64);
  end;
  index := 0;
 end else i:=0;
 MD5_memcpy(PByteArray(@Context.buffer[index]), PByteArray(@Input[i]), inputLen - i);
end;
 
 
procedure MD5Final(var Digest: TMD5Digest; var Context: TMD5Context);
var
 bits: array [0..7] of Byte;
 index, padLen: LongWord;
begin
 MD5Encode(PByteArray(@bits), PUINT4Array(@Context.count), 8);
 index := LongWord( (Context.count[0] shr 3) and $3F);
 if index &lt; 56 then padLen := 56 - index else padLen := 120 - index;
 MD5Update(Context, PByteArray(@PADDING), padLen);
 MD5Update(Context, PByteArray(@Bits), 8);
 MD5Encode(PByteArray(@Digest), PUINT4Array(@Context.state), 16);
 MD5_memset(PByteArray(@Context), 0, SizeOf(Context));
end;
 
function MD5DigestToStr(const Digest: TMD5Digest): string;
var
 i: Integer;
begin
 Result:='';
 for i:=0 to 15 do Result:=Result+IntToHex(Digest.v[i], 2);
end;
 
function MD5String(const S: string): TMD5Digest;
begin
 Result:=MD5Buffer(PChar(S)^, Length(S));
end;
 
function MD5File(const FileName: string): TMD5Digest;
var
 F: TFileStream;
begin
 F:=TFileStream.Create(FileName, fmOpenRead);
 try
  Result:=MD5Stream(F);
 finally
  F.Free;
 end;
end;
 
function MD5Stream(const Stream: TStream): TMD5Digest;
var
 Context: TMD5Context;
 Buffer: array[0..4095] of Byte;
 Size: Integer;
 ReadBytes : Integer;
 TotalBytes : Integer;
 SavePos: Integer;
begin
 MD5Init(Context);
 Size:=Stream.Size;
 SavePos:=Stream.Position;
 TotalBytes:=0;
 try
  Stream.Seek(0, soFromBeginning);
  repeat
   ReadBytes:=Stream.Read(Buffer, SizeOf(Buffer));
   Inc(TotalBytes, ReadBytes);
   MD5Update(Context, @Buffer, ReadBytes);
  until (ReadBytes = 0) or (TotalBytes = Size);
 finally
  Stream.Seek(SavePos, soFromBeginning);
 end;
 MD5Final(Result, Context);
end;
 
function MD5Buffer(const Buffer; Size: Integer): TMD5Digest;
var
 Context: TMD5Context;
begin
 MD5Init(Context);
 MD5Update(Context, PByteArray(@Buffer), Size);
 MD5Final(Result, Context);
end;
 
function MD5DigestCompare(const Digest1, Digest2: TMD5Digest): Boolean;
begin
 Result:=False;
 if Digest1.A &lt;&gt; Digest2.A then Exit;
 if Digest1.B &lt;&gt; Digest2.B then Exit;
 if Digest1.C &lt;&gt; Digest2.C then Exit;
 if Digest1.D &lt;&gt; Digest2.D then Exit;
 Result:=True;
end;
 
 
end.
</pre>

<hr />
<div class="author">Автор: Nikonov A.A. </div>

<pre>
unit psnMD5;
 
interface
 
uses Windows, SysUtils, Classes;
 
type
   PMD5Digest = ^TMD5Digest;
   TMD5Digest = record
      case Integer of
         0: (A, B, C, D: LongInt);
         1: (v: array[0..15] of Byte);
       end;
function MD5String(const S: string): TMD5Digest;
function MD5File(const FileName: string): TMD5Digest;
function MD5Stream(const Stream: TStream): TMD5Digest;
function MD5Buffer(const Buffer;
  Size: Integer): TMD5Digest;
function MD5DigestToStr(const Digest:
  TMD5Digest): string;
function MD5DigestCompare(const Digest1,
  Digest2: TMD5Digest): Boolean;
 
  implementation
 
type
   UINT4 = LongWord;
 
     PArray4UINT4 = ^TArray4UINT4;
   TArray4UINT4 = array[0..3] of UINT4;
   PArray2UINT4 = ^TArray2UINT4;
   TArray2UINT4 = array[0..1] of UINT4;
   PArray16Byte = ^TArray16Byte;
   TArray16Byte = array[0..15] of Byte;
   PArray64Byte = ^TArray64Byte;
   TArray64Byte = array[0..63] of Byte;
 
     PByteArray = ^TByteArray;
   TByteArray = array[0..0] of Byte;
 
     PUINT4Array = ^TUINT4Array;
   TUINT4Array = array[0..0] of UINT4;
 
     PMD5Context = ^TMD5Context;
   TMD5Context = record
       state: TArray4UINT4;
       count: TArray2UINT4;
       buffer: TArray64Byte;
     end;
 
      const 
        S11 = 7;
      S12 = 12;
      S13 = 17;
      S14 = 22;
      S21 = 5;
      S22 = 9;
      S23 = 14;
      S24 = 20;
      S31 = 4;
      S32 = 11;
      S33 = 16;
      S34 = 23;
      S41 = 6;
      S42 = 10;
      S43 = 15;
      S44 = 21;
 
      var 
       Padding: TArray64Byte =
     ($80, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
 
 
 
function _F(x, y, z:
  UINT4): UINT4;
begin
   Result := (((x) and (y)) or ((not x) and (z)));
end;
 
 
function _G(x, y, z:
  UINT4): UINT4;
begin
   Result := (((x) and (z)) or ((y)
    and (not z)));
end;
 
 
function _H(x, y, z:
  UINT4): UINT4;
begin
   Result := ((x)xor (y)
    xor (z));
end;
 
 
function _I(x, y, z:
  UINT4): UINT4;
begin
   Result := ((y)xor ((x)
    or (not z)));
end;
 
 
function ROTATE_LEFT(x, n: UINT4): UINT4;
begin
   Result := (((x)shl (n))
    or ((x)shr (32 - (n))));
end;
 
 
procedure FF(var a: UINT4; b,
  c, d, x, s, ac: UINT4);
begin
    a := a + _F(b, c, d)
    + x + ac;
    a := ROTATE_LEFT(a, s);
    a := a + b;
end;
 
 
procedure GG(var a: UINT4; b,
  c, d, x, s, ac: UINT4);
begin
   a := a + _G(b, c, d)
    + x + ac;
   a := ROTATE_LEFT(a, s);
   a := a + b;
end;
 
 
procedure HH(var a: UINT4; b,
  c, d, x, s, ac: UINT4);
begin
   a := a + _H(b, c, d)
    + x + ac;
   a := ROTATE_LEFT(a, s);
   a := a + b;
end;
 
 
procedure II(var a: UINT4; b,
  c, d, x, s, ac: UINT4);
begin
   a := a + _I(b, c, d)
    + x + ac;
   a := ROTATE_LEFT(a, s);
   a := a + b;
end;
 
 
procedure MD5Encode(Output: PByteArray; Input: PUINT4Array; Len: LongWord);
var 
   i, j: LongWord;
begin
   j := 0;
   i := 0;
   while j  '&lt;';
  Len do  begin
      output[j] := Byte(input[i] and $FF);
    output[j + 1] := Byte((input[i]shr 8)
    and $FF);
    output[j + 2] := Byte((input[i]shr 16)
    and $FF);
    output[j + 3] := Byte((input[i]shr 24)
    and $FF);
    Inc(j, 4);
    Inc(i);
   end;
end;
 
 
procedure MD5Decode(Output: PUINT4Array; Input: PByteArray; Len: LongWord);
var 
   i, j: LongWord;
begin
   j := 0;
   i := 0;
   while j  '&lt;';
  Len do
  begin
      Output[i] := UINT4(input[j])
      or (UINT4(input[j + 1])shl 8)
      or
         (UINT4(input[j + 2])shl 16)
      or (UINT4(input[j + 3])shl 24);
      Inc(j, 4);
      Inc(i);
     end;
  end;
 
 
procedure MD5_memcpy(Output:
  PByteArray; Input: PByteArray; Len: LongWord);
begin
   Move(Input^, Output^, Len);
end;
 
 
procedure MD5_memset(Output:
  PByteArray; Value: Integer; Len: LongWord);
begin
   FillChar(Output^, Len, Byte(Value));
end;
 
 
procedure MD5Transform(State: PArray4UINT4; Buffer: PArray64Byte);
var 
   a, b, c, d: UINT4;
 x: array[0..15] of UINT4;
begin
   a := State[0];
  b := State[1];
  c := State[2];
  d := State[3];
   MD5Decode(PUINT4Array(@x), PByteArray(Buffer), 64);
 
     FF(a, b, c, d,
    x[0], S11, $D76AA478);
   FF(d, a, b,
    c, x[1], S12, $E8C7B756);
   FF(c, d, a, b,
    x[2], S13, $242070DB);
   FF(b, c, d,
    a, x[3], S14, $C1BDCEEE);
   FF(a, b, c, d,
    x[4], S11, $F57C0FAF);
   FF(d, a, b,
    c, x[5], S12, $4787C62A);
   FF(c, d, a, b,
    x[6], S13, $A8304613);
   FF(b, c, d,
    a, x[7], S14, $FD469501);
   FF(a, b, c, d,
    x[8], S11, $698098D8);
   FF(d, a, b,
    c, x[9], S12, $8B44F7AF);
   FF(c, d, a, b,
    x[10], S13, $FFFF5BB1);
   FF(b, c, d,
    a, x[11], S14, $895CD7BE);
   FF(a, b, c, d,
    x[12], S11, $6B901122);
   FF(d, a, b,
    c, x[13], S12, $FD987193);
   FF(c, d, a, b,
    x[14], S13, $A679438E);
   FF(b, c, d,
    a, x[15], S14, $49B40821);
 
     GG(a, b, c, d,
    x[1], S21, $F61E2562);
   GG(d, a, b,
    c, x[6], S22, $C040B340);
   GG(c, d, a, b,
    x[11], S23, $265E5A51);
   GG(b, c, d,
    a, x[0], S24, $E9B6C7AA);
   GG(a, b, c, d,
    x[5], S21, $D62F105D);
   GG(d, a, b,
    c, x[10], S22,  $2441453);
   GG(c, d, a, b,
    x[15], S23, $D8A1E681);
   GG(b, c, d,
    a, x[4], S24, $E7D3FBC8);
   GG(a, b, c, d,
    x[9], S21, $21E1CDE6);
   GG(d, a, b,
    c, x[14], S22, $C33707D6);
   GG(c, d, a, b,
    x[3], S23, $F4D50D87);
 
     GG(b, c, d,
    a, x[8], S24, $455A14ED);
   GG(a, b, c, d,
    x[13], S21, $A9E3E905);
   GG(d, a, b,
    c, x[2], S22, $FCEFA3F8);
   GG(c, d, a, b,
    x[7], S23, $676F02D9);
   GG(b, c, d,
    a, x[12], S24, $8D2A4C8A);
 
     HH(a, b, c, d,
    x[5], S31, $FFFA3942);
   HH(d, a, b,
    c, x[8], S32, $8771F681);
   HH(c, d, a, b,
    x[11], S33, $6D9D6122);
   HH(b, c, d,
    a, x[14], S34, $FDE5380C);
   HH(a, b, c, d,
    x[1], S31, $A4BEEA44);
   HH(d, a, b,
    c, x[4], S32, $4BDECFA9);
   HH(c, d, a, b,
    x[7], S33, $F6BB4B60);
   HH(b, c, d,
    a, x[10], S34, $BEBFBC70);
   HH(a, b, c, d,
    x[13], S31, $289B7EC6);
   HH(d, a, b,
    c, x[0], S32, $EAA127FA);
   HH(c, d, a, b,
    x[3], S33, $D4EF3085);
   HH(b, c, d,
    a, x[6], S34,  $4881d05);
   HH(a, b, c, d,
    x[9], S31, $D9D4D039);
   HH(d, a, b,
    c, x[12], S32, $E6DB99E5);
   HH(c, d, a, b,
    x[15], S33, $1FA27CF8);
   HH(b, c, d,
    a, x[2], S34, $C4AC5665);
 
     II(a, b, c, d,
    x[0], S41, $F4292244);
   II(d, a, b,
    c, x[7], S42, $432AFF97);
   II(c, d, a, b,
    x[14], S43, $AB9423A7);
   II(b, c, d,
    a, x[5], S44, $FC93A039);
   II(a, b, c, d,
    x[12], S41, $655B59C3);
   II(d, a, b,
    c, x[3], S42, $8F0CCC92);
   II(c, d, a, b,
    x[10], S43, $FFEFF47D);
   II(b, c, d,
    a, x[1], S44, $85845DD1);
   II(a, b, c, d,
    x[8], S41, $6FA87E4F);
   II(d, a, b,
    c, x[15], S42, $FE2CE6E0);
   II(c, d, a, b,
    x[6], S43, $A3014314);
   II(b, c, d,
    a, x[13], S44, $4E0811A1);
   II(a, b, c, d,
    x[4], S41, $F7537E82);
   II(d, a, b,
    c, x[11], S42, $BD3AF235);
   II(c, d, a, b,
    x[2], S43, $2AD7D2BB);
   II(b, c, d,
    a, x[9], S44, $EB86D391);
 
     Inc(State[0], a);
   Inc(State[1], b);
   Inc(State[2], c);
   Inc(State[3], d);
 
     MD5_memset (PByteArray(@x), 0, SizeOf(x));
end;
 
 
 
procedure MD5Init(var Context: TMD5Context);
begin
   FillChar(Context, SizeOf(Context), 0);
   Context.state[0] := $67452301;
   Context.state[1] := $EFCDAB89;
   Context.state[2] := $98BADCFE;
   Context.state[3] := $10325476;
end;
 
 
procedure MD5Update(var Context:
  TMD5Context; Input: PByteArray; InputLen: LongWord);
var 
   i, index, partLen: LongWord;
 
begin
   index := LongWord((context.count[0]shr 3)
    and $3F);
   Inc(Context.count[0], UINT4(InputLen)shl 3);
   if Context.count[0]'&lt;';
  UINT4(InputLen)shl 3
    then Inc(Context.count[1]);
   Inc(Context.count[1], UINT4(InputLen)shr 29);
   partLen := 64 - index;
   if inputLen '&gt;';
  = partLen then
  begin
      MD5_memcpy(PByteArray(@Context.buffer[index]),
      Input, PartLen);
      MD5Transform(@Context.state, @Context.buffer);
      i := partLen;
      while i + 63 '&lt;';
    inputLen do
    begin
         MD5Transform(@Context.state,
        PArray64Byte(@Input[i]));
         Inc(i, 64);
 
    end;
      index := 0;
     end
  else
    i := 0;
     MD5_memcpy(PByteArray(@Context.buffer[index]),
      PByteArray(@Input[i]), inputLen - i);
end;
 
 
 
procedure MD5Final(var Digest: TMD5Digest; var Context:
  TMD5Context);
var 
   bits: array[0..7] of Byte;
 index, padLen: LongWord;
begin
   MD5Encode(PByteArray(@bits), PUINT4Array(@Context.count),
    8);
   index := LongWord((Context.count[0]shr 3)
    and $3F);
   if index '&lt;';
  56 then padLen := 56 - index
else
  padLen := 120 - index;
   MD5Update(Context, PByteArray(@PADDING), padLen);
   MD5Update(Context, PByteArray(@Bits), 8);
   MD5Encode(PByteArray(@Digest), PUINT4Array(@Context.state),
    16);
   MD5_memset(PByteArray(@Context), 0, SizeOf(Context));
end;
 
 
function MD5DigestToStr(const Digest:
  TMD5Digest): string;
var 
   i: Integer;
begin
   Result := '';
   for i := 0 to 15 do Result := Result + IntToHex(Digest.v[i],
    2);
end;
 
 
function MD5String(const S: string): TMD5Digest;
begin
   Result := MD5Buffer(PChar(S)^, Length(S));
end;
 
 
function MD5File(const FileName: string): TMD5Digest;
var 
   F: TFileStream;
begin
   F := TFileStream.Create(FileName, fmOpenRead);
   try
      Result := MD5Stream(F);
   finally
      F.Free;
   end;
end;
 
 
function MD5Stream(const Stream: TStream): TMD5Digest;
var 
   Context: TMD5Context;
 Buffer: array[0..4095] of Byte;
 Size: Integer;
 ReadBytes: Integer;
 TotalBytes: Integer;
 SavePos: Integer;
begin
   MD5Init(Context);
   Size := Stream.Size;
   SavePos := Stream.Position;
   TotalBytes := 0;
   try
      Stream.Seek(0, soFromBeginning);
    repeat
       ReadBytes := Stream.Read(Buffer, SizeOf(Buffer));
       Inc(TotalBytes, ReadBytes);
       MD5Update(Context, @Buffer, ReadBytes);
    until (ReadBytes = 0) or (TotalBytes = Size);
   finally
      Stream.Seek(SavePos, soFromBeginning);
   end;
   MD5Final(Result, Context);
end;
 
 
function MD5Buffer(const Buffer;
  Size: Integer): TMD5Digest;
var 
   Context: TMD5Context;
begin
   MD5Init(Context);
   MD5Update(Context, PByteArray(@Buffer), Size);
   MD5Final(Result, Context);
end;
 
 
function MD5DigestCompare(const Digest1,
  Digest2: TMD5Digest): Boolean;
begin
   Result := False;
   if Digest1.A '&lt;';
  '&gt;';
  Digest2.A then Exit;
   if Digest1.B '&lt;';
  '&gt;';
  Digest2.B then Exit;
   if Digest1.C '&lt;';
  '&gt;';
  Digest2.C then Exit;
   if Digest1.D '&lt;';
  '&gt;';
  Digest2.D then Exit;
   Result := True;
end;
 
end.
 
/////////////////////////////////////
// Данные в модуль можно загнать так
 
procedure TForm1.Button1Click(Sender: TObject);
var                                                                 
  InFile: TFileStream;                                                 
begin                                                                 
  InFile := TFileStream.Create(fname, fmShareDenyNone);              
  Caption := MD5DigestToStr(MD5Stream(INFILE));                    
end;
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

