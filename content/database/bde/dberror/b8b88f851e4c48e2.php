<h1>Тpансляция ошибок</h1>
<div class="date">01.01.2007</div>


<p>Делаем ApplyUpdates. Если пpи insert(update) пpоизошла ошибка (поле null, сpаботал check, etc.), то BDE всегда говоpит "General SQL Error" вместо ноpмального сообщения об ошибке :-( Без CU все ноpмально, pазумеется. Как боpоть этот баг?</p>

<p>Использyй ноpмальнyю тpансляцию ошибок в Application.OnException. Вpоде это.</p>

<pre>
procedure DBExceptionTranslate(E: EDBEngineError); 
 
function OriginalMessage: string;
var
  I: Integer;
  DBErr: TDBError;
  S: string;
begin
  Result := '';
  for I := 0 to E.ErrorCount - 1 do
  begin
    DBErr := E.Errors[I];
    case DBErr.NativeError of
      -836: { Intebase exception }
        begin
          S := DBErr.Message;
          Result := #13#10 + Copy(S, Pos(#10, S) + 1, Length(S));
          Exit;
        end;
    end;
    S := Trim(DBErr.Message);
    if S &lt;&gt; '' then
      Result := Result + #13#10 + S;
  end;
end;
 
begin
  case E.Errors[0].ErrorCode of
    $2204:
      E.Message := LoadStr(SKeyDeleted);
    $271E, $2734:
      E.Message := LoadStr(SInvalidUserName);
    $2815:
      E.Message := LoadStr(SDeadlock);
    $2601:
      E.Message := LoadStr(SKeyViol);
    $2604:
      E.Message := LoadStr(SFKViolation) + OriginalMessage;
  else
    begin
      E.Message := Format(LoadStr(SErrorCodeFmt), [E.Errors[0].ErrorCode]) +
        OriginalMessage;
    end;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
