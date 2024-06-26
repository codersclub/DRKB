---
Title: Преобразование цвета RGB \<--\> HLS
Date: 01.01.2007
Author: Зайцев О.В., Владимиров А.М.
Source: <https://forum.sources.ru>
---


Преобразование цвета RGB \<--\> HLS
=================================

    {Максимальные значения }
    Const
     HLSMAX = 240;
     RGBMAX = 255;
     UNDEFINED = (HLSMAX*2) div 3;
    Var
     H, L, S  : integer; { H-оттенок, L-яркость, S-насыщенность }
     R, G, B  : integer; { цвета }
     
    procedure RGBtoHLS;
    Var
     cMax,cMin  : integer;
     Rdelta,Gdelta,Bdelta : single;
    Begin
       cMax := max( max(R,G), B);
       cMin := min( min(R,G), B);
       L := round( ( ((cMax+cMin)*HLSMAX) + RGBMAX )/(2*RGBMAX) );
     
       if (cMax = cMin) then begin
          S := 0; H := UNDEFINED;
       end else begin
          if (L <= (HLSMAX/2)) then
             S := round( ( ((cMax-cMin)*HLSMAX) + ((cMax+cMin)/2) ) / (cMax+cMin) )
          else
             S := round( ( ((cMax-cMin)*HLSMAX) + ((2*RGBMAX-cMax-cMin)/2) )
                / (2*RGBMAX-cMax-cMin) );
          Rdelta := ( ((cMax-R)*(HLSMAX/6)) + ((cMax-cMin)/2) ) / (cMax-cMin);
          Gdelta := ( ((cMax-G)*(HLSMAX/6)) + ((cMax-cMin)/2) ) / (cMax-cMin);
          Bdelta := ( ((cMax-B)*(HLSMAX/6)) + ((cMax-cMin)/2) ) / (cMax-cMin);
          if (R = cMax) then H := round(Bdelta - Gdelta)
          else if (G = cMax) then H := round( (HLSMAX/3) + Rdelta - Bdelta)
          else H := round( ((2*HLSMAX)/3) + Gdelta - Rdelta );
          if (H < 0) then H:=H + HLSMAX;
          if (H > HLSMAX) then H:= H - HLSMAX;
       end;
       if S<0 then S:=0; if S>HLSMAX then S:=HLSMAX;
       if L<0 then L:=0; if L>HLSMAX then L:=HLSMAX;
    end;
     
     
    procedure HLStoRGB;
    Var
     Magic1,Magic2 : single;
     
      function HueToRGB(n1,n2,hue : single) : single;
      begin
         if (hue < 0) then hue := hue+HLSMAX;
         if (hue > HLSMAX) then hue:=hue -HLSMAX;
         if (hue < (HLSMAX/6)) then
            result:= ( n1 + (((n2-n1)*hue+(HLSMAX/12))/(HLSMAX/6)) )
         else
         if (hue < (HLSMAX/2)) then result:=n2 else
         if (hue < ((HLSMAX*2)/3)) then
            result:= ( n1 + (((n2-n1)*(((HLSMAX*2)/3)-hue)+(HLSMAX/12))/(HLSMAX/6)))
         else result:= ( n1 );
      end;
     
    begin
       if (S = 0) then begin
          B:=round( (L*RGBMAX)/HLSMAX ); R:=B; G:=B;
       end else begin
          if (L <= (HLSMAX/2)) then Magic2 := (L*(HLSMAX + S) + (HLSMAX/2))/HLSMAX
          else Magic2 := L + S - ((L*S) + (HLSMAX/2))/HLSMAX;
          Magic1 := 2*L-Magic2;
          R := round( (HueToRGB(Magic1,Magic2,H+(HLSMAX/3))*RGBMAX + (HLSMAX/2))/HLSMAX );
          G := round( (HueToRGB(Magic1,Magic2,H)*RGBMAX + (HLSMAX/2)) / HLSMAX );
          B := round( (HueToRGB(Magic1,Magic2,H-(HLSMAX/3))*RGBMAX + (HLSMAX/2))/HLSMAX );
       end;
       if R<0 then R:=0; if R>RGBMAX then R:=RGBMAX;
       if G<0 then G:=0; if G>RGBMAX then G:=RGBMAX;
       if B<0 then B:=0; if B>RGBMAX then B:=RGBMAX;
    end;

