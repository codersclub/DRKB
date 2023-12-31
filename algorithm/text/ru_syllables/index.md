---
Title: Алгоритм переноса русского текста по слогам
Date: 01.01.2007
---


Алгоритм переноса русского текста по слогам
===========================================

::: {.date}
01.01.2007
:::

    interface
     
    uses
      Windows,Classes,SysUtils;
     
    Function SetHyph(pc:PChar;MaxSize:Integer):PChar;
    Function SetHyphString(s : String):String;
    Function MayBeHyph(p:PChar;pos:Integer):Boolean;
     
    implementation
     
     
    Type
      TSymbol=(st_Empty,st_NoDefined,st_Glas,st_Sogl,st_Spec);
      TSymbAR=array [0..1000] of TSymbol;
      PSymbAr=^TSymbAr;
     
    Const
        HypSymb=#$1F;
     
       Spaces=[' ', ',',';', ':','.','?','!','/', #10, #13 ];
     
        GlasCHAR=['?', 'L', 'х', '+', 'v', '-','р', '-', 'ю', '+', ' ', '-',
     
                  'ш', 'L', '¦', '¦', '?', '¦',
                 { english }
                   'e',  'E', 'u',  'U','i',  'I', 'o',  'O', 'a',  'A', 'j',  'J'
    ];
     
         SoglChar=['?', 'г', 'ъ', '¦','э', '=', 'у', '+', '°', '+',  '-',
                   'ч', '¦', '?', '-','?', 'L', 'т', 'T', 'я', '¦', 'Ё', '¦',
                   'ы', 'T', 'ф', '-','ц', '¦', '?', '+', 'ё', 'T', 'ь', '¦',
                   '?', 'T', 'с', '+',
                   { english }
                    'q', 'Q','w', 'W', 'r', 'R','t', 'T','y', 'Y','p', 'P','s',
     
    'S',
                    'd', 'D','f', 'F', 'g', 'G','h', 'H','k', 'K','l', 'L','z',
    'Z',
                    'x', 'X','c', 'C', 'v', 'V', 'b', 'B', 'n', 'N','m', 'M' ];
     
        SpecSign= [ '·', '-','c', '-', 'щ', 'г'];
     
    Function isSogl(c:Char):Boolean;
    begin
      Result:=c in SoglChar;
    end;
     
    Function isGlas(c:Char):Boolean;
    begin
      Result:=c in GlasChar;
    end;
     
    Function isSpecSign(c:Char):Boolean;
    begin
      Result:=c in SpecSign;
    end;
     
    Function GetSymbType(c:Char):TSymbol;
    begin
      if isSogl(c) then begin Result:=st_Sogl;exit;end;
     
      if isGlas(c) then begin Result:=st_Glas;exit;end;
      if isSpecSign(c) then begin Result:=st_Spec;exit;end;
      Result:=st_NoDefined;
    end;
     
    Function isSlogMore(c:pSymbAr;start,len:Integer):Boolean;
    var i:Integer;
        glFlag:Boolean;
    begin
      glFlag:=false;
    for i:=Start to Len-1 do
      begin
       if c^[i]=st_NoDefined then begin Result:=false;exit;end;
       if (c^[i]=st_Glas)and((c^[i+1]<>st_Nodefined)or(i<>Start))
          then
             begin
               Result:=True;
               exit;
             end;
      end;
     
      Result:=false;
    end;
     
     
        { Ёрёё?рты ыър яхЁхэюёют }
    Function SetHyph(pc:PChar;MaxSize:Integer):PChar;
    var
        HypBuff  : Pointer;
        h   : PSymbAr;
        i   : Integer;
        len : Integer;
        Cur : Integer; {  }
        cw  : Integer; { =юьхЁ с?ътv т ёыютх }
        Lock: Integer; { ё?х??шъ сыюъшЁютюъ }
    begin
      Cur:=0;
      len  := StrLen(pc);
      if (MaxSize=0)OR(Len=0) then
                    begin
                        Result:=nil;
                        Exit;
                    end;
     
      GetMem(HypBuff,MaxSize);
      GetMem(h,Len+1);
     
     
      for i:=0 to len-1 do h^[i]:=GetSymbType(pc[i]);
     
        cw:=0;
        Lock:=0;
         for i:=0 to Len-1 do
          begin
            PChar(HypBuff)[cur]:=PChar(pc)[i];Inc(Cur);
     
            if i>=Len-2 then Continue;
            if h^[i]=st_NoDefined then begin cw:=0;Continue;end else Inc(cw);
            if Lock<>0 then begin Dec(Lock);Continue;end;
            if cw<=1 then Continue;
            if not(isSlogMore(h,i+1,len)) then Continue;
     
     
            if
    (h^[i]=st_Sogl)and(h^[i-1]=st_Glas)and(h^[i+1]=st_Sogl)and(h^[i+2]<>st_Spec)
     
                   then begin PChar(HypBuff)[cur]:=HypSymb;Inc(Cur);Lock:=1;end;
     
            if
    (h^[i]=st_Glas)and(h^[i-1]=st_Sogl)and(h^[i+1]=st_Sogl)and(h^[i+2]=st_Glas)
                   then begin PChar(HypBuff)[cur]:=HypSymb;Inc(Cur);Lock:=1;end;
     
            if
    (h^[i]=st_Glas)and(h^[i-1]=st_Sogl)and(h^[i+1]=st_Glas)and(h^[i+2]=st_Sogl)
                   then begin PChar(HypBuff)[cur]:=HypSymb;Inc(Cur);Lock:=1;end;
     
            if (h^[i]=st_Spec) then begin
    PChar(HypBuff)[cur]:=HypSymb;Inc(Cur);Lock:=1; end;
     
          end;
        {}
       FreeMem(h,Len+1);
       PChar(HypBuff)[cur]:=#0;
       Result:=HypBuff;
    end;
     
    Function Red_GlasMore(p:Pchar;pos:Integer):Boolean;
    begin
      While p[pos]<>#0 do
       begin
         if p[pos] in Spaces then begin Result:=False; Exit; end;
         if isGlas(p[pos]) then begin Result:=True; Exit; end;
     
         Inc(pos);
       end;
      Result:=False;
    end;
     
    Function Red_SlogMore(p:Pchar;pos:Integer):Boolean;
    Var BeSogl,BeGlas:Boolean;
    begin
      BeSogl:=False;
      BeGlas:=False;
      While p[pos]<>#0 do
       begin
         if p[pos] in Spaces then Break;
         if Not BeGlas then BeGlas:=isGlas(p[pos]);
         if Not BeSogl then BeSogl:=isSogl(p[pos]);
         Inc(pos);
       end;
      Result:=BeGlas and BeSogl;
    end;
     
    Function MayBeHyph(p:PChar;pos:Integer):Boolean;
    var i:Integer;
        len:Integer;
    begin
      i:=pos;
      Len:=StrLen(p);
      Result:=
             (Len>3)
             AND
             (i>2)
     
             AND
             (i<Len-2)
             AND
              (not (p[i] in Spaces))
             AND
              (not (p[i+1] in Spaces))
             AND
              (not (p[i-1] in Spaces))
             AND
             (
             (isSogl(p[i])and isGlas(p[i-1])and isSogl(p[i+1])and
    Red_SlogMore(p,i+1))
             OR
    ((isGlas(p[i]))and(isSogl(p[i-1]))and(isSogl(p[i+1]))and(isGlas(p[i+2])))
             OR
             ((isGlas(p[i]))and(isSogl(p[i-1]))and(isGlas(p[i+1])) and
    Red_SlogMore(p,i+1)  )
             OR
             ((isSpecSign(p[i])))
             );
     
    end;
     
    Function SetHyphString(s : String):String;
     
    Var Res:PChar;
    begin
      Res:=SetHyph(PChar(S),Length(S)*2)
      Result:=Res;
      FreeMem(Res,Length(S)*2);
    end;
     
    end.

Alex Gorbunov

acdc\@media-press.donetsk.ua

www.media-press.donetsk.ua

(2:465/85.4)

.

Взято из FAQ:

Delphi and Windows API Tips\'n\'Tricks

olmal\@mail.ru

<https://www.chat.ru/~olmal>
