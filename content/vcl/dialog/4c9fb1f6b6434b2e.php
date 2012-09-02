<h1>Диалог подключения сетевого диска</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TStartForm.NetBtnClick(Sender: TObject);
var
  OldDrives: TStringList;
  i: Integer;
begin
  OldDrives := TStringList.Create;
  // Запоминаем список дисков
  OldDrives.Assign(Drivebox.Items);
  // Показываем диалог подключения
  if WNetConnectionDialog(Handle, RESOURCETYPE_DISK) = NO_ERROR then
  begin
    // Обновляем список дисков
    DriveBox.TextCase := tcLowerCase;
    for i := 0 to DriveBox.Items.Count - 1 do
    begin
      // Ищем свободный логический диск
      if Olddrives.IndexOf(Drivebox.Items[i]) = -1 then
      begin
        // Показываем первый найденный логический диск
        DriveBox.ItemIndex := i;
        // Каскадируем обновление на список подключенных каталогов и др.
        DriveBox.Drive := DriveBox.Text[1];
      end;
    end;
    DriveBox.SetFocus;
  end;
  OldDrives.Free;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Открытие диалогового окна «Подключение сетевого диска»
 
Зависимости: Windows
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        21 мая 2002 г.
********************************************** }
 
function MapNetworkDrive(Wnd: HWND = 0): DWORD;
begin
 if Wnd = 0 then Wnd:=FindWindow('Shell_TrayWnd',''); Result:=WNetConnectionDialog(Wnd, RESOURCETYPE_DISK);
end; 
</pre>


<p> Пример использования:</p>
<pre>
MapNetworkDrive(Application.Handle); 
</pre>

