---
Title: Как добавлять колонки в обычный TListBox?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как добавлять колонки в обычный TListBox?
=========================================

Класс TListbox содержит свойство TabWith:

    ListBox1.TabWith := 50; 
    ListBox1.Items.Add('Column1'^I'Column2');  // ^I это символ Tab

