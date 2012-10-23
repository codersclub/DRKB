<h1>Сохранение данных в Clipboard</h1>
<div class="date">01.01.2007</div>

Автор: Vladimir Timonin</p>
<p>Мне нужно использовать clipboard для сохранения данных в собственном формате и я хочу для этого написать набор процедур ввода/вывода с использованием потоков (streams). Возможно ли создать объект TMemoryStream, эаполнить его и поместить в Clipboard?</p>
<p>Hе только возможно, именно так поступают функции Clipboard.GetComponent и Clipboard.SetComponent. Сначала вы должны зарегистрировать свой собственный формат данных для Clipboard с помощью функции RegisterClipboardFormat:</p>
<p>  &nbsp; &nbsp;CF_MYFORMAT := RegisterClipboardFormat('My Format Description');</p>
<p>Далее вы должны выполнить шаги:</p>
<p>1. Создать поток (memory stream) и записать туда данные.</p>
<p>2. Создать глобальный буфер в памяти и скопировать поток туда.</p>
<p>3. Вызвать Clipboard.SetAsHandle(), чтобы поместить буфер в Clipboard.</p>
<p>Пример:</p>
<pre>     var
       hBuf: THandle;
       Bufptr: Pointer;
       MStream: TMemoryStream;
     begin
       MStream := TMemoryStream.Create;
       try
       { write your data to the stream }
         hBuf := GlobalAlloc(GMEM_MOVEABLE, MStream.Size);
         try
           BufPtr := GlobalLock(hBuf);
           try
             Move(MStream.Memory^, BufPtr^, MStream.Size);
             Clipboard.SetAsHandle(CF_MYFORMAT, hBuf);
           finally
             GlobalUnlock(hBuf);
           end;
         except
           GlobalFree(hBuf);
           raise;
         end;
       finally
         MStream.Free;
       end;
     end;
</pre>
<p>Внимание: не уничтожайте буфер, созданный с GlobalAlloc. Поскольку вы поместили его в Clipboard, это уже дело clipboard'а его уничтожить. Опять же, получая буфер из Clipboard, не уничтожайте этот буфер - просто сделайте копию содержимого.</p>
<p>Для обратного получения потока и данных, сделайте что-нибудь вроде этого:</p>
<pre>     var
       hBuf: THandle;
       BufPtr: Pointer;
       MStream: TMemoryStream;
     begin
       hBuf := Clipboard.GetAsHandle(CF_MYFORMAT);
       if hBuf &lt;&gt; 0 then
 
       begin
         BufPtr := GlobalLock(hBuf);
         if BufPtr &lt;&gt; nil then
         try
           MStream := TMemoryStream.Create;
           try
             MStream.WriteBuffer(BufPtr^, GlobalSize(hBuf));
             MStream.Position := 0;
           { read your data from the stream }
           finally
             MStream.Free;
           end;
         finally
           GlobalUnlock(hBuf);
         end;
       end;
     end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


