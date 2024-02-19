---
Title: Определить взаиморасположение точки и прямой
Author: Digar
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Определить взаиморасположение точки и прямой
============================================


    {Расчет нормали от точки до линии и расстояния от начала и до конца линии}
    function Dfptl(key:byte;x,y,xn,yn,xk,yk:real):real;//Distance From Point To Line
    Const r0=2*pi;r1=pi;r2=pi/2;r3=3*pi/4;r4=1e-4;
    var
    a,dx,dy:double;
    begin
    dx:=xk-xn;dy:=yk-yn;
    if abs(dx)<r4 then begin if dy>0 then a:=r2 else a:=-r2;end else a:=arctan2(dy,dx);
     Case key of
     0://расстояние от точки до прямой; <0 - точка слева; >0 - точка справа
       Result:=(xn-x)*Sin(a)-(yn-y)*Cos(a);
     1://расстояние от точки до начала линии
       Result:=(x-xn)*Cos(a)+(y-yn)*Sin(a);
     2://проекция точки на направление прямой попадает на нее если Result=0
       Result:=(sqrt(sqr(dx)+sqr(dy))-Abs((xn-x)*Cos(a)+(yn-y)*Sin(a))-Abs((xk-x)*Cos(a)+(yk-y)*Sin(a)));
     3://расстояние от точки до конца линии
       Result:=(x-xk)*Cos(a)+(y-yk)*Sin(a);
     else result:=1e30;
     end;
    if isZero(Result,r4) then Result:=0;
    end;

