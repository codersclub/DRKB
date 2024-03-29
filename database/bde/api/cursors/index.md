---
Title: Поддержка курсоров
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Поддержка курсоров
==================

Каждая функция, перечисленная ниже, возвращает информацию о курсоре или выполняет задачу,
связанную с курсором, например позиционирование курсора,
связывание курсоров, создание и закрытие курсоров, подсчет записей, связанных с курсором,
фильтрацию, установку и сравнение закладки (bookmark)
и обновление всех буферов, связанных с курсором.

DbiActivateFilter
: Активирует фильтр.

DbiAddFilter
: Добавляет фильтр в таблицу, но не активирует фильтр (набор записей еще не изменен).

DbiApplyDelayedUpdates
: Когда уровень курсора кэшированных обновлений активен, записывает все изменения,
внесенные в кэшированные данные, в базовую базу данных.

DbiBeginDelayedUpdates
: Создает слой курсора кэшированных обновлений,
чтобы пользователи могли вносить расширенные изменения
во временно кэшированные данные таблицы без записи в реальную таблицу,
тем самым сводя к минимуму блокировку ресурсов.

DbiBeginLinkMode
: Преобразует курсор в курсор ссылки.
Учитывая открытый курсор, готовится к связанному доступу.
Возвращает новый курсор.

DbiCloneCursor
: Создает новый курсор (курсор-клон), который имеет тот же набор результатов,
что и данный курсор (курсор-источник).

DbiCloseCursor
: Закрывает ранее открытый курсор.

DbiCompareBookMarks
: Сравнивает относительные позиции двух закладок в наборе результатов, связанных с курсором.

DbiDeactivateFilter
: Временно останавливает указанный фильтр от воздействия на набор записей, отключив фильтр.

DbiDropFilter
: Деактивирует и удаляет фильтр из памяти, а также освобождает все ресурсы.

DbiEndDelayedUpdates
: Закрывает слой курсора кэшированных обновлений, завершая режим кэшированных обновлений.

DbiEndLinkMode
: Завершает режим связанного курсора и возвращает исходный курсор.

DbiExtractKey
: Извлекает значение ключа для текущей записи данного курсора
или из предоставленного буфера записей.

DbiForceRecordReread
: Перечитывает одну запись с сервера по требованию, обновляя только одну строку,
а не очищая кеш.

DbiForceReread
: При необходимости обновляет все буферы, связанные с курсором.

DbiFormFullName
: Возвращает полное имя таблицы.

DbiGetBookMark
: Сохраняет текущую позицию курсора в предоставленный клиентом буфер,
называемый закладкой (bookmark).

DbiGetCursorForTable
: Находит курсор для данной таблицы.

DbiGetCursorProps
: Возвращает свойства курсора.

DbiGetExactRecordCount
: Получает текущее точное количество записей, связанных с курсором.
НОВАЯ ФУНКЦИЯ BDE 4.0

DbiGetFieldDescs
: Получает список дескрипторов для всех полей таблицы, связанной с курсором.

DbiGetLinkStatus
: Возвращает статус ссылки курсора.

DbiGetNextRecord
: Извлекает следующую запись в таблице, связанной с курсором.

DbiGetPriorRecord
: Извлекает предыдущую запись в таблице, связанной с данным курсором.

DbiGetProp
: Возвращает свойство объекта.

DbiGetRecord
: Извлекает текущую запись, если таковая имеется, в таблице, связанной с курсором.

DbiGetRecordCount
: Получает текущее количество записей, связанных с курсором.

DbiGetRecordForKey
: Находит и извлекает запись, соответствующую ключу, и помещает курсор на эту запись.

DbiGetRelativeRecord
: Позиционирует курсор на записи в таблице относительно текущей позиции курсора.

DbiGetSeqNo
: Извлекает порядковый номер текущей записи в таблице, связанной с курсором.

DbiLinkDetail
: Устанавливает связь между двумя таблицами таким образом,
что в подробной таблице (detail table) набор записей ограничен набором записей,
соответствующих значениям связывающего ключа курсора основной таблицы.

DbiLinkDetailToExp
: Связывает подробный курсор с главным курсором с помощью выражения.

DbiMakePermanent
: Изменяет временную таблицу, созданную DbiCreateTempTable, на постоянную таблицу.

DbiOpenTable
: Открывает данную таблицу для доступа и связывает дескриптор курсора с открытой таблицей.

DbiResetRange
: Удаляет ограниченный диапазон указанной таблицы, ранее установленный функцией DbiSetRange.

DbiSaveChanges
: Принудительно сохраняет на диск все обновленные записи, связанные с курсором.

DbiSetFieldMap
: Устанавливает карту полей таблицы, связанной с данным курсором.

DbiSetProp
: Устанавливает указанное свойство объекта в заданное значение.

DbiSetRange
: Устанавливает диапазон результирующего набора, связанного с курсором.

DbiSetToBegin
: Устанавливает курсор на BOF (непосредственно перед первой записью).

DbiSetToBookMark
: Помещает курсор в место, сохраненное в указанной закладке.

DbiSetToCursor
: Устанавливает положение одного курсора (курсора назначения)
на положение другого (курсора источника).

DbiSetToEnd
: Устанавливает курсор на EOF (сразу после последней записи).

DbiSetToKey
: Позиционирует курсор на основе индекса на значение ключа.

DbiSetToRecordNo
: Устанавливает курсор таблицы dBASE на заданный номер физической записи.

DbiSetToSeqNo
: Устанавливает курсор на указанный порядковый номер таблицы Paradox.

DbiUnlinkDetail
: Удаляет линк между двумя курсорами.
