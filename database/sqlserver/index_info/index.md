---
Title: Посмотреть информацию об индексах
Author: Vit
Date: 01.01.2007
---


Посмотреть информацию об индексах
=================================

Выполнить:

    dbcc showcontig(MyTable) with all_indexes

Результат:

    DBCC SHOWCONTIG scanning 'MyTable' table...
    Table: 'MyTable' (310448330); index ID: 1, database ID: 7
    TABLE level scan performed.
    - Pages Scanned................................: 22323
    - Extents Scanned..............................: 2810
    - Extent Switches..............................: 2830
    - Avg. Pages per Extent........................: 7.9
    - Scan Density [Best Count:Actual Count].......: 98.59% [2791:2831]
    - Logical Scan Fragmentation ..................: 0.40%
    - Extent Scan Fragmentation ...................: 83.45%
    - Avg. Bytes Free per Page.....................: 575.1
    - Avg. Page Density (full).....................: 92.90%

Запрос на больших таблицах может выполняться изрядное время так как
заставляет сканировать все листья дерева. Можно его ускорить, разрешив
собрать неполную информацию:

    dbcc showcontig(MyTable) with all_indexes, fast

Один из самых информативных показателей здесь:

    Scan Density [Best Count:Actual Count].......: 98.59% [2791:2831]

Чем выше плотность, чем она ближе к 100% тем быстрее будет работать
индекс при поиске. Если плотность маленькая возможно следует
переиндексировать таблицу или пересоздать индекс.(ВИСС IndexDefrag, DBCC
ReIndex)
