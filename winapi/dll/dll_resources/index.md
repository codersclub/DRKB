---
Title: DLL и ресурсы
Author: Mike Leftwich (Ensemble Corp)
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


DLL и ресурсы
=============

> ...я также имею проблемы с другими функциями DLL, которые ведут себя
> иначе, чем при первом обращении к ним!

Недавно я и сам закончил большой "DLL-проект", в котором столкнулся с
аналогичными проблемами. Я не знаком с вашим специфическим исключением,
которое вы упомянули, но я могу предложить некоторые общие советы по
поводу использования DLL.

Главное, что нужно помнить при разработке DLL - вы не должны допускать
ситуацию, при которой любое исключение осталось бы неперехваченным
(спасибо Pat Ritchey за столь мудрый совет). В теле экспортируемых
функций "заверните" все в блоки try..except (которые замечательно
обрабатываются Delphi).

Далее, любые ресурсы, которые вы явно создаете при открытии DLL, должны
создаваться в обработчике FormCreate (а не в секции Initialization) и
освобождаться в обработчике FormClose. Мне кажется, что при вызове DLL
(и использовании ее для распределения ресурсов) они не полностью
освобождается до тех пор, пока вызывающее приложение не будет закрыто, а
при вторичном вызове DLL не перегружается (это мои наблюдения, но,
похоже, они верны). По всей видимости, ресурсы, освобожденные в первый
раз, во время второго вызова не пересоздаются. У меня была масса проблем
до тех пор, пока в коде я не определил "нужное место" для освобождения
ресурсов. Но после того, как я переместил работу с ресурсами в
обработчики событий FormCreate и FormClose, GPF исчезли.

Кроме того, для освобождения ресурсов вы должны вместо метода Close или
Free использовать метод Release.

Ну и последний совет: вы должны быть очень осторожными при создании и
освобождении ресурсов в DLL и подходить к вопросу программирования очень
тщательно. Delphi может простить такую ошибку в EXE, но не в DLL.

Надеюсь я помог вам.

