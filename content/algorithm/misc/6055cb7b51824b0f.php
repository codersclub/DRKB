<h1>Элементы спектрального анализа (Фурье, Хартман и т.д.)</h1>
<div class="date">01.01.2007</div>


<pre>
{$A+,B-,C+,D+,E-,F-,G+,H+,I+,J+,K-,L+,M-,N+,O-,P+,Q-,R-,S-,T-,U-,V+,W-,X+,Y+,Z1}
{$MINSTACKSIZE $00004000}
{$MAXSTACKSIZE $00100000}
{$IMAGEBASE $00400000}
{$APPTYPE GUI}
 
unit Main;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  Buttons, ExtCtrls, ComCtrls, Menus;
 
type
 
  TfmMain = class(TForm)
    MainMenu1: TMainMenu;
    N1: TMenuItem;
    N2: TMenuItem;
    StatusBar1: TStatusBar;
    N3: TMenuItem;
    imgInfo: TImage;
    Panel1: TPanel;
    btnStart: TSpeedButton;
    procedure btnStartClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  end;
 
var
 
  fmMain: TfmMain;
 
implementation
 
uses PFiles;
 
{$R *.DFM}
 
function Power2(lPower: Byte): LongInt;
 
begin
  Result := 1 shl lPower;
end;
 
procedure ClassicDirect(var aSignal, aSpR, aSpI: array of Double; N:
  LongInt);
 
var lSrch: LongInt;
var lGarm: LongInt;
var dSumR: Double;
var dSumI: Double;
begin
  for lGarm := 0 to N div 2 - 1 do
    begin
      dSumR := 0;
      dSumI := 0;
      for lSrch := 0 to N - 1 do
        begin
          dSumR := dSumR + aSignal[lSrch] * Cos(lGarm * lSrch / N * 2 * PI);
          dSumI := dSumI + aSignal[lSrch] * Sin(lGarm * lSrch / N * 2 * PI);
        end;
      aSpR[lGarm] := dSumR;
      aSpI[lGarm] := dSumI;
    end;
end;
 
procedure ClassicInverce(var aSpR, aSpI, aSignal: array of Double; N:
  LongInt);
 
var lSrch: LongInt;
var lGarm: LongInt;
var dSum: Double;
begin
  for lSrch := 0 to N - 1 do
    begin
      dSum := 0;
      for lGarm := 0 to N div 2 - 1 do
        dSum := dSum
          + aSpR[lGarm] * Cos(lSrch * lGarm * 2 * Pi / N)
          + aSpI[lGarm] * Sin(lSrch * lGarm * 2 * Pi / N);
      aSignal[lSrch] := dSum * 2;
    end;
end;
 
function InvertBits(BF, DataSize, Power: Word): Word;
 
var BR: Word;
var NN: Word;
var L: Word;
begin
  br := 0;
  nn := DataSize;
  for l := 1 to Power do
    begin
      NN := NN div 2;
      if (BF &gt;= NN) then
        begin
          BR := BR + Power2(l - 1);
          BF := BF - NN
        end;
    end;
  InvertBits := BR;
end;
 
procedure FourierDirect(var RealData, VirtData, ResultR, ResultV: array of
  Double; DataSize: LongInt);
 
var A1: Real;
var A2: Real;
var B1: Real;
var B2: Real;
var D2: Word;
var C2: Word;
var C1: Word;
var D1: Word;
var I: Word;
var J: Word;
var K: Word;
var Cosin: Real;
var Sinus: Real;
var wIndex: Word;
var Power: Word;
begin
  C1 := DataSize shr 1;
  C2 := 1;
  for Power := 0 to 15 //hope it will be faster then
    round(ln(DataSize) / ln(2)) do
    if Power2(Power) = DataSize then Break;
  for I := 1 to Power do
    begin
      D1 := 0;
      D2 := C1;
      for J := 1 to C2 do
        begin
          wIndex := InvertBits(D1 div C1, DataSize, Power);
          Cosin := +(Cos((2 * Pi / DataSize) * wIndex));
          Sinus := -(Sin((2 * Pi / DataSize) * wIndex));
          for K := D1 to D2 - 1 do
            begin
              A1 := RealData[K];
              A2 := VirtData[K];
              B1 := ((Cosin * RealData[K + C1] - Sinus * VirtData[K + C1]));
              B2 := ((Sinus * RealData[K + C1] + Cosin * VirtData[K + C1]));
              RealData[K] := A1 + B1;
              VirtData[K] := A2 + B2;
              RealData[K + C1] := A1 - B1;
              VirtData[K + C1] := A2 - B2;
            end;
          Inc(D1, C1 * 2);
          Inc(D2, C1 * 2);
        end;
      C1 := C1 div 2;
      C2 := C2 * 2;
    end;
  for I := 0 to DataSize div 2 - 1 do
    begin
      ResultR[I] := +RealData[InvertBits(I, DataSize, Power)];
      ResultV[I] := -VirtData[InvertBits(I, DataSize, Power)];
    end;
