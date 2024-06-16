---
Title: Как получить средний цвет между двумя цветами?
Date: 01.01.2007
---


Как получить средний цвет между двумя цветами?
==============================================

Вариант 1:

    function GetColorBetween(StartColor, EndColor: TColor; Pointvalue, Von, Bis:
      Extended): TColor;
    var
      F: Extended;
      r1, r2, r3, g1, g2, g3, b1, b2, b3: Byte;
      function CalcColorBytes(fb1, fb2: Byte): Byte;
      begin
        result := fb1;
        if fb1 < fb2 then
          Result := FB1 + Trunc(F * (fb2 - fb1));
        if fb1 > fb2 then
          Result := FB1 - Trunc(F * (fb1 - fb2));
      end;
    begin
      if Pointvalue <= Von then
      begin
        result := StartColor;
        exit;
      end;
      if Pointvalue >= Bis then
      begin
        result := EndColor;
        exit;
      end;
      F := (Pointvalue - von) / (Bis - Von);
      asm
         mov EAX, Startcolor
         cmp EAX, EndColor
         je @@exit
         mov r1, AL
         shr EAX,8
         mov g1, AL
         shr Eax,8
         mov b1, AL
         mov Eax, Endcolor
         mov r2, AL
         shr EAX,8
         mov g2, AL
         shr EAX,8
         mov b2, AL
         push ebp
         mov al, r1
         mov dl, r2
         call CalcColorBytes
         pop ecx
         push ebp
         Mov r3, al
         mov dL, g2
         mov al, g1
         call CalcColorBytes
         pop ecx
         push ebp
         mov g3, Al
         mov dL, B2
         mov Al, B1
         call CalcColorBytes
         pop ecx
         mov b3, al
         XOR EAX,EAX
         mov AL, B3
         SHL EAX,8
         mov AL, G3
         SHL EAX,8
         mov AL, R3
         @@Exit:
         mov @result, eax
      end;
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Dmitri Papichev

Date: 12.12.2001

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

    //------------------------------------------------------------------------------
    // Function for getting mixed color from two given colors, with a relative
    // distance from two colors determined by Position value inside
    // MinPosition..MaxPosition range
    // Author: Dmitri Papichev (c) 2001
    // License type: Freeware
    //------------------------------------------------------------------------------
     
    function GetMixedColor(const StartColor,
      EndColor: TColor;
      const MinPosition,
      Position,
      MaxPosition: integer): TColor;
    var
      Fraction: double;
      R, G, B,
        R0, G0, B0,
        R1, G1, B1: byte;
    begin
      {process Position out of range situation}
      if (MaxPosition < MinPosition) then
      begin
        raise Exception.Create
          ('GetMixedColor: MaxPosition is less then MinPosition');
      end; {if}
     
      {if Position is outside MinPosition..MaxPosition range, the closest boundary
       is effectively substituted through the adjustment of Fraction}
      Fraction :=
        Min(1, Max(0, (Position - MinPosition) / (MaxPosition - MinPosition)));
     
      {extract the intensity values}
      R0 := GetRValue(StartColor);
      G0 := GetGValue(StartColor);
      B0 := GetBValue(StartColor);
      R1 := GetRValue(EndColor);
      G1 := GetGValue(EndColor);
      B1 := GetBValue(EndColor);
     
      {calculate the resulting intensity values}
      R := R0 + Round((R1 - R0) * Fraction);
      G := G0 + Round((G1 - G0) * Fraction);
      B := B0 + Round((B1 - B0) * Fraction);
     
      {combine intensities in a resulting color}
      Result := RGB(R, G, B);
    end; {--GetMixedColor--}

