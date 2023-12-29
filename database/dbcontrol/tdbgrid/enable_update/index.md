---
Title: Как в TDBGrid pазpешить только опеpации UPDATE записей?
Date: 01.01.2007
---


Как в TDBGrid pазpешить только опеpации UPDATE записей?
=======================================================

::: {.date}
01.01.2007
:::

А я делаю так. На DataSource, к которому прицеплен Grid, вешаю
обработчик на событие OnStateChange. Ниже текст типичного обратчика

    if DBGrid1.DataSource.DataSet.State in [dsEdit, dsInsert] then
      DBGrid1.Options := DBGrid1.Options + goRowSelect
    else
      DBGrid1.Options := DBGrid1.Options - goRowSelect;

Дело в том, что если у Grid\'а стоит опция goRowSelect, то из Grid\'а
невозможно добавить запись. Ну а когда програмно вызываешь
редактирование или вставку, то курсор принимает обычный вид и все Ok.

Лучше использовать конструкцию "State in dsEditModes"

Взято с <https://delphiworld.narod.ru>