end;
 
procedure Hartley(iSize: LongInt; var aData: array of Double);
 
type taDouble = array[0..MaxLongInt div SizeOf(Double) - 1] of Double;
var prFI, prFN, prGI: ^taDouble;
var rCos, rSin: Double;
var rA, rB, rTemp: Double;
var rC1, rC2, rC3, rC4: Double;
var rS1, rS2, rS3, rS4: Double;
var rF0, rF1, rF2, rF3: Double;
var rG0, rG1, rG2, rG3: Double;
var iK1, iK2, iK3, iK4: LongInt;
var iSrch, iK, iKX: LongInt;
begin
  iK2 := 0;
  for iK1 := 1 to iSize - 1 do
    begin
      iK := iSize shr 1;
      repeat
        iK2 := iK2 xor iK;
        if (iK2 and iK) &lt;&gt; 0 then Break;
        iK := iK shr 1;
      until False;
      if iK1 &gt; iK2 then
        begin
          rTemp := aData[iK1];
          aData[iK1] := aData[iK2];
          aData[iK2] := rTemp;
        end;
    end;
  iK := 0;
  while (1 shl iK) &lt; iSize do
    Inc(iK);
  iK := iK and 1;
  if iK = 0 then
    begin
      prFI := @aData;
      prFN := @aData;
      prFN := @prFN[iSize];
      while Word(prFI) &lt; Word(prFN) do
        begin
          rF1 := prFI^[0] - prFI^[1];
          rF0 := prFI^[0] + prFI^[1];
          rF3 := prFI^[2] - prFI^[3];
          rF2 := prFI^[2] + prFI^[3];
          prFI^[2] := rF0 - rF2;
          prFI^[0] := rF0 + rF2;
          prFI^[3] := rF1 - rF3;
          prFI^[1] := rF1 + rF3;
          prFI := @prFI[4];
        end;
    end
  else
    begin
      prFI := @aData;
      prFN := @aData;
      prFN := @prFN[iSize];
      prGI := prFI;
      prGI := @prGI[1];
      while Word(prFI) &lt; Word(prFN) do
        begin
          rC1 := prFI^[0] - prGI^[0];
          rS1 := prFI^[0] + prGI^[0];
          rC2 := prFI^[2] - prGI^[2];
          rS2 := prFI^[2] + prGI^[2];
          rC3 := prFI^[4] - prGI^[4];
          rS3 := prFI^[4] + prGI^[4];
          rC4 := prFI^[6] - prGI^[6];
          rS4 := prFI^[6] + prGI^[6];
          rF1 := rS1 - rS2;
          rF0 := rS1 + rS2;
          rG1 := rC1 - rC2;
          rG0 := rC1 + rC2;
          rF3 := rS3 - rS4;
          rF2 := rS3 + rS4;
          rG3 := Sqrt(2) * rC4;
          rG2 := Sqrt(2) * rC3;
          prFI^[4] := rF0 - rF2;
          prFI^[0] := rF0 + rF2;
          prFI^[6] := rF1 - rF3;
          prFI^[2] := rF1 + rF3;
          prGI^[4] := rG0 - rG2;
          prGI^[0] := rG0 + rG2;
          prGI^[6] := rG1 - rG3;
          prGI^[2] := rG1 + rG3;
          prFI := @prFI[8];
          prGI := @prGI[8];
        end;
    end;
  if iSize &lt; 16 then Exit;
  repeat
    Inc(iK, 2);
    iK1 := 1 shl iK;
    iK2 := iK1 shl 1;
    iK4 := iK2 shl 1;
    iK3 := iK2 + iK1;
    iKX := iK1 shr 1;
    prFI := @aData;
    prGI := prFI;
    prGI := @prGI[iKX];
    prFN := @aData;
    prFN := @prFN[iSize];
    repeat
      rF1 := prFI^[000] - prFI^[iK1];
      rF0 := prFI^[000] + prFI^[iK1];
      rF3 := prFI^[iK2] - prFI^[iK3];
      rF2 := prFI^[iK2] + prFI^[iK3];
      prFI^[iK2] := rF0 - rF2;
      prFI^[000] := rF0 + rF2;
      prFI^[iK3] := rF1 - rF3;
      prFI^[iK1] := rF1 + rF3;
      rG1 := prGI^[0] - prGI^[iK1];
      rG0 := prGI^[0] + prGI^[iK1];
      rG3 := Sqrt(2) * prGI^[iK3];
      rG2 := Sqrt(2) * prGI^[iK2];
      prGI^[iK2] := rG0 - rG2;
      prGI^[000] := rG0 + rG2;
      prGI^[iK3] := rG1 - rG3;
      prGI^[iK1] := rG1 + rG3;
      prGI := @prGI[iK4];
      prFI := @prFI[iK4];
    until not (Word(prFI) &lt; Word(prFN));
    rCos := Cos(Pi / 2 / Power2(iK));
    rSin := Sin(Pi / 2 / Power2(iK));
    rC1 := 1;
    rS1 := 0;
    for iSrch := 1 to iKX - 1 do
      begin
        rTemp := rC1;
        rC1 := (rTemp * rCos - rS1 * rSin);
        rS1 := (rTemp * rSin + rS1 * rCos);
        rC2 := (rC1 * rC1 - rS1 * rS1);
        rS2 := (2 * (rC1 * rS1));
        prFN := @aData;
        prFN := @prFN[iSize];
        prFI := @aData;
        prFI := @prFI[iSrch];
        prGI := @aData;
        prGI := @prGI[iK1 - iSrch];
        repeat
          rB := (rS2 * prFI^[iK1] - rC2 * prGI^[iK1]);
          rA := (rC2 * prFI^[iK1] + rS2 * prGI^[iK1]);
          rF1 := prFI^[0] - rA;
          rF0 := prFI^[0] + rA;
          rG1 := prGI^[0] - rB;
          rG0 := prGI^[0] + rB;
          rB := (rS2 * prFI^[iK3] - rC2 * prGI^[iK3]);
          rA := (rC2 * prFI^[iK3] + rS2 * prGI^[iK3]);
          rF3 := prFI^[iK2] - rA;
          rF2 := prFI^[iK2] + rA;
          rG3 := prGI^[iK2] - rB;
          rG2 := prGI^[iK2] + rB;
          rB := (rS1 * rF2 - rC1 * rG3);
          rA := (rC1 * rF2 + rS1 * rG3);
          prFI^[iK2] := rF0 - rA;
          prFI^[0] := rF0 + rA;
          prGI^[iK3] := rG1 - rB;
          prGI^[iK1] := rG1 + rB;
          rB := (rC1 * rG2 - rS1 * rF3);
          rA := (rS1 * rG2 + rC1 * rF3);
          prGI^[iK2] := rG0 - rA;
          prGI^[0] := rG0 + rA;
          prFI^[iK3] := rF1 - rB;
          prFI^[iK1] := rF1 + rB;
          prGI := @prGI[iK4];
          prFI := @prFI[iK4];
        until not (LongInt(prFI) &lt; LongInt(prFN));
      end;
  until not (iK4 &lt; iSize);
