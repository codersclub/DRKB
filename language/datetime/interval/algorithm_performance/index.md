---
Title: Сравнить быстродействие алгоритмов
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Сравнить быстродействие алгоритмов
==================================

Если вас сколько-нибудь интересует скорость работы вашей программы, то
нужно смерить скорость алгоритмов и сравнивать их. Здесь я привожу
пример, сравнивающий четыре способа возведения 2 в степень 30.

    uses Math;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Res, Exponent: integer;
      Res1: real;
      t, i: integer;
    begin
      Exponent := 30;
     
      Application.ProcessMessages;
      t := GetTickCount;
      for i := 1 to 1000000 do
        Res := 1 shl Exponent;
      Form1.Caption := Form1.Caption + ' ' +
      IntToStr(GetTickCount - t);
     
      Application.ProcessMessages;
      t := GetTickCount;
      for i := 1 to 1000000 do
        Res1 := LdExp(1, Exponent);
      Form1.Caption := Form1.Caption + ' ' +
      IntToStr(GetTickCount - t);
     
      Application.ProcessMessages;
      t := GetTickCount;
      for i := 1 to 1000000 do
        Res1 := IntPower(2, Exponent);
      Form1.Caption := Form1.Caption + ' ' +
      IntToStr(GetTickCount - t);
     
      Application.ProcessMessages;
      t := GetTickCount;
      for i := 1 to 1000000 do
        Res1 := Power(2, Exponent);
      Form1.Caption := Form1.Caption + ' ' +
      IntToStr(GetTickCount - t);
    end; 


