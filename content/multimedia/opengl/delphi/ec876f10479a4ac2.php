<h1>OpenGL в Delphi. Часть 3. Quadric-объекты</h1>
<div class="date">01.01.2007</div>

<p> В разделе переменных укажим:</p>
<pre>
   quadObj : NewQuadricObj;
</pre>

<p>  ,а далее пишем следующее(я просто прокомментирую код)</p>
<pre>
WMPaint:
 
  quadObj := gluNewQuadric;//новый объект
  glRotate(5.0, 0.0, 1.0, 0.0);//повернём
  glPushMatrix;//перейдём к новым координатам, сохранив старые
  glRotated(-90,1.0,0.0,0.0);//ещё раз повернём
  gluSphere(quadObj,1.3,20,20);//а теперь нарисуем сферу "1.3 - радиус",
    // а 20 и 20 - это колличество разбиений
  glPopMatrix;//перейдём к старым координатам
  gluDeleteQuadric(quadObj);//эта функция сделает "чёрную" работу
 
  quadObj := gluNewQuadric;
  glRotate(9.0, 0.0, 7.0, 0.0);
  glPushMatrix;
  glRotated(-270,1.0,0.0,0.0);
  gluCylinder (quadObj, 0.5, 0.5, 2.9, 30, 30);//0.5- радиус, 0.5 - радиус, 2.9 - высота
  glPopMatrix;
  gluDeleteQuadric(quadObj);
</pre>

<p> Вот и всё!</p>
<p><a href="https://www.ogldelphi.km.ru/about.html" target="_blank">https://www.ogldelphi.km.ru/about.html</a></p>