end;
 
procedure HartleyDirect(
  var aData: array of Double;
 
  iSize: LongInt);
var rA, rB: Double;
var iI, iJ, iK: LongInt;
begin
  Hartley(iSize, aData);
  iJ := iSize - 1;
  iK := iSize div 2;
  for iI := 1 to iK - 1 do
    begin
      rA := aData[ii];
      rB := aData[ij];
      aData[iJ] := (rA - rB) / 2;
      aData[iI] := (rA + rB) / 2;
      Dec(iJ);
    end;
end;
 
procedure HartleyInverce(
  var aData: array of Double;
 
  iSize: LongInt);
 
var rA, rB: Double;
var iI, iJ, iK: LongInt;
begin
  iJ := iSize - 1;
  iK := iSize div 2;
  for iI := 1 to iK - 1 do
    begin
      rA := aData[iI];
      rB := aData[iJ];
      aData[iJ] := rA - rB;
      aData[iI] := rA + rB;
      Dec(iJ);
    end;
  Hartley(iSize, aData);
end;
 
//not tested
 
procedure HartleyDirectComplex(real, imag: array of Double; n: LongInt);
var a, b, c, d: double;
 
  q, r, s, t: double;
  i, j, k: LongInt;
begin
 
  j := n - 1;
  k := n div 2;
  for i := 1 to k - 1 do
    begin
      a := real[i]; b := real[j]; q := a + b; r := a - b;
      c := imag[i]; d := imag[j]; s := c + d; t := c - d;
      real[i] := (q + t) * 0.5; real[j] := (q - t) * 0.5;
      imag[i] := (s - r) * 0.5; imag[j] := (s + r) * 0.5;
      dec(j);
    end;
  Hartley(N, Real);
  Hartley(N, Imag);
