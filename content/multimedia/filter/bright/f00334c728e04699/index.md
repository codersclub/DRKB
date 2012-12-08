---
Title: Изменение контрастности изображения
Date: 01.01.2007
---


Изменение контрастности изображения
===================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Изменение контрастности изображения
     
    Value - значение контрастности на отрезке [-100..100]
    Local - если True, то применяется "местный контраст",
    если False, то - "общий" (более красивый)
     
    Зависимости: Windows
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Николай Федоровских
    Дата:        14 июля 2003 г.
    ***************************************************** }
     
    procedure Contrast(Bitmap: TBitmap; Value: Integer; Local: Boolean);
     
      function BLimit(B: Integer): Byte;
      begin
        if B < 0 then
          Result := 0
        else if B > 255 then
          Result := 255
        else
          Result := B;
      end;
     
    var
      Dest: pRGBTriple;
      x, y, mr, mg, mb,
        W, H, tr, tg, tb: Integer;
      vd: Double;
     
    begin
      if Value = 0 then
        Exit;
      W := Bitmap.Width - 1;
      H := Bitmap.Height - 1;
      if Local then
      begin
        mR := 128;
        mG := 128;
        mB := 128;
      end
      else
      begin
        tr := 0;
        tg := 0;
        tb := 0;
        for y := 0 to H do
        begin
          Dest := Bitmap.ScanLine[y];
          for x := 0 to W do
          begin
            with Dest^ do
            begin
              Inc(tb, rgbtBlue);
              Inc(tg, rgbtGreen);
              Inc(tr, rgbtRed);
            end;
            Inc(Dest);
          end;
        end;
        mB := Trunc(tb / (W * H));
        mG := Trunc(tg / (W * H));
        mR := Trunc(tr / (W * H));
      end;
      if Value > 0 then
        vd := 1 + (Value / 10)
      else
        vd := 1 - (Sqrt(-Value) / 10);
      for y := 0 to H do
      begin
        Dest := Bitmap.ScanLine[y];
        for x := 0 to W do
        begin
          with Dest^ do
          begin
            rgbtBlue := BLimit(mB + Trunc((rgbtBlue - mB) * vd));
            rgbtGreen := BLimit(mG + Trunc((rgbtGreen - mG) * vd));
            rgbtRed := BLimit(mR + Trunc((rgbtRed - mR) * vd));
          end;
          Inc(Dest);
        end;
      end;
    end;
