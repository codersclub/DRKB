<h1>CRC-64</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Nikonov A.A.</div>

<pre class="delphi">
unit psnCRC64;
interface
 
uses Classes;
 
procedure CRC64Next(const Data; const Count:
  Cardinal; var CRC64: Int64);
function CRC64Full(const Data; const Count:
  Cardinal): Int64;
function  CRC64Stream(const Source:
  TStream; Count: Integer; const BufSize:
  Cardinal = 1024): Int64;
 
implementation
 
var T: array[Byte] of Int64;
 
 
procedure CRC64Next(const Data; const Count:
  Cardinal; var CRC64: Int64);
var 
   MyCRC64: Int64;
 I: Cardinal;
 PData: ^Byte;
begin
   PData := @Data;
   MyCRC64 := CRC64;
   for I := 1 to Count do
  begin
      MyCRC64 := MyCRC64 shr 8 xor T[Cardinal(MyCRC64)
      and $FF xor PData^];
      Inc(PData);
     end;
     CRC64 := MyCRC64;
  end;
 
 
  function CRC64Full(const Data; const Count:
  Cardinal): Int64;
begin
   Result := not 0;
   CRC64Next(Data, Count, Result);
end;
 
 
  function  CRC64Stream(const Source:
  TStream; Count: Integer;
   const BufSize: Cardinal = 1024): Int64;
var 
   N: Cardinal;
 Buffer: Pointer;
begin
   if Count '&lt;';
  0
     then Count := Source.Size;
   GetMem(Buffer, BufSize);
  try
     Result := not 0;
     while Count '&lt;';
    '&gt;';
    0 do
    begin
        if Cardinal(Count)'&gt;';
      BufSize
          then
        N := BufSize
 
        else
        N := Count;
        Source.ReadBuffer(Buffer^, N);
        CRC64Next(Buffer^, N, Result);
        Dec(Count, N);
       end;
       finally FreeMem(Buffer);
    end;
  end;
 
  var 
    I, J: Byte;
    D: Int64;
 
initialization
 
  for I := 0 to 255 do
  begin
      D := I;
      for J := 1 to 8 do
         if Odd(D)
           then D := D shr 1 xor $C96C5795D7870F42
           else D := D shr 1;
      T[I] := D;
     end;
  end.
 
/////////////////////////////////////
// Данные в модуль можно загнать так
procedure TForm1.Button1Click(Sender: TObject);                    
var                                                                   
  InFile: TFileStream;                                                
begin                                                                 
  InFile := TFileStream.Create(fname, fmShareDenyNone);                 
  Caption := INTTOHEX(CRC64Stream(INFILE, SIZEOF(INFILE), 1024), 16);   
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