end;
 
//not tested
 
procedure HartleyInverceComplex(real, imag: array of Double; N: LongInt);
var a, b, c, d: double;
 
  q, r, s, t: double;
  i, j, k: longInt;
begin
  Hartley(N, real);
  Hartley(N, imag);
  j := n - 1;
  k := n div 2;
  for i := 1 to k - 1 do
    begin
      a := real[i]; b := real[j]; q := a + b; r := a - b;
      c := imag[i]; d := imag[j]; s := c + d; t := c - d;
      imag[i] := (s + r) * 0.5; imag[j] := (s - r) * 0.5;
      real[i] := (q - t) * 0.5; real[j] := (q + t) * 0.5;
      dec(j);
    end;
end;
 
procedure DrawSignal(var aSignal: array of Double; N, lColor: LongInt);
 
var lSrch: LongInt;
var lHalfHeight: LongInt;
begin
  with fmMain do
    begin
      lHalfHeight := imgInfo.Height div 2;
      imgInfo.Canvas.MoveTo(0, lHalfHeight);
      imgInfo.Canvas.Pen.Color := lColor;
      for lSrch := 0 to N - 1 do
        begin
          imgInfo.Canvas.LineTo(lSrch, Round(aSignal[lSrch]) + lHalfHeight);
        end;
      imgInfo.Repaint;
    end;
end;
 
procedure DrawSpector(var aSpR, aSpI: array of Double; N, lColR, lColI:
  LongInt);
 
var lSrch: LongInt;
var lHalfHeight: LongInt;
begin
  with fmMain do
    begin
      lHalfHeight := imgInfo.Height div 2;
      for lSrch := 0 to N div 2 do
        begin
          imgInfo.Canvas.Pixels[lSrch, Round(aSpR[lSrch] / N) + lHalfHeight] :=
            lColR;
 
          imgInfo.Canvas.Pixels[lSrch + N div 2, Round(aSpI[lSrch] / N) +
            lHalfHeight] := lColI;
 
        end;
      imgInfo.Repaint;
    end;
end;
 
const N = 512;
var aSignalR: array[0..N - 1] of Double; //
var aSignalI: array[0..N - 1] of Double; //
var aSpR, aSpI: array[0..N div 2 - 1] of Double; //
var lFH: LongInt;
 
procedure TfmMain.btnStartClick(Sender: TObject);
 
const Epsilon = 0.00001;
var lSrch: LongInt;
var aBuff: array[0..N - 1] of ShortInt;
begin
  if lFH &gt; 0 then
    begin
//   Repeat
 
      if F.Read(lFH, @aBuff, N) &lt;&gt; N then
        begin
          Exit;
        end;
      for lSrch := 0 to N - 1 do
        begin
          aSignalR[lSrch] := ShortInt(aBuff[lSrch] + $80);
          aSignalI[lSrch] := 0;
        end;
 
      imgInfo.Canvas.Rectangle(0, 0, imgInfo.Width, imgInfo.Height);
      DrawSignal(aSignalR, N, $D0D0D0);
 
//    ClassicDirect(aSignalR, aSpR, aSpI, N);                 //result in aSpR &amp; aSpI,
      aSignal unchanged
//    FourierDirect(aSignalR, aSignalI, aSpR, aSpI, N);       //result in aSpR &amp;
      aSpI, aSiggnalR &amp; aSignalI modified
 
      HartleyDirect(aSignalR, N); //result in source aSignal ;-)
 
      DrawSpector(aSignalR, aSignalR[N div 2 - 1], N, $80, $8000);
      DrawSpector(aSpR, aSpI, N, $80, $8000);
 
