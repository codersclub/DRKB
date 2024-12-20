---
Title: Как удобнее работать с буфером обмена как последовательностью байт?
author: Alexey Mahotkin, alexm@hsys.msk.ru
Source: Delphi and Windows API Tips\'n\'Tricks
Date: 01.01.1998
---


Как удобнее работать с буфером обмена как последовательностью байт?
===================================================================

    unit ClipStrm;
     
    {
      This unit is Copyright (c) Alexey Mahotkin 1997-1998
      and may be used freely for any purpose. Please mail
      your comments to
      E-Mail: alexm@hsys.msk.ru
      FidoNet: Alexey Mahotkin, 2:5020/433
     
      This unit was developed during incorporating of TP Lex/Yacc
      into my project. Please visit ftp://ftp.nf.ru/pub/alexm
      or FREQ FILES from 2:5020/433 or mail me to get hacked
      version of TP Lex/Yacc which works under Delphi 2.0+.
    }
     
    interface uses Classes, Windows;
     
    type
      TClipboardStream = class(TStream)
      private
        FMemory : pointer;
        FSize : longint;
        FPosition : longint;
        FFormat : word;
      public
        constructor Create(fmt : word);
        destructor Destroy; override;
     
        function Read(var Buffer; Count : Longint) : Longint; override;
        function Write(const Buffer; Count : Longint) : Longint; override;
        function Seek(Offset : Longint; Origin : Word) : Longint; override;
      end;
     
    implementation uses SysUtils;
     
    constructor TClipboardStream.Create(fmt : word);
     
    var
      tmp : pointer;
      FHandle : THandle;
    begin
      FFormat := fmt;
      OpenClipboard(0);
      FHandle := GetClipboardData(FFormat);
      FSize := GlobalSize(FHandle);
      FMemory := AllocMem(FSize);
      tmp := GlobalLock(FHandle);
      MoveMemory(FMemory, tmp, FSize);
      GlobalUnlock(FHandle);
      FPosition := 0;
      CloseClipboard;
    end;
     
    destructor TClipboardStream.Destroy;
    begin
      FreeMem(FMemory);
    end;
     
    function TClipboardStream.Read(var Buffer; Count : longint) : longint;
    begin
      if FPosition + Count > FSize then
        Result := FSize - FPosition
      else
        Result := Count;
      MoveMemory(@Buffer, PChar(FMemory) + FPosition, Result);
     
      Inc(FPosition, Result);
    end;
     
    function TClipboardStream.Write(const Buffer; Count : longint) : longint;
    var
      FHandle : HGlobal;
      tmp : pointer;
    begin
      ReallocMem(FMemory, FPosition + Count);
      MoveMemory(PChar(FMemory) + FPosition, @Buffer, Count);
      FPosition := FPosition + Count;
      FSize := FPosition;
      FHandle := GlobalAlloc(GMEM_MOVEABLE or GMEM_SHARE or GMEM_ZEROINIT, FSize);
      try
        tmp := GlobalLock(FHandle);
        try
          MoveMemory(tmp, FMemory, FSize);
          OpenClipboard(0);
          SetClipboardData(FFormat, FHandle);
        finally
          GlobalUnlock(FHandle);
        end;
        CloseClipboard;
      except
        GlobalFree(FHandle);
      end;
      Result := Count;
    end;
     
    function TClipboardStream.Seek(Offset : Longint; Origin : Word) : Longint;
    begin
      case Origin of
        0 : FPosition := Offset;
        1 : Inc(FPosition, Offset);
        2 : FPosition := FSize + Offset;
      end;
      Result := FPosition;
    end;
     
    end.

Alexey Mahotkin alexm@hsys.msk.ru (2:5020/433)

olmal@mail.ru

https://www.chat.ru/\~olmal
