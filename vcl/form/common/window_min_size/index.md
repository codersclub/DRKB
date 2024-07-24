---
Title: Как установить минимальный размер окна?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как установить минимальный размер окна?
=======================================

Необходимо объявить обработчик события для WM\_GETMINMAXINFO:

    ... 
    private 
     
      procedure WMGetMinMaxInfo(var Message : TWMGetMinMaxInfo); 
      message WM_GETMINMAXINFO; 
     
     
А вот как выглядит сам обработчик:
     
    procedure TForm1.WMGetMinMaxInfo(var Message : TWMGetMinMaxInfo); 
    begin 
      Message.MinMaxInfo^.ptMinTrackSize := Point(Width, Height); 
      Message.MinMaxInfo^.ptMaxTrackSize := Point(Width, Height); 
    end; 


**Примечание от Vit:**

Начиная с Дельфи 5 появилось удобное свойство Constrains - специально
для ограничесния минимальных и максимальных размеров...
