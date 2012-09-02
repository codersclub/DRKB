<h1>Как программно установить конфигурацию COM-порта в Windows 95?</h1>
<div class="date">01.01.2007</div>



<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  CommPort : string; 
  hCommFile : THandle; 
  Buffer : PCommConfig; 
  size : DWORD; 
begin 
  CommPort := 'COM1'; 
{Открываем Com-порт} 
  hCommFile := CreateFile(PChar(CommPort), 
                          GENERIC_WRITE, 
                          0, 
                          nil, 
                          OPEN_EXISTING, 
                          FILE_ATTRIBUTE_NORMAL, 
                          0); 
  if hCommFile=INVALID_HANDLE_VALUE then 
  begin 
    ShowMessage('Unable to open '+ CommPort); 
    exit; 
  end; 
{Выделяем временный буфер} 
  GetMem(Buffer, sizeof(TCommConfig)); 
 
{Получаем размер структуры CommConfig}
  size := 0; 
  GetCommConfig(hCommFile, Buffer^, size); 
 
{Освобождаем временный буфер} 
  FreeMem(Buffer, sizeof(TCommConfig)); 
 
{Выделяем память для структуры CommConfig} 
  GetMem(Buffer, size); 
  GetCommConfig(hCommFile, Buffer^, size); 
 
{Изменяем скорость передачи} 
  Buffer^.dcb.BaudRate := 1200; 
 
{Устанавливаем новую конфигурацию для COM-порта} 
  SetCommConfig(hCommFile, Buffer^, size); 
 
{Освобождаем буфер} 
  FreeMem(Buffer, size); 
 
{Закрываем COM-порт}
  CloseHandle(hCommFile); 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

