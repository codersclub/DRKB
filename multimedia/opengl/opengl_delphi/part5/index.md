---
Title: OpenGL в Delphi. Часть 5. GLAux
Date: 01.01.2007
Source: <https://www.ogldelphi.km.ru/about.html>
---


OpenGL в Delphi. Часть 5. GLAux
===============================

До этого мы писали программы с использованием OpenGL и GLUT.
Но SGI (Silicon Graphics, Inc.) приготовила программистам ещё одну библиотеку.

GLAUX - библиотека, где есть всё для работы с OpenGL
(чтение файла растра, наложение текстуры, построение примитивов...).

Правда,
одно маленькое замечание: в разделе Инструмент вы найдёте
glaux.dll в архиве RAR (~160kb), но в распакованном виде она
"весит" !1.32 Mb!, и вам придётся "таскать" этот файл вместе
со своей программой. Так же в разделе Инструмент вы найдёте
заголовки Этой библиотеки для DELPHI и для C++.

**!!!ВНИМАНИЕ!!!**

Кто может "конвертнуть" заголовки из С++ в DELPHI, тот сделает
благородное дело для себя и ОСТАЛЬНЫХ!

А теперь поговорим про программировании с этой библиотекой.

Откройте новый проект: File -\> New -\> Application

Теперь в директиву "uses" добавьте "glaux" вот так
(файл GLAUX.pas должен быть у вас):

    uses
         Windows, Messages, SysUtils, Classes, Graphics, Controls,
    Forms,ExtCtrls, Dialogs, glaux 
    //Подключаем Glaux.pas

Далее в процедуре TForm1.draww, после того как переведём
камеру в нужную точку функцией

    glTranslatef(0.0, 0.0, -7.0);

можно рисовать всё, что угодно.

    procedure TForm1.draww;
    Begin
      glClear(GL_COLOR_BUFFER_BIT or GL_DEPTH_BUFFER_BIT);
      glClearColor(0.7,0.7,0.7,0.0);
      glLoadIdentity; 
      glTranslatef(0.0, 0.0, -7.0);
    {}
         auxSolidSphere(2.0);
    {}
    SwapBuffers(DC);
    end;

Вот список того, что можно построить:

- auxWireSphere(1);  Сфера проволочная
- auxSolidSphere(1); Сфера твёрдая
- uxWireCube(1);  Куб проволочный
- uxSolidCube(1); Куб твёрдый
- uxWireBox(1,2,3);  Параллелепипед проволочный
- uxSolidBox(1,2,3); Параллелепипед твёрдый
- uxWireTorus(1,2);  Тор проволочный
- uxSolidTorus(1,2); Тор твёрдый
- uxWireCylinder(1,2);  Цилиндр проволочный
- uxSolidCylinder(1,2); Цилиндр твёрдый
- uxWireIcosahedron(1);  Икосаэдр проволочный
- uxSolidIcosahedron(1); Икосаэдр твёрдый
- uxWireOctahedron(1);  Октаэдр проволочный
- uxSolidOctahedron(1); Октаэдр твёрдый
- uxWireTetrahedron(1);  Тетраэдр проволочный
- uxSolidTetrahedron(1); Тетраэдр твёрдый
- uxWireDodecahedron(1);  Додекаэдр проволочный
- uxSolidDodecahedron(1); Додекаэдр твёрдый
- uxWireCone(1,0.5);  Конус проволочный
- uxSolidCone(1,0.5); Конус твёрдый
- uxWireTeapot(1);  Чайник проволочный
- uxSolidTeapot(1); Чайник твёрдый

Вот и всё!

