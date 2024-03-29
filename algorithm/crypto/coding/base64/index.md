---
Title: Base64 кодирование
Author: P.O.D.
Date: 01.01.2007
---


Base64 кодирование
==================

Вариант 1:

    function Decode(const S: AnsiString): AnsiString; 
    const 
      Map: array[Char] of Byte = (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 62, 0, 0, 0, 63, 52, 53, 
        54, 55, 56, 57, 58, 59, 60, 61, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 
        3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 
        20, 21, 22, 23, 24, 25, 0, 0, 0, 0, 0, 0, 26, 27, 28, 29, 30, 
        31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 
        46, 47, 48, 49, 50, 51, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0); 
    var 
      I: LongInt; 
    begin 
      case Length(S) of 
        2:  
          begin 
            I := Map[S[1]] + (Map[S[2]] shl 6); 
            SetLength(Result, 1); 
            Move(I, Result[1], Length(Result)) 
          end; 
        3:  
          begin 
            I := Map[S[1]] + (Map[S[2]] shl 6) + (Map[S[3]] shl 12); 
            SetLength(Result, 2); 
            Move(I, Result[1], Length(Result)) 
          end; 
        4:  
          begin 
            I := Map[S[1]] + (Map[S[2]] shl 6) + (Map[S[3]] shl 12) + 
              (Map[S[4]] shl 18); 
            SetLength(Result, 3); 
            Move(I, Result[1], Length(Result)) 
          end 
      end 
    end; 

    function Encode(const S: AnsiString): AnsiString; 
    const 
      Map: array[0..63] of Char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' + 
        'abcdefghijklmnopqrstuvwxyz0123456789+/'; 
    var 
      I: LongInt; 
    begin 
      I := 0; 
      Move(S[1], I, Length(S)); 
      case Length(S) of 
        1: 
          Result := Map[I mod 64] + Map[(I shr 6) mod 64]; 
        2: 
          Result := Map[I mod 64] + Map[(I shr 6) mod 64] + 
            Map[(I shr 12) mod 64]; 
        3: 
          Result := Map[I mod 64] + Map[(I shr 6) mod 64] + 
            Map[(I shr 12) mod 64] + Map[(I shr 18) mod 64] 
      end 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

Вариант 2:

    type TAByte = array [0..maxInt-1] of byte;
    type TPAByte = ^TAByte;
     
    function Encode(data:string) : string; overload;
    const b64 : array [0..63] of char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    var ic,len : integer;
    pi, po : TPAByte;
    c1 : dword;
    begin
    len:=length(data);
    if len > 0 then begin
    SetLength(result, ((len + 2) div 3) * 4);
    pi := pointer(data);
    po := pointer(result);
    for ic := 1 to len div 3 do begin
    c1 := pi^[0] shl 16 + pi^[1] shl 8 + pi^[2];
    po^[0] := byte(b64[(c1 shr 18) and $3f]);
    po^[1] := byte(b64[(c1 shr 12) and $3f]);
    po^[2] := byte(b64[(c1 shr 6) and $3f]);
    po^[3] := byte(b64[(c1 ) and $3f]);
    inc(dword(po), 4);
    inc(dword(pi), 3);
    end;
    case len mod 3 of
    1 : begin
    c1 := pi^[0] shl 16;
    po^[0] := byte(b64[(c1 shr 18) and $3f]);
    po^[1] := byte(b64[(c1 shr 12) and $3f]);
    po^[2] := byte('=');
    po^[3] := byte('=');
    end;
    2 : begin
    c1 := pi^[0] shl 16 + pi^[1] shl 8;
    po^[0] := byte(b64[(c1 shr 18) and $3f]);
    po^[1] := byte(b64[(c1 shr 12) and $3f]);
    po^[2] := byte(b64[(c1 shr 6) and $3f]);
    po^[3] := byte('=');
    end;
    end;
    end else
    result := '';
    end;
     
    function Decode(data:string) : string; overload;
    var i1,i2,len : integer;
    pi, po : TPAByte;
    ch1 : char;
    c1 : dword;
    begin
    len:=length(data);
    if (len > 0) and (len mod 4 = 0) then begin
    len := len shr 2;
    SetLength(result, len * 3);
    pi := pointer(data);
    po := pointer(result);
    for i1 := 1 to len do begin
    c1 := 0;
    i2 := 0;
    while true do begin
    ch1 := char(pi^[i2]);
    case ch1 of
    'A'..'Z' : c1 := c1 or (dword(ch1) - byte('A') );
    'a'..'z' : c1 := c1 or (dword(ch1) - byte('a') + 26);
    '0'..'9' : c1 := c1 or (dword(ch1) - byte('0') + 52);
    '+' : c1 := c1 or 62;
    '/' : c1 := c1 or 63;
    else begin
    if i2 = 3 then begin
    po^[0] := c1 shr 16;
    po^[1] := byte(c1 shr 8);
    SetLength(result, Length(result) - 1);
    end else begin
    po^[0] := c1 shr 10;
    SetLength(result, Length(result) - 2);
    end;
    exit;
    end;
    end;
    if i2 = 3 then
    break;
    inc(i2);
    c1 := c1 shl 6;
    end;
    po^[0] := c1 shr 16;
    po^[1] := byte(c1 shr 8);
    po^[2] := byte(c1);
    inc(dword(pi), 4);
    inc(dword(po), 3);
    end;
    end else
    result := '';
    end;
     
    ....
     
    var a,b:string;
    begin
    a:='aaa';
    b:=Encode( a );
    showmessage( b );
    a:=Decode( b );
    showmessage( a ); 
     

