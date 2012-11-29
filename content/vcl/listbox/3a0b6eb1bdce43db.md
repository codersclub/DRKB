Как добавить горизонтальную полосу прокрутки (scrollbar) в TListBox?
====================================================================

::: {.date}
01.01.2007
:::

В Delphi компонент TListBox автоматически включает в себя вертикальный
scrollbar. Полоска прокрутки появляется в том случае, если все элементы
списка не помещаются в видимую область списка. Однако, list box не
показывает горизонтального скролбара, когда ширина элементов превышает
ширину списка. Конечно же существует способ добавить горизонтальную
полосу прокрутки.

Добавьте следующий код в событие Вашей формы OnCreate.

    procedure TForm1.FormCreate(Sender: TObject); 
    var 
      i, MaxWidth: integer; 
    begin 
      MaxWidth := 0; 
      for i := 0 to LB1.Items.Count - 1 do 
      if MaxWidth < LB1.Canvas.TextWidth(LB1.Items.Strings[i]) then 
        MaxWidth := LB1.Canvas.TextWidth(LB1.Items.Strings[i]); 
      SendMessage(LB1.Handle, LB_SETHORIZONTALEXTENT, MaxWidth+2, 0); 
    end; 

Приведённый код определяет ширину в пикселях самой длинной строки
списка. Затем он использует сообщение LB\_SETHORIZONTALEXTENT, чтобы
установить ширину горизонтального скролбара в пикселях. Два
дополнительных пикселя добавленные к MaxWidth служат для стрелки в
правом углу list box-а.

Взято из <https://forum.sources.ru>
