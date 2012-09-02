<h1>Установка бита в единицу</h1>
<div class="date">01.01.2007</div>


<p>Установка бита в единицу</p>
<pre>
function BitOn(const val: longint; const TheBit: byte): LongInt;

begin
  Result := val or (1 shl TheBit);
end;
</pre>

<p class="author">Автор ответа: s-mike </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<pre>
procedure SetBit(SetWord, BitNum: Word);
begin
  SetWord := SetWord or BitNum; { Устанавливаем бит }
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Установка определенного бита в слове
 
Возвращает AWord с установленным битом номер ABit (c 0 по 15) в значение 1,
если AState = TRUE или 0, если AState = FALSE.
 
Стоит заметить, что в функцию передается именно номер бита, а не маска.
Проверка на правильный номер не производится.
 
Зависимости: System
Автор:       Григорий Ситнин, gregor@gregor.ru, Москва
Copyright:   Григорий Ситнин, 2003
Дата:        8 июля 2003 г.
***************************************************** }
 
function SetBit(AWord: word; ABit: byte; AState: boolean = true): word;
begin
  if AState then
    Result := AWord or (1 shl ABit)
  else
    Result := AWord and (not (1 shl ABit));
end;
Пример использования: 
 
{$APPTYPE CONSOLE}
program test;
uses Bits; // В модуле Bits описана функция SetBit
var
  z: word;
  i: integer;
  s: string;
begin
  z := 0;
  z := setbit(z, 0); // 0000000000000001
  z := setbit(z, 2); // 0000000000000101
  z := setbit(z, 9); // 0000001000000101
  z := setbit(z, 14); // 0100001000000101
  z := setbit(z, 15); // 1100001000000101
  s := '';
  for i := 15 downto 0 do
    s := s + inttostr(Ord(CheckBit(z, i)));
  writeln('value: ', z, ' dec = 1100001000000101');
  writeln('result: ', s);
  z := $FFFF;
  z := setbit(z, 0, false); // 1111111111111110
  z := setbit(z, 2, false); // 1111111111111010
  z := setbit(z, 9, false); // 1111110111111010
  z := setbit(z, 14, false); // 1011110111111010
  z := setbit(z, 15, false); // 0011110111111010
  s := '';
  for i := 15 downto 0 do
    s := s + inttostr(Ord(CheckBit(z, i)));
  writeln('value: ', z, ' dec = 0011110111111010');
  writeln('result: ', s);
end.
</pre>

