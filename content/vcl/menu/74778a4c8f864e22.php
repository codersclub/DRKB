<h1>Более быстрый способ добавлять пункты меню</h1>
<div class="date">01.01.2007</div>


<p>Обычно, когда Вы создаёте меню в приложении, то код выглядит примерно так:</p>

<pre>
    PopupMenu1 := TPopupMenu.Create(Self); 
    Item := TMenuItem.Create(PopupMenu1); 
    Item.Caption := 'First Menu'; 
    Item.OnClick := MenuItem1Click; 
    PopupMenu1.Items.Add(Item); 
    Item := TMenuItem.Create(PopupMenu1); 
    Item.Caption := 'Second Menu'; 
    Item.OnClick := MenuItem2Click; 
    PopupMenu1.Items.Add(Item); 
    Item := TMenuItem.Create(PopupMenu1); 
    Item.Caption := 'Third Menu'; 
    Item.OnClick := MenuItem3Click; 
    PopupMenu1.Items.Add(Item); 
 
    Item := TMenuItem.Create(PopupMenu1); 
    Item.Caption := '-'; 
    PopupMenu1.Items.Add(Item); 
    Item := TMenuItem.Create(PopupMenu1); 
    Item.Caption := 'Fourth Menu'; 
    Item.OnClick := MenuItem4Click; 
    PopupMenu1.Items.Add(Item); 
</pre>


<p>Однако есть более быстрый способ! Воспользуйтесь функциями NewItem и NewLine:</p>
<pre>
    PopupMenu1 := TPopupMenu.Create(Self); 
    with PopUpMenu1.Items do 
      begin 
        Add(NewItem('First Menu',0,False,True,MenuItem1Click,0,'MenuItem1')); 
        Add(NewItem('Second Menu',0,False,True,MenuItem2Click,0,'MenuItem2')); 
        Add(NewItem('Third Menu',0,False,True,MenuItem3Click,0,'MenuItem3')); 
        Add(NewLine);                        // Добавляем разделитель
        Add(NewItem('Fourth Menu',0,False,True,MenuItem4Click,0,'MenuItem4')); 
      end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