{    for lSrch := 0 to N div 2 -1 do begin                    //comparing classic &amp; Hartley
 
if (Abs(aSpR[lSrch] - aSignal[lSrch]) &gt; Epsilon)
or ((lSrch &gt; 0) And (Abs(aSpI[lSrch] - aSignal[N - lSrch]) &gt; Epsilon))
then MessageDlg('Error comparing',mtError,[mbOK],-1);
end;}
 
      HartleyInverce(aSignalR, N); //to restore original signal with
      HartleyDirect
//    ClassicInverce(aSpR, aSpI, aSignalR, N);                //to restore original
      signal with ClassicDirect or FourierDirect
 
      for lSrch := 0 to N - 1 do
        aSignalR[lSrch] := aSignalR[lSrch] / N; //scaling
 
      DrawSignal(aSignalR, N, $D00000);
      Application.ProcessMessages;
//   Until False;
 
    end;
end;
 
procedure TfmMain.FormCreate(Sender: TObject);
 
begin
  lFH := F.Open('input.pcm', ForRead);
end;
 
procedure TfmMain.FormClose(Sender: TObject; var Action: TCloseAction);
 
begin
  F.Close(lFH);
end;
 
end.
</pre>

<p>Denis Furman [000705</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

<hr />Привожу FFT-алгоритм, позволяющий оперировать 256 точками данных примерно за 0.008 секунд на P66 (с 72MB, YMMV). Создан на Delphi.</p>

<p>Данный алгоритм я воспроизвел где-то около года назад. Вероятно он не самый оптимальный, но для повышения скорости расчета наверняка потребуются более мощное аппаратное обеспечение.</p>

<p>Но я не думаю что алгоритм слишком плох, в нем заложено немало математических трюков. Имеется некоторое количество рекурсий, но они занимается не копированием данных, а манипуляциями с указателями, если у нас есть массив размером N = 2^d, то глубина рекурсии составит всего d. Возможно имело бы смысл применить развертывающуюся рекурсию, но не пока не ясно, поможет ли ее применение в данном алгоритме. (Но вероятно мы смогли бы достаточно легко получить надежную математическую модель, развертывая в рекурсии один или два нижних слоя, то есть проще говоря:</p>


<p>if Depth &lt; 2 then</p>
<p>  {производим какие-либо действия}</p>


<p>вместо текущего 'if Depth = 0 then...' Это должно устранить непродуктивные вызовы функций, что несомненно хорошо в то время, пока развертывающая рекурсия работает с ресурсами.)</p>

<p>Имеется поиск с применением таблиц синусов и косинусов; здесь использован метод золотой середины: данный алгоритм весьма трудоемок, но дает отличные результаты при использовании малых и средних массивов.</p>

<p>Вероятно в машине с большим объемом оперативной памяти следует использовать VirtualAlloc(... PAGE_NOCACHE) для Src, Dest и таблиц поиска.</p>

<p>Если кто-либо обнаружит неверную на ваш взгляд или просто непонятную в данном совете функцию пожалуйста сообщите мне об этом.</p>

<p>Что делает данная технология вкратце. Имеется несколько FFT, образующих 'комплексный FT', который понимает и о котором заботится моя технология. Это означает, что если N = 2^d, Src^ и Dest^ образуют массив из N TComplexes, происходит вызов</p>


<p>FFT(d, Src, Dest)</p>


<p>, далее заполняем Dest с применением 'комплексного FT' после того, как результат вызова Dest^[j] будет равен</p>


<p>1/sqrt(N) * Sum(k=0.. N - 1 ; EiT(2*Pi(j*k/N)) * Src^[k])</p>


<p>, где EiT(t) = cos(t) + i sin(t) . То есть, стандартное преобразование Фурье.</p>

<p>Публикую две версии: в первой версии я использую TComplex с функциями для работы с комплексными числами. Во второй версии все числа реальные - вместо массивов Src и Dest мы используем массивы реальных чисел SrcR, SrcI, DestR, DestI (в блоке вычислений реальных чисел), и вызовы всех функций осуществляются линейно. Первая версия достаточна легка в реализации, зато вторая - значительно быстрее. (Обе версии оперируют 'комплексными FFT'.) Технология работы была опробована на алгоритме Plancherel (также известным как Parseval). Обе версии работоспособны, btw: если это не работает у вас - значит я что-то выбросил вместе со своими глупыми коментариями :-) Итак, сложная версия:</p>

