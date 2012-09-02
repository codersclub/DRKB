<h1>Отправка WinPopup сообщения через MailSlots</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 

 
var
  MSHandle: THandle;
  MSMessage: array [0..2] of String;
  ResultMsMessage: String;
  MSWrite: DWORD;
  ServerName: String;
begin
  ServerName := Edit1.Text; // Имя компьютера
  if ServerName = '' then ServerName := '*\';
  if ServerName[Length(ServerName)] &lt;&gt; '\' then ServerName := ServerName + '\';
  // Оккрываем на удаленном компьютере мэйслот для записи
  MSHandle := CreateFile(PChar('\\' + ServerName + 'mailslot\messngr'),
    GENERIC_WRITE, // or GENERIC_READ,
    FILE_SHARE_READ,
    nil,
    OPEN_EXISTING,
    FILE_ATTRIBUTE_NORMAL,
    0);
  if not Win32Check(MSHandle &lt;&gt; INVALID_HANDLE_VALUE) then Exit;
  // Подготавливаем сообщение
  MSMessage[0] := Edit2.Text; // От кого
  MSMessage[1] := Edit3.Text; // Кому
  MSMessage[2] := Memo1.Text; // Текст сообщение
  // Преобразование в DOS кодировку
  CharToOem(PChar(MSMessage[0]), PChar(MSMessage[0]));
  CharToOem(PChar(MSMessage[1]), PChar(MSMessage[1]));
  CharToOem(PChar(MSMessage[2]), PChar(MSMessage[2]));
  ResultMsMessage := MSMessage[0] + #0 + MSMessage[1] + #0 + MSMessage[2];
  // Пишем сообщение
  WriteFile(MSHandle, Pointer(PChar(ResultMsMessage))^, Length(ResultMsMessage), MSWrite, nil);
  Win32Check(MSWrite = Length(ResultMsMessage));
  CloseHandle(MSHandle);
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Rouse_</p>

