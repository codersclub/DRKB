---
Title: Несколько функций для TStream
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Несколько функций для TStream
=============================

    {These are three utility functions to write strings to a TStream. 
    Nothing fancy, but I just ended up coding this repeatedly so 
    I made these functions. }
     
    unit ClassUtils;
     
    interface
     
    uses
      SysUtils,
      Classes;
     
      {: Write a string to the stream 
      @param Stream is the TStream to write to. 
      @param s is the string to write 
      @returns the number of bytes written. }
    function Writestring(_Stream: TStream; const _s: string): Integer;
     
      {: Write a string to the stream appending CRLF 
      @param Stream is the TStream to write to. 
      @param s is the string to write 
      @returns the number of bytes written. }
    function WritestringLn(_Stream: TStream; const _s: string): Integer;
     
      {: Write formatted data to the stream appending CRLF 
      @param Stream is the TStream to write to. 
      @param Format is a format string as used in sysutils.format 
      @param Args is an array of const as used in sysutils.format 
      @returns the number of bytes written. }
    function WriteFmtLn(_Stream: TStream; const _Format: string;
      _Args: array of const): Integer;
     
    implementation
     
    function Writestring(_Stream: TStream; const _s: string): Integer;
    begin
      Result := _Stream.Write(PChar(_s)^, Length(_s));
    end;
     
    function WritestringLn(_Stream: TStream; const _s: string): Integer;
    begin
      Result := Writestring(_Stream, _s);
      Result := Result + Writestring(_Stream, #13#10);
    end;
     
    function WriteFmtLn(_Stream: TStream; const _Format: string;
      _Args: array of const): Integer;
    begin
      Result := WritestringLn(_Stream, Format(_Format, _Args));
    end;