<pre>
unit cplx;
 
interface
 
type
 
  PReal = ^TReal;
  TReal = extended;
 
  PComplex = ^TComplex;
  TComplex = record
    r: TReal;
    i: TReal;
  end;
 
function MakeComplex(x, y: TReal): TComplex;
function Sum(x, y: TComplex): TComplex;
function Difference(x, y: TComplex): TComplex;
function Product(x, y: TComplex): TComplex;
function TimesReal(x: TComplex; y: TReal): TComplex;
function PlusReal(x: TComplex; y: TReal): TComplex;
function EiT(t: TReal): TComplex;
function ComplexToStr(x: TComplex): string;
function AbsSquared(x: TComplex): TReal;
 
implementation
 
uses SysUtils;
 
function MakeComplex(x, y: TReal): TComplex;
begin
 
  with result do
  begin
    r := x;
    i := y;
  end;
end;
 
function Sum(x, y: TComplex): TComplex;
begin
  with result do
  begin
 
    r := x.r + y.r;
    i := x.i + y.i;
  end;
end;
 
function Difference(x, y: TComplex): TComplex;
begin
  with result do
  begin
 
    r := x.r - y.r;
    i := x.i - y.i;
  end;
end;
 
function EiT(t: TReal): TComplex;
begin
  with result do
  begin
 
    r := cos(t);
    i := sin(t);
  end;
end;
 
function Product(x, y: TComplex): TComplex;
begin
  with result do
  begin
 
    r := x.r * y.r - x.i * y.i;
    i := x.r * y.i + x.i * y.r;
  end;
end;
 
function TimesReal(x: TComplex; y: TReal): TComplex;
begin
  with result do
  begin
 
    r := x.r * y;
    i := x.i * y;
  end;
end;
 
function PlusReal(x: TComplex; y: TReal): TComplex;
begin
  with result do
  begin
 
    r := x.r + y;
    i := x.i;
  end;
end;
 
function ComplexToStr(x: TComplex): string;
begin
  result := FloatToStr(x.r)
    + ' + '
    + FloatToStr(x.i)
    + 'i';
end;
 
function AbsSquared(x: TComplex): TReal;
begin
  result := x.r * x.r + x.i * x.i;
end;
 
end.
 
</pre>


<pre>
unit cplxfft1;
 
interface
 
uses Cplx;
 
type
  PScalar = ^TScalar;
  TScalar = TComplex; {Легко получаем преобразование в реальную величину}
 
  PScalars = ^TScalars;
  TScalars = array[0..High(integer) div SizeOf(TScalar) - 1]
    of TScalar;
 
const
  TrigTableDepth: word = 0;
  TrigTable: PScalars = nil;
 
procedure InitTrigTable(Depth: word);
 
procedure FFT(Depth: word;
  Src: PScalars;
  Dest: PScalars);
 
{Перед вызовом Src и Dest ТРЕБУЕТСЯ распределение
(integer(1) shl Depth) * SizeOf(TScalar)
байт памяти!}
 
implementation
 
procedure DoFFT(Depth: word;
  Src: PScalars;
  SrcSpacing: word;
  Dest: PScalars);
{рекурсивная часть, вызываемая при готовности FFT}
var
  j, N: integer;
  Temp: TScalar;
  Shift: word;
begin
  if Depth = 0 then
  begin
    Dest^[0] := Src^[0];
    exit;
  end;
 
  N := integer(1) shl (Depth - 1);
 
  DoFFT(Depth - 1, Src, SrcSpacing * 2, Dest);
  DoFFT(Depth - 1, @Src^[SrcSpacing], SrcSpacing * 2, @Dest^[N]);
 
  Shift := TrigTableDepth - Depth;
 
  for j := 0 to N - 1 do
  begin
    Temp := Product(TrigTable^[j shl Shift],
      Dest^[j + N]);
    Dest^[j + N] := Difference(Dest^[j], Temp);
    Dest^[j] := Sum(Dest^[j], Temp);
  end;
end;
 
procedure FFT(Depth: word;
  Src: PScalars;
  Dest: PScalars);
var
  j, N: integer;
  Normalizer: extended;
