---
Title: Помещение формы в поток
Author: Slawanix
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Помещение формы в поток
=======================

Delphi имеет в своем распоряжении классную функцию, позволяющую сделать это:

    procedure WriteComponentResFile(const FileName: string;
      Instance: TComponent);

Просто заполните имя файла, в котором вы хотите сохранить компонент, и
читайте его затем следующей функцией:

    function ReadComponentResFile(const FileName: string;
      Instance: TComponent): TComponent;

