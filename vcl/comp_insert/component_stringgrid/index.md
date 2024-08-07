---
Title: Помещение компонентов в TStringGrid
Author: Neil Rubenking
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Помещение компонентов в TStringGrid
===================================

Некоторое время тому назад такой вопрос уже ставился: возможно ли
поместить элемент управления, например, CheckBox или ComboBox внутрь
компонента ...Grid. Я сегодня помозговал и нашел неплохую, на мой
взгляд, технологию. Это работает! Вот решение для тех, кто этим
интересуется:

При создании компонента (в обработчике OnCreate), создайте его объекты
Objects[C,R], например TCheckBox.Create(Self). Имейте в виду, что вы
должны присвоить ячейкам Cells[C,R] какие-либо значения прежде, чем
чем вы сможете иметь доступ к Objects[C,R]. Установите у вновь
созданного компонента свойство Visible в FALSE, а свойство parent в
SELF. Осуществите другую необходимую инициализацию. Имейте в виду, что
вы должны внести необходимые модули в список uses, если создаете тип
компонента, которого нигде кроме как на форме нет.

Создайте процедуру, берущую координаты колонки/строки и правильно
позиционирующую соотвествующий объект в пределах прямоугольника ячейки,
например:

    procedure TForm1.FixObjPosn(vCol, vRow: LongInt);
    {Размещаем содержимое компонента в области прямоугольника ячейки}
    var
      R: TRect;
    begin
      R := StringGrid1.CellRect(vCol, vRow);
      if StringGrid1.Objects[vCol, vRow] is TControl then
        with TControl(StringGrid1.Objects[vCol, vRow]) do
          if R.Right = R.Left then {прямоугольник ячейки невидим}
            Visible := False
          else
          begin
            InflateRect(R, -1, -1);
            OffsetRect(R, StringGrid1.Left + 1, StringGrid1.Top + 1);
            BoundsRect := R;
            Visible := True;
          end;
    end;

смещение позиции необходимо, поскольку CellRect расчитывается
относительно верхнего левого угла строки сетки, и родителем компонента
является форма).

В обработчике события сетки OnSelectCell проверьте, располагается ли
элемент Objects в текущей колонке Col и строке Row TControl - если так,
установите его свойство visible в FALSE. Теперь вызовите процедуру
установления координат из шага 2 для *НОВЫХ* Col и Row, передавая их
из параметров обработчика события в параметры функции.

В обработчике OnTopLeftChanged просто вызовите FixObjPosn

В обработчике события OnDrawCell во-первых, если ячейка выбрана, EXIT.
Если элемент ячейки Objects не TControl, также EXIT. В противном случае
вам нужно создать код, обеспечивающий отрисовку "фасада" каждого типа
элемента управления, которого вы разместили в сетке.

Обратите внимание на то, что если вы делаете что-либо с элементом
управления, на который влияют ДРУГИЕ элементы управления (например,
изменение статуса какой-либо радиокнопки из группы, или операции
enable/disable), вы должны вызвать метод сетки Refresh.

Опс! Это звучит немного запутанно, но это работает.

Успехов!