begin
  N := integer(1) shl depth;
  if Depth TrigTableDepth then
    InitTrigTable(Depth);
  DoFFT(Depth, Src, 1, Dest);
  Normalizer := 1 / sqrt(N);
  for j := 0 to N - 1 do
    Dest^[j] := TimesReal(Dest^[j], Normalizer);
end;
 
procedure InitTrigTable(Depth: word);
var
  j, N: integer;
begin
  N := integer(1) shl depth;
  ReAllocMem(TrigTable, N * SizeOf(TScalar));
  for j := 0 to N - 1 do
 
    TrigTable^[j] := EiT(-(2 * Pi) * j / N);
  TrigTableDepth := Depth;
end;
 
initialization
  ;
 
finalization
  ReAllocMem(TrigTable, 0);
 
end.
</pre>



<pre>
unit DemoForm;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls;
 
type
 
  TForm1 = class(TForm)
    Button1: TButton;
    Memo1: TMemo;
    Edit1: TEdit;
    Label1: TLabel;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
 
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
uses cplx, cplxfft1, MMSystem;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  j: integer;
  s: string;
 
  src, dest: PScalars;
  norm: extended;
  d, N, count: integer;
  st, et: longint;
begin
 
  d := StrToIntDef(edit1.text, -1);
  if d &lt; 1 then
    raise
      exception.Create('глубина рекурсии должны быть положительным целым числом');
 
  N := integer(1) shl d;
 
  GetMem(Src, N * Sizeof(TScalar));
  GetMem(Dest, N * SizeOf(TScalar));
 
  for j := 0 to N - 1 do
  begin
    src^[j] := MakeComplex(random, random);
  end;
 
  begin
 
    st := timeGetTime;
    FFT(d, Src, dest);
    et := timeGetTime;
 
  end;
 
  Memo1.Lines.Add('N = ' + IntToStr(N));
  Memo1.Lines.Add('норма ожидания: ' + #9 + FloatToStr(N * 2 / 3));
 
  norm := 0;
  for j := 0 to N - 1 do
    norm := norm + AbsSquared(src^[j]);
  Memo1.Lines.Add('Норма данных: ' + #9 + FloatToStr(norm));
  norm := 0;
  for j := 0 to N - 1 do
    norm := norm + AbsSquared(dest^[j]);
  Memo1.Lines.Add('Норма FT: ' + #9#9 + FloatToStr(norm));
 
  Memo1.Lines.Add('Время расчета FFT: ' + #9
    + inttostr(et - st)
    + ' мс.');
  Memo1.Lines.Add(' ');
 
  FreeMem(Src);
  FreeMem(DEst);
end;
 
end.
</pre>





<p>**** Версия для работы с реальными числами:</p>

<pre>
unit cplxfft2;
 
interface
 
type
 
  PScalar = ^TScalar;
  TScalar = extended;
 
  PScalars = ^TScalars;
  TScalars = array[0..High(integer) div SizeOf(TScalar) - 1]
    of TScalar;
 
const
 
  TrigTableDepth: word = 0;
  CosTable: PScalars = nil;
  SinTable: PScalars = nil;
 
procedure InitTrigTables(Depth: word);
 
procedure FFT(Depth: word;
 
  SrcR, SrcI: PScalars;
  DestR, DestI: PScalars);
 
{Перед вызовом Src и Dest ТРЕБУЕТСЯ распределение
 
(integer(1) shl Depth) * SizeOf(TScalar)
 
байт памяти!}
 
implementation
 
procedure DoFFT(Depth: word;
 
  SrcR, SrcI: PScalars;
  SrcSpacing: word;
  DestR, DestI: PScalars);
{рекурсивная часть, вызываемая при готовности FFT}
var
  j, N: integer;
 
  TempR, TempI: TScalar;
  Shift: word;
  c, s: extended;
begin
  if Depth = 0 then
 
  begin
    DestR^[0] := SrcR^[0];
    DestI^[0] := SrcI^[0];
    exit;
  end;
 
  N := integer(1) shl (Depth - 1);
 
  DoFFT(Depth - 1, SrcR, SrcI, SrcSpacing * 2, DestR, DestI);
  DoFFT(Depth - 1,
 
    @SrcR^[srcSpacing],
    @SrcI^[SrcSpacing],
    SrcSpacing * 2,
    @DestR^[N],
    @DestI^[N]);
 
  Shift := TrigTableDepth - Depth;
 
  for j := 0 to N - 1 do
  begin
 
    c := CosTable^[j shl Shift];
    s := SinTable^[j shl Shift];
 
    TempR := c * DestR^[j + N] - s * DestI^[j + N];
    TempI := c * DestI^[j + N] + s * DestR^[j + N];
 
    DestR^[j + N] := DestR^[j] - TempR;
    DestI^[j + N] := DestI^[j] - TempI;
 
    DestR^[j] := DestR^[j] + TempR;
    DestI^[j] := DestI^[j] + TempI;
  end;
 
end;
 
procedure FFT(Depth: word;
 
  SrcR, SrcI: PScalars;
  DestR, DestI: PScalars);
var
  j, N: integer;
  Normalizer: extended;
begin
 
  N := integer(1) shl depth;
 
  if Depth TrigTableDepth then
 
    InitTrigTables(Depth);
 
  DoFFT(Depth, SrcR, SrcI, 1, DestR, DestI);
 
  Normalizer := 1 / sqrt(N);
 
  for j := 0 to N - 1 do
 
  begin
    DestR^[j] := DestR^[j] * Normalizer;
    DestI^[j] := DestI^[j] * Normalizer;
  end;
 
end;
 
procedure InitTrigTables(Depth: word);
var
  j, N: integer;
begin
 
  N := integer(1) shl depth;
  ReAllocMem(CosTable, N * SizeOf(TScalar));
  ReAllocMem(SinTable, N * SizeOf(TScalar));
  for j := 0 to N - 1 do
 
  begin
    CosTable^[j] := cos(-(2 * Pi) * j / N);
    SinTable^[j] := sin(-(2 * Pi) * j / N);
  end;
  TrigTableDepth := Depth;
 
end;
 
initialization
 
  ;
 
finalization
 
  ReAllocMem(CosTable, 0);
  ReAllocMem(SinTable, 0);
 
end.
</pre>

<pre>
unit demofrm;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics,
  Controls, Forms, Dialogs, cplxfft2, StdCtrls;
 
type
 
  TForm1 = class(TForm)
    Button1: TButton;
    Memo1: TMemo;
    Edit1: TEdit;
    Label1: TLabel;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
 
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
uses MMSystem;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  SR, SI, DR, DI: PScalars;
  j, d, N: integer;
  st, et: longint;
  norm: extended;
begin
 
  d := StrToIntDef(edit1.text, -1);
  if d &lt; 1 then
    raise
      exception.Create('глубина рекурсии должны быть положительным целым числом');
 
  N := integer(1) shl d;
 
  GetMem(SR, N * SizeOf(TScalar));
  GetMem(SI, N * SizeOf(TScalar));
  GetMem(DR, N * SizeOf(TScalar));
  GetMem(DI, N * SizeOf(TScalar));
 
  for j := 0 to N - 1 do
  begin
 
    SR^[j] := random;
    SI^[j] := random;
  end;
 
  st := timeGetTime;
  FFT(d, SR, SI, DR, DI);
 
  et := timeGetTime;
 
  memo1.Lines.Add('N = ' + inttostr(N));
  memo1.Lines.Add('норма ожидания: ' + #9 + FloatToStr(N * 2 / 3));
 
  norm := 0;
  for j := 0 to N - 1 do
 
    norm := norm + SR^[j] * SR^[j] + SI^[j] * SI^[j];
  memo1.Lines.Add('норма данных: ' + #9 + FloatToStr(norm));
 
  norm := 0;
  for j := 0 to N - 1 do
 
    norm := norm + DR^[j] * DR^[j] + DI^[j] * DI^[j];
  memo1.Lines.Add('норма FT: ' + #9#9 + FloatToStr(norm));
 
  memo1.Lines.Add('Время расчета FFT: ' + #9 + inttostr(et - st));
  memo1.Lines.add('');
  (*for j:=0 to N - 1 do
 
  Memo1.Lines.Add(FloatToStr(SR^[j])
  + ' + '
  + FloatToStr(SI^[j])
  + 'i');
 
  for j:=0 to N - 1 do
 
  Memo1.Lines.Add(FloatToStr(DR^[j])
  + ' + '
  + FloatToStr(DI^[j])
  + 'i');*)
 
  FreeMem(SR, N * SizeOf(TScalar));
  FreeMem(SI, N * SizeOf(TScalar));
  FreeMem(DR, N * SizeOf(TScalar));
  FreeMem(DI, N * SizeOf(TScalar));
end;
 
end.
</pre>



<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

