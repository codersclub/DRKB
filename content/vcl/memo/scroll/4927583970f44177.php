<h1>Обнаружение прокрутки TMemo</h1>
<div class="date">01.01.2007</div>

Автор: Xavier Pacheco </p>
<p>Создайте потомок TMemo, перехватывающий сообщения WM_HSCROLL и WM_VSCROLL:</p>
<pre>
TSMemo = class(TMemo)
 
procedure WM_HScroll(var Msg: TWMHScroll); message WM_HSCROLL;
procedure WM_VScroll(var Msg: TWMVScroll); message WM_VSCROLL;
end;
 
...
 
procedure TSMemo.WM_HScroll(var Msg: TWMHScroll);
begin
  ShowMessage('HScroll');
end;
 
procedure TSMemo.WM_VScroll(var Msg: TWMVScroll);
begin
  ShowMessage('VScroll');
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
