<h1>OpenGL в Delphi. Часть 2. Туман</h1>
<div class="date">01.01.2007</div>

<p>Мы сегодня будем работать с туманом... Во всех предыдущих примерах использовался туман,</p>
<p>но его действия вы наверное не замечали, но теперь вы это ощутите.</p>
<p>Объявим константу</p>
<pre>
 const 
   fogColor : array[0..3] of GLfloat = (0.7, 0.7, 0.7, 2.0); //цвет тумана 
</pre>

<p>Циферки в конце устанавливают следующее:</p>
<p>(0.7, 0.7, 0.7, 2.0) 1-ая - красный, 2-ая - синий, 3-ая - зелёный,</p>
<p>ну а четвёртая - альфа-канал</p>
<p>Далее переменные:</p>
<pre>
var
fogMode : GLint;
</pre>

<p> Перед тем как юзать, его надо включить:</p>
<pre>
  glEnable(GL_FOG);
   fogMode := GL_EXP; 
   glFogi(GL_FOG_MODE, fogMode); 
   glFogfv(GL_FOG_COLOR, @fogColor);//устанавливаем цвет см "const" вверху 
   glFogf(GL_FOG_DENSITY,
              0.10 //плотность тумана
                  ); 
   glHint(GL_FOG_HINT, GL_DONT_CARE);
</pre>

<p>Вот пока и всё!</p>
<p><a href="https://www.ogldelphi.km.ru/about.html" target="_blank">https://www.ogldelphi.km.ru/about.html</a></p>
