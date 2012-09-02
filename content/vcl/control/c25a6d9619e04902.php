<h1>Над какой закладкой курсор в TTabControl</h1>
<div class="date">01.01.2007</div>

Автор: YoungHacker </p>
<p>Получение позиции мышиного курсора для TabControl над какой закладкой находится курсор.</p>
<pre>
function Form1.ItemAtPos(TabControlHandle : HWND; X, Y : Integer) : Integer;
var
  HitTestInfo : TTCHitTestInfo;
  HitIndex : Integer;
begin
  HitTestInfo.pt.x := X;
  HitTestInfo.pt.y := Y;
  HitTestInfo.flags := 0;
  HitIndex := SendMessage(TabControlHandle, TCM_HITTEST, 0, Longint(@HitTestInfo));
  Result := HitIndex;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
