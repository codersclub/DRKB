<h1>Как узнать, находится ли дискета в дисководе?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TDriveState(DS_NO_DISK, DS_UNFORMATTED_DISK, DS_EMPTY_DISK,
    DS_DISK_WITH_FILES);
 
function DriveState(driveletter: Char): TDriveState;
var
  mask: string[6];
  sRec: TSearchRec;
  oldMode: Cardinal;
  retcode: Integer;
begin
  oldMode: = SetErrorMode(SEM_FAILCRITICALERRORS);
  mask := '?:\*.*';
  mask[1] := driveletter;
{$I-} { не возбуждаем исключение при неудаче }
  retcode := FindFirst(mask, faAnyfile, SRec);
  FindClose(SRec);
{$I+}
  case retcode of
    0: Result := DS_DISK_WITH_FILES; { обнаружен по крайней мере один файл }
    -18: Result := DS_EMPTY_DISK; { никаких файлов не обнаружено, но ok }
    -21: Result := DS_NO_DISK; { DOS ERROR_NOT_READY }
  else
    Result := DS_UNFORMATTED_DISK; { в моей системе значение равно -1785!}
  end;
  SetErrorMode(oldMode);
end; { DriveState }
</pre>


<p>Я тестировал код под Win NT 3.5, так что проверьте его на ошибки в ситуациях, когда дискета отсутствует или неотформатирована под Win 3.1 и WfW 3.11, если, конечно, это необходимо. </p>

<p>Ревизия для Win95:</p>

<pre>
case RetCode of
  0: Result := DS_DISK_WITH_FILES;
  -18: Result := DS_EMPTY_DISK;
  else
    Result := DS_NO_DISK;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
function DiskInDrive(const Drive: char): Boolean;
var
  DrvNum: byte;
  EMode: Word;
begin
  result := false;
  DrvNum := ord(Drive);
  if DrvNum &gt;= ord('a') then
    dec(DrvNum, $20);
  EMode := SetErrorMode(SEM_FAILCRITICALERRORS);
  try
    if DiskSize(DrvNum - $40) &lt;&gt; -1 then
      result := true
    else
      messagebeep(0);
  finally
    SetErrorMode(EMode);
  end;
end;
</pre>

<p>...можно для пущей функциональности добавить ряд строк:</p>

<pre>
function DiskInDrive(const Drive: char): Boolean;
var
  DrvNum: byte;
  EMode: Word;
begin
  result := true; // было false
  DrvNum := ord(Drive);
  if DrvNum &gt;= ord('a') then
    dec(DrvNum, $20);
  EMode := SetErrorMode(SEM_FAILCRITICALERRORS);
  try
    while DiskSize(DrvNum - $40) = -1 do
    begin // при неудаче выводим диалог
      if (Application.MessageBox('Диск не готов...' + chr(13) + chr(10) +
        'Повторить?', PChar('Диск ' + UpperCase(Drive)), mb_OKCANCEL +
        mb_iconexclamation {IconQuestion}) = idcancel) then
      begin
        Result := false;
        Break;
      end;
    end;
  finally
    SetErrorMode(EMode);
  end;
end;
</pre>


<div class="author">Автор: <a href="mailto:inrus51@poikc.bashnet.ru" target="_blank">Галимарзанов Фанис</a> </div><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

