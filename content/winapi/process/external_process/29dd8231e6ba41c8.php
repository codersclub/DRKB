<h1>Требуется нажать в другом приложении пару кнопок</h1>
<div class="date">01.01.2007</div>


<p>Требуется нажать в "другом" приложении пару кнопок (button). (кнопки не имеют hotkeys). Ищу окно так (Дельфи):</p>
<pre>
if FindWindow(nil, 'Advanced Dialer')&lt;&gt; 0 then
  ShowMessage('OK');
</pre>


<p>А теперь в найденном приложении надо нажать кнопку HangUp, подождать 5 сек. и нажать кнопку Dial. Подскажите плз. как это реализовать. Я не знаю, что там за кнопки... Если класс Button, то один вариант, если это конпки на тулбаре, то другой. Вот посмотри, я писал когда-то, лишнее стирать лень... реализуется 1-й и 2-й способ:</p>
<pre>
function PressAbortAndReloadBtn: string;
var
  MenuHnd: THandle;
  //описатель меню
  ItemUint: UINT;
  //идентификатор пункта меню
  BtnHnd: THandle;
begin
  result := PRX_UNKNOWN_ERR;
  GetProcList;
  if Prx_MainWHnd &lt;&gt; 0 then
  begin
    BtnHnd := FindWindowEx(Prx_MainWHnd, 0, nil, PChar(PrxABtnName));
    SendMessage(BtnHnd, BM_CLICK, 0, 0);
    Sleep(100);
    MenuHnd := GetMenu(Prx_MainWHnd);
    if Menuhnd &lt;&gt; 0 then
    begin
      ItemUint := GetMenuItemID(Menuhnd, 4);
      if ItemUint &lt;&gt; 0 then
      begin
        SendMessage(Prx_MainWHnd, WM_COMMAND, ItemUint, 0);
        result := PRX_OK;
      end
      else
        result := PRX_ITEM_NOT_FOUND;
    end
    else
      result := PRX_MENU_NOT_FOUND;
  end
  else
    result := PRX_NOT_FOUND;
  if result &lt;&gt; PRX_OK then
    WriteLog(result);
end;
 
// У себя делал так
 
procedure ClickOnForm(wnd: HWND; caption: string);
var
  TheChildHandle: HWND;
begin
  TheChildHandle := FindWindowEx(wnd, 0, nil, PChar(caption));
  SendMessage(TheChildHandle, WM_LButtonDown, 1, 1);
  SendMessage(TheChildHandle, WM_LButtonUP, 1, 1);
end;
 
procedure TForm1.Button4Click(Sender: TObject);
var
  wnd: HWND;
  caption: string;
begin
  wnd := GetTopWindow(0);
  repeat
    SetLength(caption, GetWindowtextLength(wnd));
    GetWindowText(wnd, @caption[1], length(caption) + 1);
 
    if (trim(caption) = 'Form caption') then
      ClickOnForm(wnd, 'Button name');
    wnd := GetNextWindow(wnd, GW_HWNDNEXT);
  until wnd = 0;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

