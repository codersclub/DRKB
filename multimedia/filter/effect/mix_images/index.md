---
Title: Смешать два изображения
Author: Вадим Исаенко, http://v-isa.narod.ru
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Смешать два изображения
=======================


Модуль MyGraph.pas включает в себя только одну процедуру, позволяющую
смешать 2 изображения. Такая функция может быть полезна для получения
различных эффектов, а также для нанесения на изображение "водяных
знаков".

    unit MyGraph;
     
    interface
     
    uses Graphics;
     
    procedure MixBMP(BM1, BM2: TBitMap; var BM: TBitMap);
     
    implementation
     
    procedure MixBMP(BM1, BM2: TBitMap; var BM: TBitMap);
    var
      I, J: Integer;
      MinW, MinH: Integer;
    begin
      BM := TBitMap.Create;
      if BM1.Width < BM2.Width then
        MinW := BM1.Width
      else
        MinW := BM2.Width;
      if BM1.Height < BM2.Height then
        MinH := BM1.Height
      else
        MinH := BM2.Height;
      BM.Width := MinW;
      BM.Height := MinH;
      for I := 0 to MinW do
        for J := 0 to MinH do
          if (Odd(I) and Odd(J)) or ((not (Odd(I))) and (not (Odd(J)))) then
            BM.Canvas.Pixels[I, J] := BM1.Canvas.Pixels[I, J]
          else
            BM.Canvas.Pixels[I, J] := BM2.Canvas.Pixels[I, J];
    end;
     
    begin
    end.

