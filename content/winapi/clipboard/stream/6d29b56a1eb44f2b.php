<h1>Буфер обмена (Clipboard) и TMemoryStream</h1>
<div class="date">01.01.2007</div>


<p>Обычно, это нужно для того, чтобы запихнуть в буфер обмена данные собственного формата. Сначала необходимо зарегистрировать этот формат при помощи функции RegisterClipboardFormat():</p>

<p>CF_MYFORMAT := RegisterClipboardFormat('My Format Description');</p>

<p>Затем необходимо проделать следующие шаги:</p>
<p>1. Создать поток (stream) и записать в него данные.</p>
<p>2. Создать в памяти глобальный буфер и скопировать в него поток (stream).</p>
<p>3. При помощи Clipboard.SetAsHandle() поместить глобальный буфер в буфер обмена.</p>

<p>Пример:</p>
<pre>
var
  hbuf    : THandle;
  bufptr  : Pointer;
  mstream : TMemoryStream;
begin
  mstream := TMemoryStream.Create;
  try
    {-- Записываем данные в mstream. --}
    hbuf := GlobalAlloc(GMEM_MOVEABLE, mstream.size);
    try
      bufptr := GlobalLock(hbuf);
      try
        Move(mstream.Memory^, bufptr^, mstream.size);
        Clipboard.SetAsHandle(CF_MYFORMAT, hbuf);
      finally
        GlobalUnlock(hbuf);
      end;
    except
      GlobalFree(hbuf);
      raise;
    end;
  finally
    mstream.Free;
  end;
end;
</pre>


<p>ВАЖНО: Не удаляйте буфер после GlobalAlloc(). Как только Вы поместите его в буфер обмена, то буфер обмена будет пользоваться им.</p>

<p>Для получения данных из потока, можно воспользоваться следующим кодом:</p>
<pre>
var
  hbuf    : THandle;
  bufptr  : Pointer;
  mstream : TMemoryStream;
begin
  hbuf := Clipboard.GetAsHandle(CF_MYFORMAT);
  if hbuf &lt;&gt; 0 then begin
    bufptr := GlobalLock(hbuf);
    if bufptr &lt;&gt; nil then begin
      try
        mstream := TMemoryStream.Create;
        try
          mstream.WriteBuffer(bufptr^, GlobalSize(hbuf));
          mstream.Position := 0;
          {-- Читаем данные из mstream. --}
        finally
          mstream.Free;
        end;
      finally
        GlobalUnlock(hbuf);
      end;
    end;
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

