---
Title: OpenGL в Delphi. Часть 3. Quadric-объекты
Date: 01.01.2007
Source: <https://www.ogldelphi.km.ru/about.html>
---


OpenGL в Delphi. Часть 3. Quadric-объекты
=========================================

В разделе переменных укажим:

    quadObj : NewQuadricObj;

а далее пишем следующее (я просто прокомментирую код)

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
      gluCylinder (quadObj, 0.5, 0.5, 2.9, 30, 30);//0.5 - радиус, 0.5 - радиус, 2.9 - высота
      glPopMatrix;
      gluDeleteQuadric(quadObj);

Вот и всё!

