---
Title: RC4
Author: MakedoneZ
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


RC4
===

RC4 - Симметричный алгоритм шифрования поточного вида.
Переменная длина ключа.
Для зашифровки/расшифровки применяют один и тот же ключ.

Был рассекречен в середине 90-х анонимным лицом в интернете.

    ///////////////////////////////////////////////////
    ///////////////////Шифр RC4////////////////////////
    ///////////////////////////////////////////////////
    unit RC4;
     
    var
       s: array [0..255] of Byte;
     i,j: Byte;
     
    //Инициализация S-Box'а
    procedure InitRC4Cipher(key: ShortString);
    var
         k: array [0..255] of Byte;
         t: Byte;
         l: Cardinal;
     i0,j0: Byte;
     
    begin
      for i0 := 0 to 255 do s[i0] := i0;
     
      j0 := 1; l := Length(key);
      for i0 := 0 to 255 do
        begin
          k[i0] := Ord(key[j0]);
          if j0 = l then j0 := 0;
          Inc(j0);
        end;
     
      for i0 := 0 to 255 do
        begin
          j0 := (j0 + k[i0] + s[i0]) mod 256;
     
          t    := s[i0];
          s[i0] := s[j0];
          s[j0] := t;
        end;
     
      i := 0;
      j := 0;
    end;
     
    //Шифрование конкретного символа 
    function GetRC4ByteCiphered(bt: Byte): Byte;
    var
      t: Byte;
     
    begin
      i := (i + 1)    mod 256;
      j := (j + s[i]) mod 256;
     
      t    := s[i];
      s[i] := s[j];
      s[j] := t;
     
      t := (s[i] + s[j]) mod 256;
     
      Result := bt XOR s[t];
    end;
     
    //Применения шифра к данным потока
    function ApplyRC4ToData(InitialData: TStream; var Buffer: TStream; key: ShortString): Boolean; stdcall;
    var
      i: Cardinal;
      d: Byte;
     
    begin
      if (key = '')OR(Buffer = InitialData)OR(Buffer = nil)OR(InitialData = nil)OR(InitialData.Size = 0)OR(Buffer.Size <> 0) then
        begin
          Result := false;
          Exit;
        end;
     
      InitRC4Cipher(key);
     
      try
        InitialData.Position := 0;
        for i := 0 to InitialData.Size-1 do
          begin
            InitialData.ReadBuffer(d,1);
            d := GetRC4ByteCiphered(d);
            Buffer.WriteBuffer(d,1);
          end;
      except
        Result := false;
        Exit;
      end;
     
      InitialData.Position  := 0;
      Buffer.Position := 0;
     
      Result := true;
    end;


