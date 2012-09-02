<h1>Синхронизация двух компонентов TScrollBox</h1>
<div class="date">01.01.2007</div>


<p>Решить задачу помогут обработчики событий OnScroll (в данном примере два компонента ScrollBox (ScrollBar1 и ScrollBar2) расположены на форме TMainForm): </p>

<pre>
procedure TMainForm.ScrollBar1Scroll(Sender: TObject;
ScrollCode: TScrollCode; var ScrollPos: Integer);
begin
  ScrollBar2.Position:=ScrollPos;
end;
 
procedure TMainForm.ScrollBar2Scroll(Sender: TObject;
ScrollCode: TScrollCode; var ScrollPos: Integer);
begin
  ScrollBar1.Position := ScrollPos;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
