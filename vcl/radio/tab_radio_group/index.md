---
Title: Поведение TAB в компоненте TRadioGroup
Date: 01.01.2007
---


Поведение TAB в компоненте TRadioGroup
======================================

> При перемещении фокуса ввода клавишей Tab, чтобы переместить его в
> RadioGroup, нужно нажать клавишу Tab дважды, если какой нибудь пункт
> RadioGroup уже выбран, но только один раз если не выбран. Можно ли
> сделать поведение RadioGroup логичным?

Установка свойства RadioGroup\'ы TabStop в false должна решить эту
проблему - поскольку клавиша tab будет продолжать работать - перемещаясь
сразу на выделенный пункт RadioGroup.
