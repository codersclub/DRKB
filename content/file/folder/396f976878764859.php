<h1>Как получить длинное имя файла или каталога, зная короткое имя?</h1>
<div class="date">01.01.2007</div>


<p>Используйте Win32_Find_Data поле TSearchRec. <br>
<p></p>
<pre>
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
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: P.O.D.</div>
<hr />
<pre>
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
  S := ExpandFileName('C:\DOCUME~1\');
  ShowMessage(S);
  // Получаем урезанное имя
  GetShortPathName(PChar(S), PChar(S), MAX_PATH);
  ShowMessage(S);
end;
 
end.
</pre>
&copy;Drkb::03166
 
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Rouse_</div>
