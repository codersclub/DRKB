<h1>Как округлять числа?</h1>
<div class="date">01.01.2007</div>


<pre>
function RoundStr(Zn: Real; kol_zn: Integer): Real;
var
  snl, s, s0, s1, s2: string;
  n, n1: Real;
  nn, i: Integer;
begin
  s := FloatToStr(Zn);
  if (Pos(',', s) &gt; 0) and (Zn &gt; 0) and
  (Length(Copy(s, Pos(',', s) + 1, length(s))) &gt; kol_zn) then
  begin
    s0 := Copy(s, 1, Pos(',', s) + kol_zn - 1);
    s1 := Copy(s, 1, Pos(',', s) + kol_zn + 2);
    s2 := Copy(s1, Pos(',', s1) + kol_zn, Length(s1));
    n := StrToInt(s2) / 100;
    nn := Round(n);
    if nn &gt;= 10 then
    begin
      snl := '0,';
      for i := 1 to kol_zn - 1 do
        snl := snl + '0';
      snl := snl + '1';
      n1 := StrToFloat(Copy(s, 1, Pos(',', s) + kol_zn)) + StrToFloat(snl);
      s := FloatToStr(n1);
      if Pos(',', s) &gt; 0 then
        s1 := Copy(s, 1, Pos(',', s) + kol_zn);
    end
    else
      s1 := s0 + IntToStr(nn);
    if s1[Length(s1)] = ',' then
      s1 := s1 + '0';
    Result := StrToFloat(s1);
  end
  else
    Result := Zn;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<pre>
function RoundEx(X: Double; Precision: Integer ): Double;
{
Precision :
1 - до целых
10 - до десятых
100 - до сотых
...
}
var
  ScaledFractPart, Temp: Double;
begin
  ScaledFractPart := Frac(X) * Precision;
  Temp := Frac(ScaledFractPart);
  ScaledFractPart := Int(ScaledFractPart);
  if Temp &gt;= 0.5 then
    ScaledFractPart := ScaledFractPart + 1;
  if Temp &lt;= -0.5 then
    ScaledFractPart := ScaledFractPart - 1;
  RoundEx := Int(X) + ScaledFractPart / Precision;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<p>Округление дробных чисел с точностью i - количество знаков после запятой, S - дробное число в строковом виде.</p>
<pre>
function FormatData(s: String; i: Integer): String;
begin
  Result:=FloatToStr(Round(StrToFloat(s)*exp(i*ln(10)))/(exp(i*ln(10))));
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<p>Как округлять до сотых в большую сторону</p>
<pre>
uses Math;
 
// Прибавляешь 0.5 затем округляешь:
 
function RoundMax(Num: real; prec: integer): real;
begin
  result := roundto(num + Power(10, prec - 1) * 5, prec);
end;
 
// До сотых соответственно будет:
 
function RoundMax100(Num: real): real;
begin
  result := round(num * 100 + 0.5) / 100;
end;
</pre>
<div class="author">Автор: Vit</div>

<hr />

<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; «Округление» в большую сторону
 
Функция возвращает наименьшее число, большее чем Value, которое без остатка
делится на Divider
 
Зависимости: нет
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        20 мая 2002 г.
***************************************************** }
 
function RoundNext(Value, Divider: Integer): Integer;
asm
   mov ecx, edx
   cdq
   idiv ecx
   imul ecx
   add eax, ecx
end;
 
//Пример использования: 
 
RoundNext(10, 3) // = 12
RoundNext(9, 3) // = 12
</pre>

<hr />

<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; «Округление» в меньшую сторону
 
Функция возвращает наибольшее число,
меньшее или равное Value, которое
без остатка делится на Divider
 
Зависимости: нет
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        20 мая 2002 г.
***************************************************** }
 
function RoundPrev(Value, Divider: Integer): Integer;
asm
   mov ecx, edx
   cdq
   idiv ecx
   imul ecx
end;
 
//Пример использования: 
 
RoundPrev(10, 3) // = 9
RoundPrev(9, 3) // = 9
</pre>

<hr />

<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; «Округление» до ближайшего кратного
 
Функция возвращает ближайшее к Value число, которoе без
остатка делится на N. Если Value находится посередине
между двумя кратными, функция вернёт большее значение.
 
Зависимости: нет
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        20 февраля 2003 г.
***************************************************** }
 
function RoundTo(Value, N: Integer): Integer;
asm
   push ebx
   mov ebx, eax
   mov ecx, edx
   cdq
   idiv ecx
   imul ecx
 
   add ecx, eax
   mov edx, ebx
   sub ebx, eax
   jg @@10
   neg ebx
@@10:
   sub edx, ecx
   jg @@20
   neg edx
@@20:
   cmp ebx, edx
   jl @@30
   mov eax, ecx
@@30:
   pop ebx
end;
 
</pre>
<hr />
<p>Округление дробного числа до N знаков после запятой</p>
<div class="author">Автор: Perceptron</div>
<pre>
function RoundEx(chislo: double; Precision: Integer): string;
var
  ChisloInStr: string;
  ChisloInCurr: currency;
begin
  ChisloInCurr := chislo;
  Str(ChisloInCurr: 20: Precision, ChisloInStr);
  ChisloInStr[Pos('.', ChisloInStr)] := ',';
  RoundEx := Trim(ChisloInStr);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Edit1.Text := RoundEx(StrToFloat(Edit1.Text), 2);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Округление чисел c определенной точностью</p>
<pre>
function Rounder(var Value: Double; Decimals: Integer): Double;
 var
   j: Integer;
   A: Double;
 begin
   A := 1;
   case Decimals of
     0: A := 1;
     1: A := 10;
     else
       for j := 1 to Decimals do
         A := A * 10;
   end;
   Result := Int((Value * A) + 0.5) / A;
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   Value: Double;
 begin
   Value := 23.56784;
   //Result is 23.57 
  label1.Caption := FloatToStr(Rounder(Value, 2));
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
{ 
  The function Round of the Delphi doesn't work 
  like it is usually expected. 
  The odd numbera are rounded down and the even numbers up. 
 
 
  Example/ Beispiel: 
 
  x:= Round(17.5) = x = 18 
 
  x:= Round(12.5) = x = 12 
}
 
 function DoRound(const X: Extended): Int64;
 begin
   Result := 0;
   if X0 then
     Result := trunc(X + 0.5);
   if Xthen
     Result := trunc(X - 0.5);
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage(FormatFloat('0.00', DoRound(17.5)));  // - 18 
  ShowMessage(FormatFloat('0.00', DoRound(12.5)));  // - 13 
 
  //This rounds every value to 0.05 steps 
  //Rundet in 0.05 Schritten 
  ShowMessage(FormatFloat('0.00', Round(17.22 / 0.05) * 0.05)); // - 17.20 
end;
 
 
 {***Another function:***}
 
 function RoundUp(Value: Extended): Int64;
   procedure Set8087CW(NewCW: Word);
   asm
          MOV     Default8087CW,AX
          FNCLEX
          FLDCW   Default8087CW
  end;
 const
   RoundUpCW = $1B32;
 var
   OldCW: Word;
 begin
   OldCW := Default8087CW;
   try
     Set8087CW(RoundUpCW);
     Result := Round(Value);
   finally
     Set8087CW(OldCW);
   end;
 end;
 
 procedure TForm1.Button2Click(Sender: TObject);
 begin
   ShowMessage(FormatFloat('0.00', RoundUp(19.32)));  // - 19 
end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

