---
Title: FindKey для нескольких полей
Date: 01.01.2007
---


FindKey для нескольких полей
============================

::: {.date}
01.01.2007
:::

    with Table1 do
      begin
        SetKey;
        FieldByName('State').AsString := 'CA';
        FieldByName('City').AsString := 'Scotts Valley';
        GotoKey;
      end;

Вы не можете использовать Findkey с файлами DBase более чем для одного
поля.

    oEmetb.indexName:='PrimaryKey';
    if oEmeTb.findkey([prCLient,prDiv,prEme]) then 

где findkey передаются параметры для Primary Keyfields.

Я обращаю ваше внимание на то, что имя индекса (Index) чувствительно к
регистру, так что будьте внимательны.

Вы можете также воспользоваться oEmeTb.indexfieldnames, но убедитесь в
том, что ваш список ключевых полей в точности соответствуют ключевым
полям, которые вы ищете.

    oEmetb.indexfieldNames:='EmeClient;EmeDiv;EmeNo';
    if oEmeTb.findkey([123,'A',96]) then

Взято с <https://delphiworld.narod.ru>
