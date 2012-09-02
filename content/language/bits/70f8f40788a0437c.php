<h1>Как получить доступ к битам переменной и управлять их значением?</h1>
<div class="date">01.01.2007</div>


<pre>
unit Bitwise;
 
interface
 
function IsBitSet(const val: longint; const TheBit: byte): boolean;
function BitOn(const val: longint; const TheBit: byte): LongInt;
function BitOff(const val: longint; const TheBit: byte): LongInt;
function BitToggle(const val: longint; const TheBit: byte): LongInt;
 
implementation
 
function IsBitSet(const val: longint; const TheBit: byte): boolean;
begin
 result := (val and (1 shl TheBit)) &lt;&gt; 0;
end;
 
function BitOn(const val: longint; const TheBit: byte): LongInt;
begin
 result := val or (1 shl TheBit);
end;
 
function BitOff(const val: longint; const TheBit: byte): LongInt;
begin
 result := val and ((1 shl TheBit) xor $FFFFFFFF);
end;
 
function BitToggle(const val: longint; const TheBit: byte): LongInt;
begin
 result := val xor (1 shl TheBit);
end;
 
end.
</pre>

<hr />
<p>SetWord &#8211; слово, которое необходимо установить.</p>
<p>BitNum &#8211; номер бита, который необходимо выставить согласно определениям в секции const (Bit0, Bit1 и др.).</p>
<p>GetBitStat возвращает значение True, если бит установлен и False &#8211; в противном случае.</p>

<pre>
const
 Bit0 = 1;
 Bit1 = 2;
 Bit2 = 4;
 Bit3 = 8;
 Bit4 = 16;
 Bit5 = 32;
 Bit6 = 64;
 Bit7 = 128;
 
 Bit8 = 256;
 Bit9 = 512;
 Bit10 = 1024;
 Bit11 = 2048;
 Bit12 = 4096;
 Bit13 = 8192;
 Bit14 = 16384;
 Bit15 = 32768;
 
procedure SetBit(SetWord, BitNum: Word);
begin
 SetWord := SetWord Or BitNum;        { Устанавливаем бит }
end;
 
procedure ClearBit(SetWord, BitNum: Word);
begin
 SetWord := SetWord Or BitNum;       { Устанавливаем бит }
 SetWord := SetWord Xor BitNum;      { Переключаем бит }
end;
 
procedure ToggleBit(SetWord, BitNum: Word);
begin
 SetWord := SetWord Xor BitNum;      { Переключаем бит }
end;
 
function GetBitStat(SetWord, BitNum: Word): Boolean;
begin
 GetBitStat := SetWord and BitNum = BitNum; { Если бит установлен }
end;
</pre>

<p>Источник: Книга В. Озерова "Delphi. Советы программистов"</p>


<p class="author">Автор: StayAtHome</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

