---
Title: Линза
Date: 01.01.2007
Source: <https://algolist.manual.ru>
---


Линза
=====

## Реализация 1 - на Паскале.


Если линза на экpане - окpужность (x0,y0,r0), то в точках (x,y), для
котоpых (x-x0)2+(y-y0)2\<=r02,pисуется точка, котоpая, если бы линзы не
было, изобpажалась бы в точке (x0+(x-x0)*k1,y0+(y-y0)*k),
где k=const1 / ([sqrt]((x-x0)2+(y-y0)2) + const2).
Можно заpанее пpосчитать таблицу
смещений - array[-r0..r0,-r0..r0] of integer.

    {$A+,B-,D+,E+,F-,G+,I+,L+,N-,O-,P-,Q-,R-,S+,T-,V+,X+,Y+}
     
    {$M 16384,0,655360}
     
    Uses CRT;
     
    Const vx0 = 3;
          vy0 = 2;
          v0  = vx0;
          r0  = 50;
          r02 = (r0-v0)*(r0-v0);
          d   = r02 * 10 div 10;
    Type ScreenType = Array[0..199,0..319] of Byte;
         DispType   = Array[-r0..r0,-r0..r0] of Integer;
     
    Var
     
        Screen           : ScreenType Absolute $a000:$0000;
        Buffer1, Buffer2 : ^ScreenType;
        Disp             : ^DispType;
        x,y,vx,vy,r2,c   : LongInt;
    Procedure Move(Var A,B; Count: Word);
    assembler;
    asm
            push ds
            mov  cx, Count
            les  di, B
            lds  si, A
            shr  cx, 1
            jz   @zero
            rep  movsw
    @zero:  pop  ds
    end;
    BEGIN
     
     asm
      mov ax, $13
      int $10
     end;
     
     New(Buffer1);
     New(Buffer2);
     New(Disp);
     
     FillChar(Screen, SizeOf(Screen), 3);
     y:=0;
     
     repeat
     
      For x:=0 to 319 do Screen[y,x]:=11;
      Inc(y,10);
     
     until y>199;
     
     x:=0;
     
     repeat
     
      For y:=0 to 199 do Screen[y,x]:=11;
      Inc(x,10);
     
     until x>319;
     
     Move(Screen, Buffer1^, SizeOf(Screen));
     Move(Buffer1^,Screen,64000);
     
     For y:=-r0 to r0 do
     For x:=-r0 to r0 do
      begin
     
      r2:=x*x+y*y;
      if r2>r02 then Disp^[y,x] := y*320+x
       else 
      Disp^[y,x]:=(y*(r2+d)div(r02+d))*320+(x*(r2+d)div(r02+d));
     
      end;
     
     x:=r0;
     y:=r0;
     vx:=vx0;
     vy:=vy0;
     repeat
     
      asm
              mov     ax, Integer(y)
              mov     bx, 320
              imul    bx
              add     ax, Integer(x)
              mov     di, ax
              mov     dx, -r0*320-r0
              les     si, Disp
              mov     ch, 2*r0+1
    @next_dy: mov     cl, 2*r0+1
    @next_dx:
              mov     es, Word(Disp+2)
              mov     bx, es:[si]
              mov     es, Word(Buffer1+2)
              mov     al, es:[di+bx]
              mov     bx, Seg(Screen)
              mov     es, bx
              mov     bx, dx
              mov     es:[di+bx], al
              add     si, 2
              inc     dx
              dec     cl
              jnz     @next_dx
              add     dx, 320-(2*r0+1)
              dec     ch
              jnz     @next_dy
      end;
     
      if ((x+vx)>=r0) and ((x+vx)<=319-r0) then Inc(x, vx)
                                           else vx:=-vx;
     
      if ((y+vy)>=r0) and ((y+vy)<=199-r0) then Inc(y,vy)
                                           else vy:=-vy;
      Delay(25);
     until Port[$60]=$01;
     
     Dispose(Buffer1);
     Dispose(Buffer2);
     Dispose(Disp);
     
     asm
      mov ax, $03
      int $10
     end;
     
    END.

