---
Title: TClientDataSet: некорректное формирование XML
Date: 01.01.2007
---


TClientDataSet: некорректное формирование XML
=============================================

::: {.date}
01.01.2007
:::

Delphi5 build 5.62, midas.dll v5.0.5.63

При использовании SaveToFile(\'file.xml\', dfXML) формируется
некорректный текст XML, если набор данных содержит изменения, т.е. при
непустом Delta.

Пример:

Набор данных состоит их двух полей

IntField: integer

StrField: string(20)

После ввода

1    aaa

2    bbb

3    ccc

4    ddd

и сохранения текст XML имеет вид:

    <?xml version="1.0" standalone="yes"?>  <DATAPACKET Version="2.0">
    <METADATA><FIELDS><FIELD attrname="IntField" fieldtype="i4"/>
    <FIELD attrname="StrField" fieldtype="string" WIDTH="20"/></FIELDS>
    <PARAMS CHANGE_LOG="1 0 4 2 0 4 3 0 4 4 0 4"/></PARAMS></METADATA>
    <ROWDATA><ROW RowState="4" IntField="1" StrField="aaa"/>
    <ROW RowState="4" IntField="2" StrField="bbb"/>
    <ROW RowState="4" IntField="3" StrField="ccc"/>
    <ROW RowState="4" IntField="4" StrField="ddd"/>
    </ROWDATA></DATAPACKET>

Ошибочным явлается наличие тэга \</PARAMS\>, т.к. открывающий тэг
\<PARAMS.../\> уже содержит ограничитель \"/\"

После вызова MergeChangeLog, CancelUpdates или ApplyUpdates сохраняется
корректный XML.

КОММЕНТАРИЙ

Проблема заключена именно в midas.dll. При проверке в Delphi 5 update
pack 1 (build 6.18) баг не проявляется - XML формируется корректно. Если
же сменить midas.dll на старую - версии 5.0.5.63 - получаем
вышеописанный результат.

Скачать тест StoneTest\_22.zip (2.3K)

Мораль сей басни такова: ставьте свежие сервиспаки.

Взято с <https://delphiworld.narod.ru>
