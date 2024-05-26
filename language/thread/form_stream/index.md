---
Title: Помещение формы в поток
Author: Slawanix
Date: 01.01.2007
---


Помещение формы в поток
=======================

::: {.date}
01.01.2007
:::

Delphi имеет в своем распоряжении классную функцию, позволяющую сделать
это:

    procedure WriteComponentResFile(const FileName: string;
      Instance: TComponent);

Просто заполните имя файла, в котором вы хотите сохранить компонент, и
читайте его затем следующей функцией:

    function ReadComponentResFile(const FileName: string;
      Instance: TComponent): TComponent;

Автор: Slawanix

Взято с Vingrad.ru <https://forum.vingrad.ru>
