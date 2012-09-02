<h1>Как поменять цвет Header'а в TListView</h1>
<div class="date">01.01.2007</div>


<p>Для этого нужно в оконной процедуре ListView обработать сообщение WM_NOTIFY с кодом NM_CUSTOMDRAW. И в обработчике этого сообщения назначить цвета фона и текста (можно назначить и шрифт). Но при этом правая часть header'а (область заголовка ListView, находящаяся справа от колонок) закрашиваться не будет. Чтобы закрасить и её, надо в оконной процедуре header'а обработать сообщение WM_ERASEBKGND, в котором и залить нужным цветом эту область. Ниже - небольшой примерчик с сабклассингом.</p>
<pre>
uses CommCtrl;
 
var
  BkBrush:HBRUSH; // тут сохраняем brush для фона
 
// процедура header'а
function NewHeaderProc(wnd: HWND; Msg: Cardinal; wParam: wParam; 
                          lParam: lParam): Longint; stdcall;
var
 BrushOld: HBRUSH;
 ClientRect:TRect;
begin
 Result := CallWindowProc(Pointer(GetWindowLong(wnd, GWL_USERDATA)),
                          wnd, Msg, wParam, lParam);
 
  if Msg=WM_ERASEBKGND then  // закрашиваем область справа от колонок
  begin
   GetClientRect(wnd,ClientRect);
   BrushOld := SelectObject(wParam, BkBrush);
   FillRect(wParam, ClientRect, BkBrush);
   SelectObject(wParam, BrushOld);
   Result := 1;
  end
end;
 
// процедура ListView
function NewListProc(wnd:HWND; uMsg:UINT; wParam:WPARAM; 
                     lParam:LPARAM):integer; stdcall;
var
  nmlvcd:PNMLVCUSTOMDRAW;
begin
   result:=CallWindowProc(Pointer(GetWindowLong(wnd,GWL_USERDATA)),wnd,
                          uMsg,wParam,lParam);
   if uMsg=WM_NOTIFY then
    if PNMLISTVIEW(lParam)^.hdr.code=NM_CUSTOMDRAW then
    begin
     nmlvcd:=PNMLVCUSTOMDRAW(lparam);
     case nmlvcd.nmcd.dwDrawStage of
       CDDS_PREPAINT:  result:=CDRF_NOTIFYITEMDRAW;
       CDDS_ITEMPREPAINT:
                   begin
                     SetTextColor(nmlvcd.nmcd.hdc,clRed);    // цвет текста
                     SetBkColor(nmlvcd.nmcd.hdc,clYellow);   // цвет фона
                     result:=CDRF_DODEFAULT;
                   end;
      CDDS_ITEMPOSTPAINT: result := CDRF_DODEFAULT;
     end
    end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
 i,j:integer;
 lit:TListItem;
begin
 with ListView1 do
 begin
  ViewStyle := vsReport; // стиль, естественно vsReport
  GridLines:=true;
 
// заполним ListView чем-нибудь
  for i:=0 to 2 do
  begin
     Columns.Add.Caption:='Column'+IntToStr(i);
     Columns[i].Width:=70;
     lit:=Items.Add;
     lit.Caption:='Item'+IntToStr(i);
     for j:=1 to 2 do lit.SubItems.Add('SubItem'+IntToStr(j)+IntToStr(i))
  end
end;
 
//меняем процедуру у ListView
 SetWindowLong(ListView1.Handle,GWL_USERDATA,SetWindowLong(ListView1.Handle, 
                   GWL_WNDPROC, LPARAM(@NewListProc)));
 
//тоже самое у Header'а
 SetWindowLong(GetWindow(ListView1.Handle, GW_CHILD),GWL_USERDATA,
              SetWindowLong(GetWindow(ListView1.Handle, GW_CHILD), 
              GWL_WNDPROC, LPARAM(@NewHeaderProc)));
 
 BkBrush := CreateSolidBrush(clYellow); // цвет фона
 
end;
</pre>
<p>Ещё вариант: для каждого элемента header'а установить флаг HDF_OWNERDRAW и в оконной процедуре ListView обрабатывать WM_DRAWITEM, где так же назначать цвета для элементов заголовка ListView. <br>
<p>&nbsp;</p>
<p>&nbsp;<br>
<p class="author">Автор: Krid </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
