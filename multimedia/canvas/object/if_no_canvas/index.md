---
Title: Как рисовать на компоненте, если свойство Canvas недоступно?
Date: 01.01.2007
---


Как рисовать на компоненте, если свойство Canvas недоступно?
============================================================

Вариант 1:

Author: Akzhan Abdulin (2:5040/55)

У всех компонентов, порожденных от TCustomControl, имеется свойство
Canvas типа TCanvas.

Если свойство Canvas недоступно, Вы можете достучаться до него созданием
потомка и переносом этого свойства в раздел Public.

    { Example. We recommend You to create this component through Component Wizard.
    In Delphi 1 it can be found as 'File|New Component...', and can be found
    as 'Component|New Component...' in Delphi 2 or above. }
    type
      TcPanel = class(TPanel)
      public
        property Canvas;
      end;


---------------------------------
Вариант 2:

Author: Andrew Velikoredchanin (2:5026/29.3)

Если у объекта нет свойства Canvas (у TDBEdit, вpоде-бы нет), по кpайней
меpе в D3 можно использовать класс TControlCanvas. Пpимеpное
использование:

    var cc: TControlCanvas; 
    ... 
    cc := TControlCanvas.Create; 
    cc.Control := youControl; 
    ... 

и далее как обычно можно использовать методы Canvas.

