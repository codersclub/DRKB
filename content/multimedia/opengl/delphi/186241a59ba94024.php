<h1>OpenGL в Delphi. Часть 5. GLAux</h1>
<div class="date">01.01.2007</div>

<p>До этого мы писали программы с использованием OpenGL и GLUT.</p>
<p>Но SGI* приготовила программистам ещё одну библиотеку.</p>
<p>GLAUX - библиотека, где есть всё для работы с OpenGL</p>
<p>(чтение файла растра, наложение текстуры, построение примитивов...). Правда</p>
<p>одно маленькое замечание: в разделе Инструмент вы найдёте</p>
<p>glaux.dll в архиве RAR (~160kb), но в распакованном виде она</p>
<p>"весит" !1.32 Mb!, и вам придётся "таскать" этот файл вместе</p>
<p>со своей программой. Так же в разделе Инструмент вы найдёте</p>
<p>заголовки Этой библиотеки для DELPHI и для C++. !!!ВНИМАНИЕ!!!</p>
<p>Кто может "конвертнуть" заголовки из С++ в DELPHI, тот сделает</p>
<p>благородное дело для себя и ОСТАЛЬНЫХ! <br>
<p>А теперь поговорим про программировании с этой библиотекой.</p>
<p>Откройте новый проект: File -&gt; New -&gt; Application</p>
<p>Теперь в дириктиву "uses" добавьте "glaux" вот так</p>
<p>(файл GLAUX.pas должен быть у вас):</p>
<pre>uses
     Windows, Messages, SysUtils, Classes, Graphics, Controls,
Forms,ExtCtrls, Dialogs, glaux 
//Подключаем Glaux.pas
</pre>

<p>Далее в процедуре TForm1.draww, после того как переведём</p>
<p>камеру в нужную точку функцией</p>
   glTranslatef(0.0, 0.0, -7.0);</p>
<p>можно рисовать всё, что угодно.</p>
<pre>procedure TForm1.draww;
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
</pre>

<p>Вот список того, что можно построить:</p>
 auxWireSphere(1);
 auxSolidSphere(1);
 auxWireCube(1);
 auxSolidCube(1);
 auxWireBox(1,2,3);
 auxSolidBox(1,2,3);
 auxWireTorus(1,2);
 auxSolidTorus(1,2);
 auxWireCylinder(1,2);
 auxSolidCylinder(1,2);
 auxWireIcosahedron(1);
 auxSolidIcosahedron(1);
 auxWireOctahedron(1);
 auxSolidOctahedron(1);
 auxWireTetrahedron(1);
 auxSolidTetrahedron(1);
 auxWireDodecahedron(1);
 auxSolidDodecahedron(1);
 auxWireCone(1,0.5);
 auxSolidCone(1,0.5);
 auxWireTeapot(1);
<p> auxSolidTeapot(1);</p>
<p> Вот и всё!</p>
<p><a href="https://www.ogldelphi.km.ru/about.html" target="_blank">https://www.ogldelphi.km.ru/about.html</a></p>

