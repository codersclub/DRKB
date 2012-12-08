---
Title: Как определить, лежит ли точка внутри полигона?
Date: 01.01.2007
---


Как определить, лежит ли точка внутри полигона?
===============================================

::: {.date}
01.01.2007
:::

The main procedure is called ExploreLine. In this procedure Fst and Lst
may be two consecutively points in the polyline. Srch is the point
searched.

    { ... }
    const {global}
      BigM = 1000000;
     
    function Pend(Pi, Pf: TPoint): Real;
    begin
      if (Pf.X = Pi.X) then
        Result := BigM {for a vertical line}
      else
        Result := (Pf.Y - Pi.Y) / (Pf.X - Pi.X);
    end;
     
    function Dist(Pi, Pf: TPoint): Real;
    begin
      Result := sqrt(sqr(Pi.Y - Pf.Y) + sqr(Pi.X - Pf.X))
    end;
     
    function CalcPoint(Pi, Pf: TPoint; d: Word): TPoint;
    var
      k, m: Real; { k=d / (1 + m2)Ѕ }
    begin
      m := Pend(Pi, Pf);
      k := d / (Sqrt(1 + Sqr(m)));
      if ((Pf.X - Pi.X) < 0) then
      begin
        Result.X := Pi.X - Round(k);
        Result.Y := Pi.Y - Round(m * k);
      end
      else
      begin
        Result.X := Pi.X + Round(k);
        Result.Y := Pi.Y + Round(m * k);
      end;
    end;
     
    function ExploreLine(Srch, Fst, Lst: TPoint): Boolean;
    var
      p: Word;
      Any: TPoint;
      lim, dis: Real;
    begin
      lim := Dist(Lst, Fst);
      p := 1;
      Any := Fst;
      repeat
        Result := TestPoint(Srch, Any);
        dis := Dist(Any, Fst);
        Any := CalcPoint(Fst, Lst, Rad * p);
        Inc(p);
      until
        (Result)rr(dis >= lim);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
