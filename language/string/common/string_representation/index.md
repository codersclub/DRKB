---
Title: Как хранятся строки?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как хранятся строки?
====================

**Тип String:**

по смещению -4 хранится длина строки

по смещению -8 хранится счётчик ссылок на строку (когда он обнуляется
строка уничтожается)

Сама строка располагается в памяти как есть - каждая буква занимает 1
байт.

При копировании строки:

`s1:=s2` - реального копирования не происходит, увеличивается только
счётчик ссылок, но если после этого изменить одну из строк:

    s1:=s1+'a';

то произойдёт физическое копирование содержимого строк, и теперь s1 и s2
будут показывать на разные адреса памяти.

**Тип PChar:**

Длина строки определяется от начала до #0 байта, по сути это
чистой воды pointer, так что все действия по отслеживанию распределения
памяти лежат на программисте - сами заботьтесь о том чтобы хватило места
для распределения памяти и освобождении после использования.

Тоже одна буква = 1 байт.
Для хранения unicode (т.е. 2х байтовых символов)
используйте соответствующие символы с приставкой Wide...


**Примечание Fantasist\'a:**

Это верно только если s1 - локальная переменная, или s1 и s2 - обе не
локальные. Если s1 не локальная (глобальная или член класса), а s2 -
локальная, то происходит копирование!

