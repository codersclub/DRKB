---
Title: Как сделать свои собственные сообщения при компилляции?
Date: 01.01.2007
---


Как сделать свои собственные сообщения при компилляции?
=======================================================

::: {.date}
01.01.2007
:::

Формат команды:

    [{$MESSAGE HINT|WARN|ERROR|FATAL 'text string'}]

Например, добавление следующих строк приведёт  к появлению:

    {$MESSAGE 'Появился новый hint!'}
    {$MESSAGE Hint 'И это тоже hint!'}
    {$MESSAGE Warn 'А это уже Warning'}
    {$MESSAGE Error 'Эта строка вызовет ошибку компиляции!'}
    {$MESSAGE Fatal 'А это фатальная ошибка компиляции!'}

Пример:

    destructor TumbSelectionTempTable.Destroy;
    begin
      // Clear the temp tables.
    {$MESSAGE Warn ' - remember to free all allocated objects'}
      ClearAllOuterWorldFold;
      if FSubjectsTempTableCreated then
        DropTempTable(FTableName);
     
      FOuterWorldsFolded.Free;
      FQuery.Free;
      inherited;
    end;

Работает только в Дельфи 6/7
