---
Title: OpenGL в Delphi. Часть 2. Туман
Date: 01.01.2007
Source: <https://www.ogldelphi.km.ru/about.html>
---


OpenGL в Delphi. Часть 2. Туман
===============================

Мы сегодня будем работать с туманом... Во всех предыдущих примерах
использовался туман,
но его действия вы наверное не замечали, но теперь вы это ощутите.

Объявим константу

    const 
      fogColor : array[0..3] of GLfloat = (0.7, 0.7, 0.7, 2.0); //цвет тумана 

Циферки в конце устанавливают следующее:

(0.7, 0.7, 0.7, 2.0) 1-ая - красный, 2-ая - синий, 3-ая - зелёный,
ну а четвёртая - альфа-канал

Далее переменные:

    var
    fogMode : GLint;

Перед тем как юзать, его надо включить:

    glEnable(GL_FOG);
    fogMode := GL_EXP; 
    glFogi(GL_FOG_MODE, fogMode); 
    glFogfv(GL_FOG_COLOR, @fogColor);//устанавливаем цвет см "const" вверху 
    glFogf(GL_FOG_DENSITY,
           0.10 //плотность тумана
          ); 
    glHint(GL_FOG_HINT, GL_DONT_CARE);

Вот пока и всё!

