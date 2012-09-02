<h1>Проверка правильности даты</h1>
<div class="date">01.01.2007</div>



<pre>
function DateExists(Date: string; Separator: char): Boolean;
var
  OldDateSeparator: Char;
begin
  Result := True;
  OldDateSeparator := DateSeparator;
  DateSeparator := Separator;
  try
    try
      StrToDate(Date);
    except
      Result := False;
    end;
  finally
    DateSeparator := OldDateSeparator;
  end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  if DateExists('35.3.2001', '.') then
  begin
    {your code}
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

<hr />
<pre>
function ValidDate(const S: String): Boolean;
BEGIN
  Result := True;
  try
    StrToDate(S);
  except
    ON EConvertError DO
      Result := False;
  end;
END
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


