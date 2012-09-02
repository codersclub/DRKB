<h1>Мерцание формы</h1>
<div class="date">01.01.2007</div>


<p>Как бы это осуществить рисование в окне без его дурацкого мерцания и без помощи создания виртуального изображения в памяти? WM_SETREDRAW здесь поможет? </p>

<p>Попробуйте этот код. Даже если некоторые компоненты имеют пару BeginUpdate / EndUpdate, то для таких компонентов, как TTreeView, интенсивное рисование может послужить причиной перемещения полосы прокрутки и появления других "барабашек". В таких ситуаций вместо дескриптора элемента управления используйте родительский дескриптор.</p>
<pre>
procedure BeginScreenUpdate(hwnd: THandle);
begin
  if (hwnd = 0) then
    hwnd := Application.MainForm.Handle;
  SendMessage(hwnd, WM_SETREDRAW, 0, 0);
end;
 
procedure EndScreenUpdate(hwnd: THandle; erase: Boolean);
begin
  if (hwnd = 0) then
    hwnd := Application.MainForm.Handle;
  SendMessage(hwnd, WM_SETREDRAW, 1, 0);
  RedrawWindow(hwnd, nil, 0, DW_FRAME + RDW_INVALIDATE +
    RDW_ALLCHILDREN + RDW_NOINTERNALPAINT);
  if (erase) then
    Windows.InvalidateRect(hwnd, nil, True);
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
