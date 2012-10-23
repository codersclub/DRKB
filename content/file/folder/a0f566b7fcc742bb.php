<h1>Как получить короткий путь файла, если есть длинный, и на оборот?</h1>
<div class="date">01.01.2007</div>


<pre>
// Короткий
GetShortPathName(LongPath) 
 
// Наоборот длинный
GetFullPathName(ShortPath)
</pre>

<hr />
<pre>
function sfn(const LongName: String): String;
 

 
// Возвращает LongFileName преобразованное в соответствующее короткое имя
var i :Integer;
begin
  SetLength(Result,Length(LongName));
  i := GetShortPathName(pChar(LongName),pChar(Result),Length(Result));
  if  i &gt; Length(Result)  then begin
    SetLength(Result,i);
    i := GetShortPathName(pChar(LongName),pChar(Result),Length(Result));
  end;
  SetLength(Result,i);
end;
 
function ShortToLongFileName(FileName: string): string;
// Возвращает FileName преобразованное в соответствующее длинное имя
var
  KernelHandle: THandle;
  FindData: TWin32FindData;
  Search: THandle;
  GetLongPathName: function(lpszShortPath: PChar; lpszLongPath: PChar;
                            cchBuffer: DWORD): DWORD; stdcall;
begin
  KernelHandle := GetModuleHandle('KERNEL32');
  if KernelHandle &lt;&gt; 0 then
    @GetLongPathName := GetProcAddress(KernelHandle, 'GetLongPathNameA');
 
  // Использю GetLongPathName доступную в windows 98 и выше чтобы
  // избежать проблем доступа к путям UNC в системах NT/2K/XP
  if Assigned(GetLongPathName) then begin
    SetLength(Result, MAX_PATH + 1);
    SetLength(Result, GetLongPathName(PChar(FileName), @Result[1], MAX_PATH));
  end
  else begin
    Result := '';
 
    // Поднимаюсь на одну дирректорию выше от пути к файлу и запоминаю
    // в result.  FindFirstFile возвратит длинное имя файла полученное
    // из короткого.
    while (True) do begin
      Search := Windows.FindFirstFile(PChar(FileName), FindData);
 
      if Search = INVALID_HANDLE_VALUE then Break;
 
      Result := String('\') + FindData.cFileName + Result;
      FileName := ExtractFileDir(FileName);
      Windows.FindClose(Search);
 
      // Нахожу имя диска с двоеточием.
      if Length(FileName) &lt;= 2 then Break;
    end;
 
    Result := ExtractFileDrive(FileName) + Result;
  end;
end;
 
</pre>
<div class="author">Автор: Alex&amp;Co </div>
<p>Сайт: <a href="https://alex-co.com.ru " target="_blank">https://alex-co.com.ru </a></p>
