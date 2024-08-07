---
Title: Как поместить картинки в Combo Box?
Author: Allan Carlton
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить картинки в Combo Box?
===================================

Делается это при помощи стиля ownerdraw, который присутствует в
TComboBox. Нас интересуют два свойства этого стиля:

- csOwnerDrawFixed - используется, если все битмапы имеют одинаковую высоту
- csOwnerDrawVariable - используется для битмапов с разной высотой

После того как стиль будет установлен на один из вышеперечисленных, то
можно воспользоваться событием onDrawItem. Это событие возникает каждый
раз, когда приложению необходимо нарисовать пункт в выпадающем списке
(combo box). Событие определяется следующим образом:

    procedure TForm1.ComboBox1DrawItem(Control: TWinControl; Index: Integer;
              Rect: TRect; State: TOwnerDrawState)

Если выпадающему списку был присвоен стиль csOwnerDrawFixed, то всё, что
надо сделать, это написать процедуру, которая будет рисовать битмап и
текст в событии onDrawItem.

Для выпадающего списка со стилем csOwnerDrawVariable необходимо пройти
ещё одну дополнительную стадию. Заключается эта стадия в создании
обработчика для события onMeasureItem. Это событие вызывается перед
DrawItem, для того, чтобы Вы могли установить фактическую высоту для
каждого элемента списка. Вот его определение:

    procedure TForm1.ComboBox1MeasureItem(Control: TWinControl;
              Index: Integer;
              var Height: Integer);

- Создайте новое приложение

- Разместите на форме combobox и imagelist (если Вы используете delphi 1,
то Вам прийдётся хранить битмапы каким-то другим способом)

```delphi
procedure TForm1.ComboBox1DrawItem(Control: TWinControl; Index:Integer;  Rect: TRect; State: TOwnerDrawState);
begin
  (* Заполняем прямоугольник *)
  combobox1.canvas.fillrect(rect);  
 
  (* Рисуем сам битмап *)
  imagelist1.Draw(comboBox1.Canvas,rect.left,rect.top,Index);
 
  (* Пишем текст после картинки *)
  combobox1.canvas.textout(rect.left+imagelist1.width+2,rect.top,
                          combobox1.items[index]);
end;
```

