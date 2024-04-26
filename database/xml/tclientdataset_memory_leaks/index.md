---
Title: TClientDataSet: утечка памяти при загрузке XML
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


TClientDataSet: утечка памяти при загрузке XML
==============================================

**Суть проблемы:**

Hапpимеp, если делаем:

    ClientDataSet.LoadFromFile('c:\tmp\1.xml');
    ClientDataSet.Close;

то видим, что память выделилась, но не освободилась.

Если даже делать ClientDataSet.Create и ClientDataSet.Free то все pавно
будут утечки.

Пpобовал также пеpед закpытием:

    ClientDataSet.EmptyDataSet;
    ClientDataSet.CancelUpdates;
    ClientDataSet.LogChanges := False;
    ClientDataSet.MergeChangeLog;
    ClientDataSet.FieldDefs.Clear;
    ClientDataSet.IndexDefs.Clear;
    ClientDataSet.Params.Clear;
    ClientDataSet.Aggregates.Clear;
    ClientDataSet.IndexName := '';
    ClientDataSet.IndexFieldNames := '';

Все pавно не помогает.

Решения не нашел. Тестировал под D5 под W2000, W98.

Также брал midas.dll от D6. Проблема осталась.

**КОММЕНТАРИЙ**

Действительно, проверка показывает, что при загрузке данных из XML-файла
последующее закрытие ClientDataSet не освобождает часть выделенной
памяти. Трассировка VCL не выявила ничего подозрительного в открытом
коде TClientDataSet. Но часть операций производится COM-объектами,
которыми пользуется ClientDataSet и которые находятся в midas.dll.

Установлено, что утечка памяти отсутствует, если данные в ClientDataSet
поступают через провайдера, либо при загрузке из файла формата CDS (в
котором ClientDataSet сохраняет данные по-умолчанию).

Следовательно, мы имеем проблему при локальном использовании
ClientDataSet с файлом XML. Вероятно, в midas.dll при разборке файла XML
распределяется память под временные структуры данных, которая потом не
освобождается.

