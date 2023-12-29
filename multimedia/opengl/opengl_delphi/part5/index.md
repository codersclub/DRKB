---
Title: OpenGL в Delphi. Часть 5. GLAux
Date: 01.01.2007
---


OpenGL в Delphi. Часть 5. GLAux
===============================

::: {.date}
01.01.2007
:::

До этого мы писали программы с использованием OpenGL и GLUT.
Но SGI\* приготовила программистам ещё одну библиотеку.

GLAUX - библиотека, где есть всё для работы с OpenGL
(чтение файла растра, наложение текстуры, построение примитивов...).

Правда,
одно маленькое замечание: в разделе Инструмент вы найдёте
glaux.dll в архиве RAR (\~160kb), но в распакованном виде она
\"весит\" !1.32 Mb!, и вам придётся \"таскать\" этот файл вместе
со своей программой. Так же в разделе Инструмент вы найдёте
заголовки Этой библиотеки для DELPHI и для C++.

!!!ВНИМАНИЕ!!!

Кто может \"конвертнуть\" заголовки из С++ в DELPHI, тот сделает
благородное дело для себя и ОСТАЛЬНЫХ!

А теперь поговорим про программировании с этой библиотекой.

Откройте новый проект: File -\> New -\> Application

Теперь в директиву \"uses\" добавьте \"glaux\" вот так
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

auxWireSphere(1); auxSolidSphere(1); auxWireCube(1); auxSolidCube(1);
auxWireBox(1,2,3); auxSolidBox(1,2,3); auxWireTorus(1,2);
auxSolidTorus(1,2); auxWireCylinder(1,2); auxSolidCylinder(1,2);
auxWireIcosahedron(1); auxSolidIcosahedron(1); auxWireOctahedron(1);
auxSolidOctahedron(1); auxWireTetrahedron(1); auxSolidTetrahedron(1);
auxWireDodecahedron(1); auxSolidDodecahedron(1); auxWireCone(1,0.5);
auxSolidCone(1,0.5); auxWireTeapot(1);

auxSolidTeapot(1);

Вот и всё!

<https://www.ogldelphi.km.ru/about.html>
