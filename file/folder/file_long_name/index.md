---
Title: Как получить длинное имя файла или каталога, зная короткое имя?
Author: P.O.D.
Date: 01.01.2007
Id: 03166
Source: <https://forum.sources.ru>
---


Как получить длинное имя файла или каталога, зная короткое имя?
===============================================================

Вариант 1:

Author: P.O.D.

Используйте поле **Win32\_Find\_Data** в структуре TSearchRec.


    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      SearchRec : TSearchRec; 
      Success : integer; 
    begin 
      Success := SysUtils.FindFirst('C:\DownLoad\dial-u~1.htm', 
                                    faAnyFile, 
                                    SearchRec); 
      if Success = 0 then begin 
        ShowMessage(SearchRec.FindData.CFileName); 
      end; 
      SysUtils.FindClose(SearchRec); 
    end; 


------------------------------------------------------------------------

Вариант 2:

Author: Rouse\_

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
      function GetLongPathNameA(lpszShortPath, lpszLongPath: PChar;
        cchBuffer: DWORD): DWORD; stdcall; external kernel32;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    function ExpandFileName(Path: String): String;
    begin
      SetLength(Result, MAX_PATH);
      if GetLongPathNameA(PChar(Path), @Result[1], MAX_PATH) = 0 then
        RaiseLastOSError;
      Result := Trim(Result);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      S: String;
    begin
      // Получаем полное имя
      S := ExpandFileName('C:\DOCUME~1');
      ShowMessage(S);
      // Получаем урезанное имя
      GetShortPathName(PChar(S), PChar(S), MAX_PATH);
      ShowMessage(S);
    end;
     
    end.


