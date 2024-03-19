---
Title: Как заставить InterBase принять COLLATE PXW\_CYRL по умолчанию?
Author: Nomadic
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как заставить InterBase принять COLLATE PXW\_CYRL по умолчанию?
===============================================================

(Это очень полезно при прямой работе с IB из различного
CASE-инструментария, типа PowerDesigner или ErWIN)

Чтобы не писать каждый раз COLLATE, я сделал следующее:

Создал сохранённую процедуру

    create procedure fix_character_sets
    as
    begin
     update
      rdb$character_sets
     set
      rdb$default_collate_name = 'PXW_CYRL'
     where
      rdb$character_set_name = 'WIN1251'
     and
      rdb$default_collate_name = 'WIN1251'
    ;
    end

Запустил ее один раз.

Создаю таблицы без указания COLLATE.

После восстановления из архива, запускаю еще раз.

