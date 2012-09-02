<h1>Как вывести цветной текст в TStatusBar?</h1>
<div class="date">01.01.2007</div>


<p>Статусбар, это стандартный элемент управления Windows и как все отображает шрифт, заданный в параметре clBtnText, который устанавливается через Панель управления. Поумолчанию этот цвет чёрный, но он может менятся в зависимоти пользовательской темы. StatusBar и связанные с ним панели имеют возможность самостоятельной перерисовки (owner-draw), позволяющей рисовать текст различными цветами. Для этого необходимо в TStatusBar.Panels установить свойство Style в OwnerDraw.</p>

<pre>
procedure TForm1.StatusBar1DrawPanel(StatusBar: TStatusBar; 
  Panel: TStatusPanel; const Rect: TRect); 
begin 
  if Panel = StatusBar.Panels[0] then begin 
    StatusBar.Canvas.Font.Color := clRed; 
    StatusBar.Canvas.TextOut(Rect.Left, Rect.Top, 'Panel - 0') 
  end else begin 
    StatusBar.Canvas.Font.Color := clGreen; 
    StatusBar.Canvas.TextOut(Rect.Left, Rect.Top, 'Panel - 1'); 
  end; 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

