<h1>Как в TListBox нарисовать Item своим цветом?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer; 
Rect: TRect; State: TOwnerDrawState); 
begin 
  With ListBox1 do 
  begin 
    If odSelected in State then 
      Canvas.Brush.Color:=clTeal { твой цвет } 
    else 
      Canvas.Brush.Color:=clWindow; 
    Canvas.FillRect(Rect); 
    Canvas.TextOut(Rect.Left+2,Rect.Top,Items[Index]); 
  end; 
end; 
</pre>


<p>Hе забудьте установить свойство Style у своего ListBox в lbOwnerDrawFixed или в </p>
<p>lbOwnerDrawVariable.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

