---
Title: Алгоритм пламени
Date: 01.01.2007
---


Алгоритм пламени
================

Заведем два массива 1 и 2 - один массив будет содержать текущий кадр
пламени,а во второй мы будем заносить результаты вычислений. Создадим
палитру пламени от 250 до 100 это будет сплошной белый цвет - пламя в
очаге. Далее белый, плавно проходя через желтый, перейдет в красный и
черный. Эту палитру можете посмотреть если определен Debug.

В чем состоит основа алгоритма - для каждой точки из массива 1, мы
делаем следующее : берем сумму всех окружающих ее точек и делим на их
количество. Для хорошего качества точек берем 8. Что же получается? Если
очаг пламени организовать внизу, т.е. внизу на каждом шаге случайно
ставить точки с большим значением, усреденные суммы дадут нужное
затухание. Т.к. мы ставим в очаге точки случайно, то появляются
красивые языки.

Последовательность действий:

- Массив 1 содержит текущий кадр пламени.

- Создаем в массиве 1 внизу случайные очаги ( просто ставим точки)

- Каждый элемент массива 2 получаем как усреденную сумму, соответствующих элементов окружающий данный в массиве 1

- Массив 2 копируем на экран

- Переносим массив 2 в массив 1

- Переход на начало

Для программы требуется модуль demovga.pas

    {.$DEFINE DEBUG} 
    Program Fire; 
     
    Uses DemoVga,Crt; 
     
    Type 
       PFireMem = ^TFireMem; 
       TFireMem = Array[0..201,0..319] Of Byte; 
    Var 
       FireMem        : PFireMem; 
       I,J            : Integer; 
       R,G,B,dR,dG,dB : Real; 
     
    Procedure PlotFireHead; 
    Var 
      I : Integer; 
    Begin 
     For I := 0 To 319 Do 
      If Random( 2) = 1 Then Begin 
       FireMem^[ 199] [ I] := 255; 
       FireMem^[ 198] [ I] := 255; 
      End; 
    End; 
     
    Procedure FireLoop; Assembler; 
    Asm 
       Push    DS 
       Les           DI,DBuffer 
       Lds           SI,FireMem 
       Add           SI,320*2 
       Mov           CX,64000 
    @@F: 
       Xor           AX,AX 
       Add           AL,[SI-321] 
       Adc           AH,0 
       Add           AL,[SI-320] 
       Adc           AH,0 
       Add           AL,[SI-319] 
       Adc           AH,0 
       Add           AL,[SI-1] 
       Adc           AH,0 
       Add           AL,[SI+1] 
       Adc           AH,0 
       Add           AL,[SI+319] 
       Adc           AH,0 
       Add           AL,[SI+320] 
       Adc           AH,0 
       Add           AL,[SI+321] 
       Adc           AH,0 
       Shr           AX,3 
       Or           AL,AL 
       Jz           @@1 
       Dec           AL 
    @@1: 
       Stosb 
       Inc           SI 
       Loop    @@F 
       Pop           DS 
    End; 
     
    Begin 
     InitDemoPart; 
     GetMem( FireMem, 65000); 
     R := 0; G := 0; B := 0; 
     dR := 0.63; dG := 0.91; dB := 1.5; 
     For I := 1 To 100 Do Begin 
      SetRGBColor( I, Round( R), Round( G), Round( B)); 
      R := R + dR; 
      If I > 30 Then G := G + dG; 
      If I > 60 Then B := B + dB; 
     End; 
     For I := 100 To 250 Do SetRGBColor( I, 60, 60, 60); 
    {$IFDEF DEBUG} 
     For I := 1 To 100 Do 
      For J := 1 To 100 Do 
       Mem[$A000: J * 320 + I] := I; 
     ReadKey; 
    {$ENDIF} 
     FillChar( FireMem^, 65000, 0); 
     Repeat 
      PlotFireHead; 
      FireLoop; 
      Move( DBuffer^, FireMem^, 64000); 
      Move( DBuffer^, Ptr( $A000, 0)^, 64000-320*4); 
     Until KeyPressed; 
     ReadKey; 
     FreeMem( FireMem, 65000); 
     RestoreDemo; 
    End; 
