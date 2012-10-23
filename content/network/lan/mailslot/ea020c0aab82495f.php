<h1>Пример работы с MailSlot</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
 hSlot1      : THandle;
 lpszSlotName: LPSTR;
begin
 lpszSlotName := '\\\\.\\mailslot\\sample_mailslot';
 hslot1 := CreateMailslot (lpszSlotName,
                           0,
                           MAILSLOT_WAIT_FOREVER,
                           nil);
 //тут поидее должна быть обработка ошибки, если не удалось создать 
 //Далее работаем с ним, как с файлом т.е. WriteFile и т.д.
 // CloseHandle(hSlot1); //а кады закрываем за собой дескриптор, 
 //то память чистится т.е. все, что мы туда поназаписали удаляется
end;
</pre>
<div class="author">Автор: Baa </div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<p>WinAPI-&gt;Windows-&gt;Процессы...-&gt;Пример работы с MailSlot</p>
<p>Тут Baa немного ошибся. Он написал открытие мэйлслота в C++ стиле:</p>
<p> lpszSlotName := '\\\\.\\mailslot\\sample_mailslot';</p>
<p>а надо так:</p>
<p> lpszSlotName := '\\.\mailslot\sample_mailslot';</p>
<p>т.е. вместо \\ надо просто \</p>
<div class="author">Автор: p0s0l</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