Автор: P.O.D.

------------------------------------------------------------------------

Вариант 3:

    const
      Codes64 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+/';
     
    function Encode64(S: string): string;
    var
      i: Integer;
      a: Integer;
      x: Integer;
      b: Integer;
    begin
      Result := '';
      a := 0;
      b := 0;
      for i := 1 to Length(s) do
      begin
        x := Ord(s[i]);
        b := b * 256 + x;
        a := a + 8;
        while a >= 6 do
        begin
          a := a - 6;
          x := b div (1 shl a);
          b := b mod (1 shl a);
          Result := Result + Codes64[x + 1];
        end;
      end;
      if a > 0 then
      begin
        x := b shl (6 - a);
        Result := Result + Codes64[x + 1];
      end;
    end;
     

    const
      Codes64 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+/';
     
     
    function Decode64(S: string): string;
    var
      i: Integer;
      a: Integer;
      x: Integer;
      b: Integer;
    begin
      Result := '';
      a := 0;
      b := 0;
      for i := 1 to Length(s) do
      begin
        x := Pos(s[i], codes64) - 1;
        if x >= 0 then
        begin
          b := b * 64 + x;
          a := a + 6;
          if a >= 8 then
          begin
            a := a - 8;
            x := b shr a;
            b := b mod (1 shl a);
            x := x mod 256;
            Result := Result + chr(x);
          end;
        end
        else
          Exit;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

Вариант 4:

    { 64-битное декодирование файлов }
    { Arne de Bruijn }
    uses dos;
    var
     
      Base64: array[43..122] of byte;
    var
     
      T: text;
      Chars: set of char;
      S: string;
      K, I, J: word;
      Buf: pointer;
      DShift: integer;
      F: file;
      B, B1: byte;
      Decode: array[0..63] of byte;
      Shift2: byte;
      Size, W: word;
    begin
      FillChar(Base64, SizeOf(Base64), 255);
      J := 0;
      for I := 65 to 90 do
      begin
        Base64[I] := J;
        Inc(J);
      end;
      for I := 97 to 122 do
      begin
        Base64[I] := J;
        Inc(J);
      end;
      for I := 48 to 57 do
      begin
        Base64[I] := J;
        Inc(J);
      end;
      Base64[43] := J;
      Inc(J);
      Base64[47] := J;
      Inc(J);
      if ParamCount = 0 then
      begin
        WriteLn('UNBASE64 <mime-файл> [<выходной файл>]');
        Halt(1);
      end;
      S := ParamStr(1);
      assign(T, S);
      GetMem(Buf, 32768);
      SetTextBuf(T, Buf^, 32768);
    {$I-}reset(T);
    {$I+}
      if IOResult <> 0 then
      begin
        WriteLn('Ошибка считывания ', S);
        Halt(1);
      end;
      if ParamCount >= 2 then
        S := ParamStr(2)
      else
      begin
        write('Расположение:');
        ReadLn(S);
      end;
      assign(F, S);
    {$I-}rewrite(F, 1);
    {$I+}
      if IOResult <> 0 then
      begin
        WriteLn('Ошибка создания ', S);
        Halt(1);
      end;
      while not eof(T) do
      begin
        ReadLn(T, S);
        if (S <> '') and (pos(' ', S) = 0) and (S[1] >= #43) and (S[1] <= #122) and
          (Base64[byte(S[1])] <> 255) then
        begin
          FillChar(Decode, SizeOf(Decode), 0);
          DShift := 0;
          J := 0;
          Shift2 := 1;
          Size := 255;
          B := 0;
          for I := 1 to Length(S) do
          begin
            case S[I] of
              #43..#122: B1 := Base64[Ord(S[I])];
            else
              B1 := 255;
            end;
            if B1 = 255 then
              if S[I] = '=' then
              begin
                B1 := 0;
                if Size = 255 then
                  Size := J;
              end
              else
                WriteLn('Ошибка символа:', S[I], ' (', Ord(S[I]), ')');
            if DShift and 7 = 0 then
            begin
              Decode[J] := byte(B1 shl 2);
              DShift := 2;
            end
            else
            begin
              Decode[J] := Decode[J] or Hi(word(B1) shl (DShift + 2));
              Decode[J + 1] := Lo(word(B1) shl (DShift + 2));
              Inc(J);
              Inc(DShift, 2);
            end;
          end;
          if Size = 255 then
            Size := J;
          BlockWrite(F, Decode, Size);
        end;
      end;
      Close(F);
      close(T);
    end.

DelphiWorld 6.0 <https://delphiworld.narod.ru/>

