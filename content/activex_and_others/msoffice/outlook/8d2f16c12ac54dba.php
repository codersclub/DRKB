<h1>Чтение email адресов из Outlook .dbx файлов</h1>
<div class="date">01.01.2007</div>


<pre>
unit ExtractEmailsFunc;
 
interface
 
uses
  Windows, SysUtils;
 
procedure CheckEMail(FilePath: string);
 
implementation
 
var
  BufferSize: Integer;
 
function VerifyFile(strFileName: string): Integer;
var
  intErro: Integer;
  tsrFile: TSearchRec;
begin
  intErro := FindFirst(strFileName, FaAnyFile, tsrFile);
  if intErro = 0 then Result := tsrFile.Size 
  else 
    Result := -1;
  FindClose(tsrFile);
end;
 
procedure CheckEMail(FilePath: string);
var
  I: Integer;
  hFile: Integer;
  Buffer: PChar;
  StrEmail: string;
begin
  hFile := FileOpen(FilePath, fmOpenRead);
  try
    if hFile = 0 then Exit;
    GetMem(Buffer, bufferSize + 1);
    ZeroMemory(Buffer, BufferSize + 1);
    try
      FileRead(hFile, Buffer^, BufferSize);
      I := 0;
      while I &lt;= BufferSize - 1 do 
      begin
        StrEmail := '';
        if Buffer[I] = '&lt;' then 
        begin
          Inc(I);
          while (Buffer[I] &lt;&gt; '@') and (I &lt;= BufferSize) do 
          begin
            if (Buffer[I] = CHR(45)) or (Buffer[I] = CHR(46)) or
              (Buffer[I] = CHR(90)) or ((Buffer[I] &gt; CHR(49)) and (Buffer[I] &lt;= CHR(57)))
              or ((Buffer[I] &gt;= CHR(65)) and (Buffer[I] &lt;= CHR(90))) or
              ((Buffer[I] &gt;= CHR(97)) and (Buffer[I] &lt;= CHR(122))) then 
            begin
              StrEmail := StrEmail + Buffer[I];
            end 
            else 
            begin
              StrEmail := '';
              Break;
            end;
            Inc(I);
          end;
          if StrEmail &lt;&gt; '' then 
          begin
            StrEmail := StrEmail + '@';
            Inc(I);
            while (Buffer[I] &lt;&gt; '.') and (I &lt;= BufferSize) do 
            begin
              if (Buffer[I] = CHR(45)) or (Buffer[I] = CHR(46)) or
                (Buffer[I] = CHR(90)) or ((Buffer[I] &gt;= CHR(49)) and (Buffer[I] &lt;= CHR(57)))
                or ((Buffer[I] &gt;= CHR(65)) and (Buffer[I] &lt;= CHR(90))) or
                ((Buffer[I] &gt;= CHR(97)) and (Buffer[I] &lt;= CHR(122))) then 
              begin
                StrEmail := StrEmail + Buffer[I];
              end 
              else 
              begin
                StrEmail := '';
                Break;
              end;
              Inc(I);
            end;
            if StrEmail &lt;&gt; '' then 
            begin
              StrEmail := StrEmail + '.';
              Inc(i);
              while (Buffer[I] &lt;&gt; '&gt;') and (I &lt;= BufferSize) do 
              begin
                if (Buffer[I] = CHR(45)) or (Buffer[I] = CHR(46)) or
                  (Buffer[I] = CHR(90)) or ((Buffer[I] &gt;= CHR(49)) and (Buffer[I] &lt;= CHR(57)))
                  or ((Buffer[I] &gt;= CHR(65)) and (Buffer[I] &lt;= CHR(90))) or
                  ((Buffer[I] &gt;= CHR(97)) and (Buffer[I] &lt;= CHR(122))) then 
                begin
                  StrEmail := StrEmail + Buffer[I];
                end 
                else 
                begin
                  StrEmail := '';
                  Break;
                end;
                Inc(I);
              end;
              if StrEmail &lt;&gt; '' then 
              begin
                WriteLn(StrEmail);
                Inc(I);
              end;
            end;
          end;
        end 
        else 
          Inc(I);
      end;
    finally
      FreeMem(Buffer);
    end;
  finally
    FileClose(hFile);
  end;
end;
 
begin
  BufferSize := VerifyFile(ParamStr(1));
  if BufferSize &lt;= 0 then Exit;
  CheckEMail(ParamStr(1));
end.
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
