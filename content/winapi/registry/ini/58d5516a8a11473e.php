<h1>Модуль для работы с INI-файлами</h1>
<div class="date">01.01.2007</div>


<p>Вот мой модуль для работы с Ini файлами... Должен всем пригодиться...</p>
<pre>
//Модуль для работы с данными в конфигурационном файле.
//Функции упрощают использование конфиг. файлов.
//Данный материал можно изменять по Вашему усмотрению...
//При нахождении ошибкок пишите на guedda@yandex.ru
unit MyIni.pas
 
interface
 
uses
  IniFiles;
 
procedure WriteIniData(Section, Ident, Value : string);
procedure WriteIniDataInt(Section, Ident : string; Value : Integer);
procedure WriteIniDataBool(Section, Ident : string; Value : boolean);
function ReadIniData(Section, Ident : string; Default : string = '') : string;
function ReadIniDataInt(Section, Ident : string; Default : Integer = 0) : Integer;
function ReadIniDataBool(Section, Ident : string; Default : boolean = false) : boolean;
 
implementation
 
var
  IniFile : TIniFile;
  Path : string;
 
procedure WriteIniData(Section, Ident, Value : string);
begin
  IniFile := TIniFile.Create(Path + '\config.ini');
  IniFile.WriteString(Section, Ident, Value);
  IniFile.Free;
end;
 
procedure WriteIniDataInt(Section, Ident : string; Value : Integer);
begin
  IniFile := TIniFile.Create(Path + '\config.ini');
  IniFile.WriteInteger(Section, Ident, Value);
  IniFile.Free;
end;
 
procedure WriteIniDataBool(Section, Ident : string; Value : boolean);
begin
  IniFile := TIniFile.Create(Path + '\config.ini');
  IniFile.WriteBool(Section, Ident, Value);
  IniFile.Free;
end;
 
function ReadIniData(Section, Ident : string; Default : string = '') : string;
begin
  IniFile := TIniFile.Create(Path + '\config.ini');
  Result := IniFile.ReadString(Section, Ident, Default);
  IniFile.Free;
end;
 
function ReadIniDataInt(Section, Ident : string; Default : Integer = 0) : Integer;
begin
  IniFile := TIniFile.Create(Path + '\config.ini');
  Result := IniFile.ReadInteger(Section, Ident, Default);
  IniFile.Free;
end;
 
function ReadIniDataBool(Section, Ident : string; Default : boolean = false) : boolean;
begin
  IniFile := TIniFile.Create(Path + '\config.ini');
  Result := IniFile.ReadBool(Section, Ident, Default);
  IniFile.Free;
end;
 
initialization
  GetDir(0, Path);
 
end.
</pre>
<div class="author">Автор: Guedda</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
Unit USDKINIFiles;
 
{ From Windows Messages SDK }
 
Interface
 
Uses Windows, SysUtils;
 
Type
  TINIFile = Class(TObject)
  Private
    FFileName: String;
  Public
    Constructor Create(Const FileName : String);
    Destructor Destroy; Override;
    Function ReadString(Const Section, Key, Default: String): String;
    Function ReadInteger(Const Section, Key: String;
      Default: Longint): Longint;
    Function ReadBool(Const Section, Key: String; Default: Boolean): Boolean;
    Function WriteString(Const Section, Key, Value: String): Boolean;
    Function WriteInteger(Const Section, Key: String;
      Value: Longint): Boolean;
    Function WriteBool(Const Section, Key: String; Value: Boolean): Boolean;
    Procedure UpdateFile;
    Property FileName: String Read FFileName;
  End;
 
Implementation
 
{ TINIFile }
 
Constructor TIniFile.Create(Const FileName: String);
Begin
  FFileName := FileName;
End;
 
Destructor TIniFile.Destroy;
Begin
  UpdateFile;
  Inherited Destroy;
End;
 
Function TIniFile.ReadBool(Const Section, Key: String;
  Default: Boolean): Boolean;
Begin
  Result := ReadInteger(Section, Key, Ord(Default)) &lt;&gt; 0;
End;
 
Function TIniFile.ReadInteger(Const Section, Key: String;
  Default: Integer): Longint;
Var
  IntStr: String;
Begin
  IntStr := ReadString(Section, Key, '');
  If (Length(IntStr) &gt; 2) And (IntStr[1] = '0') And
     ((IntStr[2] = 'X') Or (IntStr[2] = 'x')) Then
    IntStr := '$' + Copy(IntStr, 3, MaxInt);
  Result := StrToIntDef(IntStr, Default);
End;
 
Function TIniFile.ReadString(Const Section, Key, Default: String): String;
Var
  Buffer: Array[0..2047] Of Char;
Begin
  SetString(Result, Buffer, GetPrivateProfileString(PChar(Section),
    PChar(Key), PChar(Default), Buffer, SizeOf(Buffer), PChar(FFileName)));
End;
 
Procedure TIniFile.UpdateFile;
Begin
  WritePrivateProfileString(NIL, NIL, NIL, PChar(FFileName));
End;
 
Function TIniFile.WriteBool(Const Section, Key: String;
  Value: Boolean): Boolean;
Const
  Values: Array[Boolean] Of String = ('0', '1');
Begin
  Result := WriteString(Section, Key, Values[Value]);
End;
 
Function TIniFile.WriteInteger(Const Section, Key: String;
  Value: Integer): Boolean;
Begin
  Result := WriteString(Section, Key, IntToStr(Value));
End;
 
Function TIniFile.WriteString(Const Section, Key, Value: String): Boolean;
Begin
  Result := WritePrivateProfileString(PChar(Section), PChar(Key),
    PChar(Value), PChar(FFileName));
End;
 
End.
</pre>
<div class="author">Автор: Rrader</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
